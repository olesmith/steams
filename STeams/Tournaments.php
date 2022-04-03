<?php

include_once("Common.php");
//include_once("Tournaments/CLI.php");
include_once("Tournaments/API.php");
include_once("Tournaments/Access.php");
include_once("Tournaments/Read.php");
include_once("Tournaments/Update.php");
include_once("Tournaments/Handle.php");


include_once("Common/JSON.php");

class Tournaments extends Common
{
    use
        //Tournaments_CLI,
        Tournaments_API,
        Tournaments_Access,
        Tournaments_Read,
        Tournaments_Update,
        Tournaments_Handle,
        JSON;
    

    var $__Tournament__=array();
    var $__Season__=array();
    
    
    
    //*
    //* function Tournaments, Parameter list: $args=array()
    //*
    //* Constructor.
    //*

    function Tournaments($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=
            array
            (
                "Type","Name","Title","NTeams","Season",
                "StartDate","EndDate",
                "Country","Continent",
                "HomeAndAway","API_Matches_Latency",
            );
        $this->Sort=array("Name");
        $this->IDGETVar="Tournament";
        
        $this->CellMethods[ "Tournament_Cell_Public_URL" ]=TRUE;
        $this->CellMethods[ "Tournament_Cell_Mobile_URL" ]=TRUE;
    }

    //*
    //* Overrides SqlTableName, prepending period id.
    //* Calls ApplicationObj->SqlPeriodTableName.
    //*

    function SqlTableName($table="")
    {
        if (empty($table)) { $table="Tournaments"; }
        
        return $table;
    }

    //*
    //* 
    //*

    function Sql_Tournament_Table($module)
    {
       
    }

    //*
    //* Updates table structure of derived modules: Teams, Matches and Groups
    //*

    function Sql_Tournament_Update_Structures()
    {
        //var_dump("Upd");
        $this->Tournament_SeasonsObj()->Sql_Table_Structure_Update();
        $this->Tournament_TeamsObj()->Sql_Table_Structure_Update();
        $this->Tournament_GroupsObj()->Sql_Table_Structure_Update();
        $this->Tournament_MatchesObj()->Sql_Table_Structure_Update();       
    }

    //*
    //* Centralized reading for Tournament. Called by Common.php.
    //*

    function Tournament($key="")
    {
        if (empty($this->__Tournament__))
        {
            $this->__Tournament__=
                $this->Sql_Select_Hash
                (
                    array("ID" => $this->CGI_POSTOrGETint("Tournament"))
                );
            
            $this->Sql_Tournament_Update_Structures();
        }

        if
            (
                !empty($this->__Tournament__)
                &&
                empty($this->__Season__)
            )
        {
            $this->__Season__=
                $this->Tournament_Read_Season($this->__Tournament__);
            
        }

        if
            (
                !empty($this->__Tournament__)
                &&
                !empty($this->__Season__)
            )
        {
            $this->Tournament_API_Make
            (
                $this->__Tournament__,
                $this->__Season__              
            );
        }

        if (!empty($key))
        {
            //Data fetched from Season
            if
                (
                    !empty($this->__Season__)
                    &&
                    !empty
                    (
                        $this->Tournament_SeasonsObj()->__Data_From_Tournaments[ $key ]
                    )
                )
            {
                return $this->Season($key);
            }

            return $this->__Tournament__[ $key ];
        }
        
        return $this->__Tournament__;
    }

    //*
    //* Centralized reading for Season. Called by Common.php.
    //*

    function Season($key="")
    {
        if (empty($this->__Season__))
        {
            $this->Tournament();
        }

        if (!empty($key))
        {
            return $this->__Season__[ $key ];
        }
        
        return $this->__Season__;
    }
    
    //*
    //* 
    //*

    function PreProcessItemData()
    {
       array_push
       (
           $this->ItemDataFiles,
           "Data.Seasons.php",
           "Data.API.php",
           "Data.API.Tournament.php",
           "Data.API.Teams.php",
           "Data.API.Matches.php"
       );
    }
    
    //*
    //* Post process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PostProcessItemData()
    {
        //parent::PostProcessItemData();
    }

    //*
    //* Runs right after module has finished initializing.
    //*

    function PostInit()
    {
        //parent::PostInit();
    }

    //*
    //* Postprocesses and returns $item.
    //*

    function PostProcess($item)
    {
        $module=$this->GetGET("ModuleName");
        if ($module!=$this->ModuleName)
        {
            return $item;
        }

        if (!isset($item[ "ID" ]) || $item[ "ID" ]==0) { return $item; }

        $this->Tournament_Rounds_Matrix($item);

        $updatedatas=array();
        if (!empty($item[ "Type" ]) && $item[ "Type" ]==1)//club
        {
            if (!empty($item[ "Country" ]))
            {
                $continent=
                    $this->CountriesObj()->Sql_Select_Hash_Value
                    (
                        $item[ "Country" ],
                        "Continent"
                    );

                if
                    (
                        empty($item[ "Continent" ])
                        ||
                        $item[ "Continent" ]!=$continent
                    )
                {
                    $item[ "Continent" ]=$continent;
                    array_push($updatedatas,"Continent");
                }
            }
        }

        $seasons=
            $this->Sql_Select_Hashes
            (
                array
                (
                    "Tournament" => $item[ "ID" ],
                ),
                array
                (
                    "ID","Year"
                ),
                $orderby="Year",$postprocess=FALSE,
                $table="Tournament_Seasons"
            );

        $season=array_pop($seasons);
        if
            (
                empty($item[ "Season" ])
                ||
                $item[ "Season" ]!=$season[ "ID" ]
            )
        {
            $item[ "Season" ]=$season[ "ID" ];
            array_push($updatedatas,"Season");
        }

        if (count($updatedatas)>0)
        {
            $this->Sql_Update_Item_Values_Set($updatedatas,$item);
        }
        
        return $item;
    }

    //*
    //* Read Group and teams IDs into $tournament.
    //*

    function Tournament_Rounds_Matrix(&$tournament)
    {
        if (empty($tournament)) { $tournament=$this->Tournament(); }

        if (empty($tournament[ "Groups" ]))
        {
            $tournament[ "Groups" ]=array();
            
            $max=-1;
            foreach
                (
                    $this->Tournament_TeamsObj()->Sql_Select_Unique_Col_Values
                    (
                        "Tournament_Group",
                        array(),"",
                        $this->Tournament_Sql_Table
                        (
                            "Tournament_Teams",
                            $tournament
                        )
                    )
                    as $group_id
                )
            {
                $tournament[ "Groups" ][ $group_id ]=array();
            
                $tournament[ "Groups" ][ $group_id ]=
                    $this->Tournament_TeamsObj()->Sql_Select_Unique_Col_Values
                    (
                        "Team",
                        array
                        (
                            "Tournament_Group" => $group_id,
                        ),
                        "",
                        $this->Tournament_Sql_Table
                        (
                            "Tournament_Teams",
                            $tournament
                        )
                    );

            }
            
            $this->Tournament_Rounds_N($tournament);
        }

        return $tournament;
    }
    
    //*
    //* Detect number of rounds.
    //*

    function Tournament_Rounds_N(&$tournament)
    {
        $max=-1;
        foreach (array_keys($tournament[ "Groups" ]) as $group_id)
        {        
            if (count($tournament[ "Groups" ][ $group_id ])>$max)
            {
                $max=count($tournament[ "Groups" ][ $group_id ]);
            }

            
        }

        $fact=1;
        if ($tournament[ "HomeAndAway" ]==1)
        {
            $fact=2;
        }
        
        $tournament[ "NRounds" ]=$fact*($max-1);
        
        return $tournament[ "NRounds" ];
    }

    //*
    //*
    //*

    function Tournament_Public_URL($edit=0,$tournament=array(),$data="")
    {
        return
            $this->CGI_Script_Protocol().
            "://".
            $this->CGI_Server_Name().
            $this->CGI_Script_Path().
            "?".
            "Tournament=".$this->Tournament("ID").
            "&".
            "Action=Start".
            "";
    }
    
    //*
    //*
    //*

    function Tournament_Cell_Public_URL($edit=0,$tournament=array(),$data="")
    {
        if (empty($tournament))
        {
            return "Public URL:";
        }      

        $url=
            $this->Tournament_Public_URL($edit,$tournament,$data).
            "&".
            "Mobile=1".
            "";

        return
            $this->Htmls_A
            (
                $url,
                $url,
                array("TARGET" => '_blank')
            );
    }


    
    //*
    //*
    //*

    function Tournament_Cell_Mobile_URL($edit=0,$tournament=array(),$data="")
    {
        if (empty($tournament))
        {
            return "Mobile URL:";
        }      

        $url=
            $this->Tournament_Public_URL($edit,$tournament,$data).
            "&".
            "Mobile=1".
            "";

        return
            $this->Htmls_A
            (
                $url,
                $url,
                array("TARGET" => '_blank')
            );
    }

}

?>