<?php

include_once("Common.php");

include_once("Tournaments/Matches/Team.php");

include_once("Tournaments/Matches/Access.php");
include_once("Tournaments/Matches/API.php");
include_once("Tournaments/Matches/Post.php");
include_once("Tournaments/Matches/Cells.php");
include_once("Tournaments/Matches/Classes.php");
include_once("Tournaments/Matches/Create.php");
include_once("Tournaments/Matches/Read.php");
include_once("Tournaments/Matches/Html.php");
include_once("Tournaments/Matches/Group.php");
include_once("Tournaments/Matches/Cell.php");
include_once("Tournaments/Matches/Form.php");
include_once("Tournaments/Matches/Details.php");
include_once("Tournaments/Matches/History.php");

class Tournament_Matches extends Common
{    
    use
        Tournament_Matches_Team,
        
        Tournament_Matches_Access,
        Tournament_Matches_API,
        Tournament_Matches_Post,
        Tournament_Matches_Cells,
        Tournament_Matches_Classes,
        Tournament_Matches_Create,
        Tournament_Matches_Read,
        Tournament_Matches_Html,
        Tournament_Matches_Group,
        Tournament_Matches_Cell,
        Tournament_Matches_Form,
        Tournament_Matches_Details,
        Tournament_Matches_History;
    

    //*
    //* function Matches, Parameter list: $args=array()
    //*
    //* Constructor.
    //*

    function Tournament_Matches($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=
            array
            (
                "Tournament",
                "Team1","Team2",
                "Goals1","Goals2",
                "Goals1_Half","Goals2_Half",
                "Points1","Points2",
                "Tournament_Round","Tournament_Group",
                "Status",
            );
        
        $this->Sort=array("Date","HHMM","ID");
        $this->Reverse=True;
        $this->IDGETVar="Match";

        $this->CellMethods[ "Tournament_Match_Cell_Team_Icons" ]=TRUE;
        $this->CellMethods[ "Tournament_Match_Cell_Teams_Icons" ]=TRUE;
        $this->CellMethods[ "Tournament_Match_Cell_Team_Icon_1" ]=TRUE;
        $this->CellMethods[ "Tournament_Match_Cell_Team_Icon_2" ]=TRUE;
        $this->CellMethods[ "Tournament_Match_Cell_Stage" ]=TRUE;
        $this->CellMethods[ "Tournament_Match_Cell_Time" ]=TRUE;
        $this->CellMethods[ "Tournament_Match_Cell_Name" ]=TRUE;
        $this->CellMethods[ "Tournament_Match_Cell_Status" ]=TRUE;
        $this->CellMethods[ "Match_Name_Cell" ]=TRUE;
        $this->CellMethods[ "Match_Cell_Score" ]=TRUE;
        $this->CellMethods[ "Match_Cell_Points" ]=TRUE;
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
        //parent::PostProcessItemData();
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
    //* Create number of groups given by Tournament.
    //*

    function PostInit()
    {
        $this->Tournament();
    }
    
    
    
    //*
    //* Acessors for Teams.
    //*

    function Match_Name($match,$key="Name",$with_minus=True)
    {
        $minus=" ";
        if ($with_minus) { $minus="-"; }
        
        return
            $this->Team_Name($match[ "Team1" ],$key).
            $minus.
            $this->Team_Name($match[ "Team2" ],$key).
            "";
            
    }
    
    //*
    //*
    //*

    function Match_Calc_Date_HHMM(&$match)
    {
        if (!empty($match[ "HHMM" ]) && $match[ "HHMM" ]<0)
        {
            if (preg_match('/^(\d\d\d\d)(\d\d)01/',$match[ "Date" ],$matches))
            {
                $month=$matches[2];
                $year=$matches[1];

                $month=intval($month);
                if
                    (
                        $month==2
                        ||
                        $month==4
                        ||
                        $month==6
                        ||
                        $month==8
                        ||
                        $month==10
                        ||
                        $month==12
                    )
                {
                    $date=31;
                    $month--;
                }
                elseif ($month==1)
                {
                    $date=31;
                    $month=12;
                    $year--;
                }
                elseif ($month==3)
                {
                    $date=28;
                    $month--;
                }
                else
                {
                    $date=30;
                    $month--;
                }
                
                $match[ "Date" ]=
                    $year.
                    sprintf("%02d",$month).
                    sprintf("%02d",$date).
                    "";
            }
            
            $match[ "HHMM" ]+=2400;
        }

        return $match;
   }

    //*
    //* 
    //*

    function Match_Status($match)
    {
        return
            $this->MyMod_Data_Fields_Enums_Value
            (
                "Status",
                $match
            );
            
    }
    
    //*
    //* 
    //*

    function Match_Time($match)
    {
        return
            preg_replace
            (
                '/(\d\d\d\d)(\d\d)(\d\d)/',
                "$3/$2/$1",
                $match[ "Date" ]
            ).
            " ".
            preg_replace
            (
                '/(\d\d)(\d\d)/',
                "$1:$2",
                $match[ "HHMM" ]
            );
            
    }
    
    //*
    //* [=
    //*

    function Match_Result($match,$key="Goals",$with_minus=True)
    {
        if ($match[ "Status" ]>1)
        {
            if (empty($match[ $key."1" ]))
            {
                $match[ $key."1" ]=0;
            }
            
            if (empty($match[ $key."2" ]))
            {
                $match[ $key."2" ]=0;
            }
            
        }
        
        $minus=" ";
        if ($with_minus) { $minus="-"; }
        
        return
            array
            (
                $this->MyMod_Data_Field
                (
                    0,
                    $match,
                    $key."1"
                ),
                $minus,
                $this->MyMod_Data_Field
                (
                    0,
                    $match,
                    $key."2"
                ),
            );
            
    }
    
    //*
    //*
    //*

    function Match_Name_Cell($edit=0,$match=array(),$data="")
    {
        if (empty($match))
        {
            return $this->MyLanguage_GetMessage("Name");
        }

        return $this->Match_Name($match,"Initials");
    }


    var $__Rounds__=array();
    
    //*
    //*
    //*

    function Tournament_Match_Rounds($match)
    {
        $group_id=$match[ "Tournament_Group" ];
        if (empty($this->__Rounds__[ $group_id ]))
        {
            $this->__Rounds__[ $group_id ]=
                $this->RoundsObj()->Sql_Select_Hashes
                (
                    array
                    (
                        "Tournament"       => $match[ "Tournament" ],
                        "Tournament_Group" => $group_id,
                    )
                );
        }

        return $this->__Rounds__[ $group_id ];
    }
    
    //*
    //*
    //*

    function Tournament_Match_Round_Select($data,$match,$edit=0,$rdata="")
    {
        if (empty($rdata)) { $rdata=$data; }

        $teams=array($match[ "Team1" ],$match[ "Team2" ]);
        
        $rounds=
            array_merge
            (
                $this->Sql_Select_Unique_Col_Values
                (
                    "Tournament_Round",
                    array
                    (
                        "Tournament" => $match[ "Tournament" ],
                        "Tournament_Group" => $match[ "Tournament_Group" ],
                        "Team1" => $teams,
                    )
                ),
                $this->Sql_Select_Unique_Col_Values
                (
                    "Tournament_Round",
                    array
                    (
                        "Tournament" => $match[ "Tournament" ],
                        "Tournament_Group" => $match[ "Tournament_Group" ],
                        "Team2" => $teams,
                    )
                )
            );

        $rounds_byid=array();
        foreach ($rounds as $round) { $rounds_byid[ $round ]=True; }

        $names=array("");
        $titles=array("");
        $values=array(0);
        $disableds=array(0);
        
        foreach
            (
                $this->Tournament_Match_Rounds($match)
                as $round
            )
        {            
            array_push($values,$round[ "ID" ]);

            $disabled=True;
            if
                (
                    $round[ "ID" ]==$match[ "Tournament_Round" ]
                    ||
                    empty($rounds_byid[ $round[ "ID" ] ])
                )
            {
                $disabled=False;
            }
            
            array_push($disableds,$disabled);
            
            array_push
            (
                $names,
                $name=join
                (
                    ", ",
                    array
                    (
                        preg_replace
                        (
                            '/(\d\d\d\d)(\d\d)(\d\d)/',
                            '$3/$2/$1',
                            $round[ "Date" ]
                        ),
                        preg_replace
                        (
                            '/(\d\d)(\d\d)/',
                            '$1:$2',
                            $round[ "HHMM" ]
                        ),
                    )
                )
            );

            array_push
            (
                $titles,
                join
                (
                    ", ",
                    array
                    (
                        $name,
                        $this->GroupsObj()->MyMod_Itemname().
                        " ".
                        $this->Tournament_Group_Name($round),
                    )
                )
            );
        }

        return
            $this->Htmls_Select
            (
                $rdata,
                $values,$names,
                
                $match[ "Tournament_Round" ],
                
                array
                (
                    "Titles" => $titles,
                    "Disableds" => $disableds,
                )
            );
    }


}

?>