<?php

include_once("Common.php");
include_once("Teams/Access.php");
include_once("Teams/CLI.php");
include_once("Teams/API.php");

class Teams extends Common
{
    use
        Teams_Access,
        Teams_CLI,
        Teams_API;
    

    //*
    //* function Teams, Parameter list: $args=array()
    //*
    //* Constructor.
    //*

    function Teams($args=array())
    {
        $language=$this->CGI_GETOrCOOKIE("Lang");

        if (!empty($language)) { $language="_".$language;}
        
        $this->Hash2Object($args);
        $this->AlwaysReadData=
            array
            (
                "Name".$language,
                "Title".$language,
                "NTeams",
                "Type",
                "API_ID",
            );
        
        $this->ItemNamer="Name".$language;
        $this->Sort=array("Name".$language);
        $this->IDGETVar="Team";
        $this->NItemsPerPage=50;
        
        if (!empty($_GET[ "Tournament" ]))
        {
            $this->SqlWhere=
                array
                (
                    "Type" => $this->Tournament("Type"),
                );
        }

        
    }

    //*
    //* Overrides SqlTableName, prepending period id.
    //* Calls ApplicationObj->SqlPeriodTableName.
    //*

    function SqlTableName($table="")
    {
        if (empty($table)) { $table="Teams"; }
        
        return $table;
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
        $language="_".$this->MyLanguage_Get();

        $this->AlwaysReadData=
            array
            (
                "Initials".$language,
                "Name".$language,
                "Title".$language,
                "NTeams"
            );
        
        $this->ItemNamer="Name".$language;
        $this->Sort=array("Name".$language);                
        $this->ItemData[ "Name".$language ][ "Search" ]=True;               
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

        $updatedatas=array();
        if (!empty($item[ "Type" ]))// && $item[ "Type" ]==1)//club
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

        $this->Sql_Select_Hash_Datas_Read
        (
            $item,
            array("Icon","Icon_URL","API_ID","API_Last","API_Status","API_Result")
        );

        //var_dump($item);
        if
            (
                time()-$item[ "API_Last" ]>10
            )
        {
            $this->Team_API_Retrieve($item);
            //var_dump($item[ "Icon_URL" ]);
        }

        if
            (
                !empty($item[ "Icon_URL" ])
                //&&
                //empty($item[ "Icon" ])
            )
        {
            //var_dump("IIIIII",$item[ "Icon_URL" ].": ".$item[ "Icon" ]);
        }
        
        if (count($updatedatas)>0)
        {
            $this->Sql_Update_Item_Values_Set($updatedatas,$item);
        }

        return $item;
    }

    //*
    //* Postprocesses and returns $item.
    //*

    function Teams_Tournament($tournament=array())
    {
        if (empty($tournament)) { $tournament=$this->Tournament(); }

        return
            $this->Sql_Select_Hashes
            (
                $this->Teams_Tournament_Where($tournament)
            );
    }
        
    //*
    //* Postprocesses and returns $item.
    //*

    function Teams_Tournament_Where($tournament=array())
    {
        if (empty($tournament)) { $tournament=$this->Tournament(); }

        $where=array("Type" => $tournament[ "Type" ]);
        if ($tournament[ "Type" ]==1)//Club
        {
            if (!empty($tournament[ "Country" ]))
            {
                $where[ "Country" ]=$tournament[ "Country" ];
            }
        }
        elseif ($tournament[ "Type" ]==2)//National team
        {
            if (!empty($tournament[ "Continent" ]))
            {
                $where[ "Country" ]=
                    $this->CountriesObj()->Sql_Select_Unique_Col_Values
                    (
                        "ID",
                        array("Continent" => $tournament[ "Continent" ])
                    );
            }
        }

        return $where;
    }

    var $__Teams__=array();
    
    //*
    //* Acessors for Teams.
    //*

    function Team_Read($teamid,$key="",$language=True)
    {
        if (empty($this->__Teams__[ $teamid ]))
        {
            $this->__Teams__[ $teamid ]=
                $this->Sql_Select_Hash
                (
                    array("ID" => $teamid)
                );
        }

        if (!empty($key))
        {
            if (preg_match('/^(Name|Title|Initials)$/',$key))
            {
                $key.="_".$this->MyLanguage_Get();
            }
        
            return $this->__Teams__[ $teamid ][ $key ];
        }
        
        return $this->__Teams__[ $teamid ];
    }
    
    //*
    //* Acessors for Teams.
    //*

    function Team_Name($teamid,$key="Name")
    {
        return $this->Team_Read($teamid,$key);
            
    }

    //*
    //* 
    //*

    function Team_Icon($team_id)
    {
        if (empty($team_id)) { return ""; }
        
        $namer="Name_".$this->MyLanguage_Get();
        $data="Icon";
        $api_data="Icon_URL";

        $team=
            $this->Sql_Select_Hash
            (
                array("ID" => $team_id),
                array($data,$namer,$api_data)
            );

        $icon="*";
        if (!empty($team[ $data ]))
        {
            $icon=
                $this->MyMod_Data_Fields_File_Decorator_Download_IMG
                (
                    $this->Sql_Select_Hash
                    (
                        array("ID" => $team_id),
                        array($data,$namer)
                    ),
                    $data
                );
        }
        elseif (!empty($team[ $api_data  ]))
        {
            $title="external icon: ".$team[ $api_data  ];
            $icon=
                $this->Html_IMG
                (
                    $team[ $api_data  ],
                    $alttext=$title,
                    array
                    (
                        "WIDTH" => '20px',
                        "TITLE" => $title,
                    )
                );
        }
                
        return $icon;
    }

}

?>