<?php

include_once("Common.php");

include_once("Tournaments/Teams/Access.php");
include_once("Tournaments/Teams/Create.php");
include_once("Tournaments/Teams/API.php");
include_once("Tournaments/Teams/Icon.php");
include_once("Tournaments/Teams/Matches.php");

class Tournament_Teams extends Common
{
    use
        Tournaments_Teams_Access,
        Tournaments_Teams_API,
        Tournaments_Teams_Icon,
        Tournaments_Teams_Create,
        Tournaments_Teams_Matches;
    

    var $___Teams___=array();
    
    //*
    //* function Teams, Parameter list: $args=array()
    //*
    //* Constructor.
    //*

    function Tournament_Teams($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=array("Tournament","Team","Group",);
        $this->Sort=array("Name");

        $this->CellMethods[ "Tournament_Team_Icon" ]=True;
        $this->CellMethods[ "Tournament_Team_Initials" ]=True;
        $this->CellMethods[ "Tournament_Team_Points" ]=True;

        //$this->IDGETVar="Team";
    }

    //*
    //* Overrides SqlTableName, prepending period id.
    //* Calls ApplicationObj->SqlPeriodTableName.
    //*

    function SqlTableName($table="")
    {
        if (empty($table))
        {
            $table=$this->Tournament_Sql_Table($this->ModuleName);
        }
        
        return $table;
    }

    
    //*
    //* Post process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PreProcessItemData()
    {
    }

    //*
    //* Post process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PostProcessItemData()
    {
        $this->TeamsObj()->ItemData();
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

    function PostProcess($item,$force=False)
    {
        if (!$force && $this->GetGET("ModuleName")!=$this->ModuleName)
        {
            return $item;
        }
 
        if (empty($item[ "ID" ])) { return $item; }

        $updatedatas=array();
        if (!empty($item[ "Team" ]))
        {
            $name=
                $this->TeamsObj()->Sql_Select_Hash_Value
                (
                    $item[ "Team" ],
                    "Initials_".$this->MyLanguage_GET()
                );
            
            if
                (
                    empty($item[ "Name" ])
                    ||
                    $item[ "Name" ]!=$name
                )
            {
                $item[ "Name" ]=$name;
                array_push($updatedatas,"Name");
            }
        }

        $this->PostProcess_Points($item,$updatedatas);
        $this->PostProcess_Goals($item,$updatedatas);
        $this->PostProcess_Matches($item,$updatedatas);

        if (count($updatedatas)>0)
        {
            $this->Sql_Update_Item_Values_Set($updatedatas,$item);
        }

        /* $team= */
        /*    $this->TeamsObj()->Sql_Select_Hash */
        /*     ( */
        /*         array("ID" => $item[ "Team" ]), */
        /*         array("ID","Icon","Icon_URL") */
        /*     ); */

        /* var_dump($team); */
        
        return $item;
    }
    
    //*
    //* 
    //*

    function PostProcess_Matches(&$team,&$updatedatas)
    {            
        $data="Matches_Home";
        $n1=$this->Tournament_Team_Matches_Home($team);
        if
            (
                empty($team[ $data ])
                ||
                $team[ $data ]!=$n1
            )
        {
            $team[ $data ]=$n1;
            array_push($updatedatas,$data);
        }
        
        $data="Matches_Away";        
        $n2=$this->Tournament_Team_Matches_Away($team);
        if
            (
                empty($team[ $data ])
                ||
                $team[ $data ]!=$n2
            )
        {
            $team[ $data ]=$n2;
            array_push($updatedatas,$data);
        }
        
        $data="Matches_Total";        
        $n=$n1+$n2;
        if
            (
                empty($team[ $data ])
                ||
                $team[ $data ]!=$n
            )
        {
            $team[ $data ]=$n;
            array_push($updatedatas,$data);
        }

        
        $data="Matches_Victory";
        $n=$this->Tournament_Team_Victories($team);
        
        if
            (
                empty($team[ $data ])
                ||
                $team[ $data ]!=$n
            )
        {
            $team[ $data ]=$n;
            array_push($updatedatas,$data);
        }
        
        $data="Matches_Defeat";
        $n=$this->Tournament_Team_Defeats($team);
        if
            (
                empty($team[ $data ])
                ||
                $team[ $data ]!=$n
            )
        {
            $team[ $data ]=$n;
            array_push($updatedatas,$data);
        }
        
        $data="Matches_Draw";
        $n=$this->Tournament_Team_Draws($team);
        if
            (
                empty($team[ $data ])
                ||
                $team[ $data ]!=$n
            )
        {
            $team[ $data ]=$n;
            array_push($updatedatas,$data);
        }
    }
    
    //*
    //* 
    //*

    function PostProcess_Goals(&$team,&$updatedatas)
    {
        $where=
            array
            (
                "Tournament" => $team[ "Tournament" ],
                "Season"     => $team[ "Season" ],
                "Status"     => array(2,3),
                "Tournament_Group" => $team[ "Tournament_Group" ],
            );
        
        $own_goals=
            $this->MatchesObj()->Sql_Select_Calc
            (
                $this->Tournament_Team_Matches_Where
                (
                    $team,"Team1"
                ),
                "Goals1",
                "Sum"
            )
            +
            $this->MatchesObj()->Sql_Select_Calc
            (
                $this->Tournament_Team_Matches_Where
                (
                    $team,"Team2"
                ),
                "Goals2",
                "Sum"
            );

        $data="Goals_Favor";        
        $n=$own_goals;
        if
            (
                empty($team[ $data ])
                ||
                $team[ $data ]!=$n
            )
        {
            $team[ $data ]=$n;
            array_push($updatedatas,$data);
        }
        
        $other_goals=
            $this->MatchesObj()->Sql_Select_Calc
            (
                $this->Tournament_Team_Matches_Where
                (
                    $team,"Team1"
                ),
                "Goals2",
                "Sum"
            )
            +
            $this->MatchesObj()->Sql_Select_Calc
            (
                $this->Tournament_Team_Matches_Where
                (
                    $team,"Team2"
                ),
                "Goals1",
                "Sum"
            );
        
        $data="Goals_Against";        
        $n=$other_goals;
        if
            (
                empty($team[ $data ])
                ||
                $team[ $data ]!=$n
            )
        {
            $team[ $data ]=$n;
            array_push($updatedatas,$data);
        }
        
        $data="Goals_Total";        
        $n=$own_goals-$other_goals;
        if
            (
                empty($team[ $data ])
                ||
                $team[ $data ]!=$n
            )
        {
            $team[ $data ]=$n;
            array_push($updatedatas,$data);
        }
    }
    
    //*
    //* 
    //*

    function PostProcess_Points(&$team,&$updatedatas)
    {
        $nhome=
            $this->MatchesObj()->Sql_Select_Calc
            (
                $this->Tournament_Team_Matches_Where
                (
                    $team,"Team1"
                ),
                "Points1",
                "Sum"
            );

        $naway=
            $this->MatchesObj()->Sql_Select_Calc
            (
                $this->Tournament_Team_Matches_Where
                (
                    $team,"Team2"
                ),
                "Points2",
                "Sum"
            );

        $data="Points_Home";        
        $n=$nhome;
        if
            (
                empty($team[ $data ])
                ||
                $team[ $data ]!=$n
            )
        {
            $team[ $data ]=$n;
            array_push($updatedatas,$data);
        }
        
        $data="Points_Away";        
        $n=$naway;
        if
            (
                empty($team[ $data ])
                ||
                $team[ $data ]!=$n
            )
        {
            $team[ $data ]=$n;
            array_push($updatedatas,$data);
        }
        
        $data="Points_Total";        
        $n=$nhome+$naway;
        if
            (
                empty($team[ $data ])
                ||
                $team[ $data ]!=$n
            )
        {
            $team[ $data ]=$n;
            array_push($updatedatas,$data);
        }   
   }
    

    //*
    //* Read team.
    //*

    function Tournament_Team($item)
    {
        if (empty($this->___Teams___[ $item[ "Team" ] ]))
        {
            $this->___Teams___[ $item[ "Team" ] ]=
                $this->TeamsObj()->Sql_Select_Hash
                (
                    array("ID" => $item[ "Team" ])
                );
        }

        return $this->___Teams___[ $item[ "Team" ] ];
    }
    
    //*
    //* Replicates real $team data.
    //*

    function Tournament_Team_Field($item,$field)
    {
        //var_dump($item);
        if (empty($item))
        {
            return
                $this->TeamsObj()->MyMod_Data_Title($field);
        }
        
        return
            $this->TeamsObj()->MyMod_Data_Fields_Show
            (
                $field,
                $this->Tournament_Team($item)
            );
            
    }
    
    //*
    //* 
    //*

    function Tournament_Team_Initials($edit,$item,$data)
    {
        return
            $this->Tournament_Team_Field($item,"Initials");            
    }
    //*
    //* 
    //*

    function Tournament_Team_Icon($edit,$item,$data)
    {
        return
            $this->Tournament_Team_Field($item,"Icon");            
    }

    
    //*
    //* 
    //*

    function Tournament_Team_Points($edit,$team,$data)
    {
        if (empty($team))
        {
            return $this->MyLanguage_GetMessage("Points");
        }
        
        return
            $this->Tournament_Team_Points_Home($team);            
    }
            
    //*
    //* 
    //*

    function Tournament_Team_Matches_Where($team,$teamkey,$where=array())
    {
        return
            array_merge
            (
                array
                (
                    "Tournament" => $team[ "Tournament" ],
                    "Season"     => $team[ "Season" ],
                     $teamkey    => $team[ "Team" ],
                    "Status"     => array(2,3),
                    "Tournament_Group" => $team[ "Tournament_Group" ],
                ),
                $where
            );
                
    }
    
    //*
    //* 
    //*

    function Tournament_Team_Points_Home($team)
    {
        return
            sprintf("%02d",
            $this->MatchesObj()->Sql_Select_Calc
            (
                $this->Tournament_Team_Matches_Where
                (
                    $team,"Team1"
                ),
                "Points1",
                "Sum"
            ));
    }
    
    //*
    //* 
    //*

    function Tournament_Team_Points_Away($team)
    {
        return
            $this->MatchesObj()->Sql_Select_Calc
            (
                $this->Tournament_Team_Matches_Where
                (
                    $team,"Team2"
                ),
                "Points2",
                "Sum"
            );
    }
    
    //*
    //* 
    //*

    function Tournament_Team_Victories($team)
    {
        return
            $this->MatchesObj()->Sql_Select_NHashes
            (
                $this->Tournament_Team_Matches_Where
                (
                    $team,
                    "Team1",
                    array
                    (
                        "__Winner__" => "Goals1>Goals2",
                    )
                )
            )
            +
            $this->MatchesObj()->Sql_Select_NHashes
            (    
                $this->Tournament_Team_Matches_Where
                (
                    $team,
                    "Team2",
                    array
                    (
                        "__Winner__" => "Goals2>Goals1",
                    )
                )
            );

    }
    
    //*
    //* 
    //*

    function Tournament_Team_Defeats($team)
    {
         return
            $this->MatchesObj()->Sql_Select_NHashes
            (        
                $this->Tournament_Team_Matches_Where
                (
                    $team,
                    "Team1",
                    array
                    (
                        "__Winner__" => "Goals1<Goals2",
                    )
                )
            )
            +
            $this->MatchesObj()->Sql_Select_NHashes
            (       
                $this->Tournament_Team_Matches_Where
                (
                    $team,
                    "Team2",
                    array
                    (
                        "__Winner__" => "Goals2<Goals1",
                    )
                )
            );
    }

    //*
    //* 
    //*

    function Tournament_Team_Draws($team)
    {
        return
            $this->MatchesObj()->Sql_Select_NHashes
            (         
                $this->Tournament_Team_Matches_Where
                (
                    $team,
                    "Team1",
                    array
                    (
                        "__Winner__" => "Goals1=Goals2",
                    )
                )
            )
            +
            $this->MatchesObj()->Sql_Select_NHashes
            (       
                $this->Tournament_Team_Matches_Where
                (
                    $team,
                    "Team2",
                    array
                    (
                        "__Winner__" => "Goals1=Goals2",
                    )
                )      
            );
    }
        


    //*
    //* 
    //*

    function Tournament_Team_Matches_Home($team)
    {
        return
            $this->MatchesObj()->Sql_Select_NHashes
            (             
                $this->Tournament_Team_Matches_Where
                (
                    $team,
                    "Team1"
                )   
            );
    }
    
    //*
    //* 
    //*

    function Tournament_Team_Matches_Away($team)
    {
        return
            $this->MatchesObj()->Sql_Select_NHashes
            (           
                $this->Tournament_Team_Matches_Where
                (
                    $team,
                    "Team2"
                )
            );
    }
}

?>