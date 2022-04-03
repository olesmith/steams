<?php

include_once("Matches/Classes.php");
include_once("Matches/Options.php");
include_once("Matches/Cells.php");
include_once("Matches/Row.php");
include_once("Matches/Rows.php");
include_once("Matches/Title.php");
include_once("Matches/Titles.php");
include_once("Matches/Table.php");
include_once("Matches/Html.php");
include_once("Matches/Form.php");

trait Tournament_Groups_Matches
{
    use
        Tournament_Groups_Matches_Classes,
        Tournament_Groups_Matches_Options,
        Tournament_Groups_Matches_Cells,
        Tournament_Groups_Matches_Row,
        Tournament_Groups_Matches_Rows,
        Tournament_Groups_Matches_Title,
        Tournament_Groups_Matches_Titles,
        Tournament_Groups_Matches_Table,
        Tournament_Groups_Matches_Html,
        Tournament_Groups_Matches_Form;
    
    //*
    //*
    //*

    function Tournament_Group_Matches_Handle($group=array())
    {
        if (empty($group)) { $group=$this->ItemHash; }

        $this->Htmls_Echo
        (
            $this->Htmls_Frame
            (
                $this->Tournament_Group_Matches_Generate($group)
            )
        );
    }
    
    //*
    //*
    //*

    function Tournament_Groups_Matches_Generate()
    {
        $html=array();        
        foreach ($this->TournamentsObj()->Tournament_Read_Groups() as $group)
        {
            array_push
            (
                $html,
                $this->GroupsObj()->Tournament_Group_Matches_Generate($group)
            );
        }

        return $html;
    }
    
    //*
    //*
    //*

    function Tournament_Group_Matches_Generate_ID($group)
    {
        return
            array
            (
                "Tournament","Matches",
                $this->Tournament("ID"),"Group",$group[ "ID" ]
            );
    }
    
    //*
    //*
    //*

    function Tournament_Group_Matches_Generate($group)
    {
        if (empty($group)) { $group=$this->ItemHash; }

        $id=
            $this->Tournament_Group_Matches_Generate_ID($group);
            
        //$this->Tournament_Group_Matches_Read_Or_Create($group);


        $js=array();
        if
            (
                $group[ "Status" ]==3
                ||
                $group[ "ID" ]==$this->CGI_GETint("Group")
            )
        {
            $rid=join("_",$id)."_Show";//Hide?
            
            $js=
                $this->Htmls_SCRIPT
                (
                    $this->JS_Click_Element_By_ID($rid)
                );
        }

        $matches=
            $this->Tournament_Group_Matches_Read($group);

        //if (count($matches)==0) { return array(); }
        
        return
            array
            (
                $this->Htmls_H
                (
                    1,
                    array
                    (
                        $this->MyMod_ItemName(),
                        $group[ "Name" ],
                        $this->Htmls_Dynamic_Cells
                        (
                            array
                            (
                                "Tag" => "SPAN",
                                "ID" => $id,
                                "Options" => array
                                (
                                    array
                                    (
                                        "ONCLICK" =>
                                        $this->JS_Show_Element_By_ID
                                        (
                                            $id
                                        ),
                                    ),
                                    array
                                    (
                                        "ONCLICK" =>
                                        $this->JS_Hide_Element_By_ID
                                        (
                                            $id
                                        ),
                                    ),
                                ),
                                "Styles" => array
                                (
                                    array
                                    (
                                        "display" => 'none',
                                        "color" => 'blue',
                                    ),
                                    array
                                    (
                                        "color" => 'orange',
                                    ),
                                ),
                            )
                        ),
                    )
                ),
                $this->Tournament_Group_Matches_Generate_DIV
                (
                    $group,
                    $matches
                ),
                $js
            );
    }

    //*
    //*
    //*

    function Tournament_Group_Matches_Generate_DIV($group,$matches)
    {
        $group_terminated=True;        
        foreach ($matches as $match)
        {
            if ($match[ "Status" ]!=3)
            {
                $group_terminated=False;                
            }
        }

        if ($group_terminated)
        {
            if
                (
                    empty($group[ "Status" ])
                    ||
                    $group[ "Status" ]!=3
                )
            {
                $group[ "Status" ]=3;
                $this->GroupsObj()->Sql_Update_Item_Value_Set
                (
                    $group[ "ID" ],
                    "Status",
                    3
                );
            }
            
        }
        
        return
            $this->Htmls_DIV
            (
                array
                (

                    $this->Tournament_MatchesObj()->MyMod_Items_Dynamic
                    (
                        0,
                        $matches,
                        "Basic"
                    ),
                ),
                array
                (
                    "ID" => $this->Tournament_Group_Matches_Generate_ID($group),
                )
            );
    }
    
    //*
    //*
    //*

    function Tournament_Group_Matches_Read_Or_Create($group)
    {
        $this->Tournament_MatchesObj()->Sql_Table_Structure_Update();
        $this->Tournament_MatchesObj()->ItemData();

        $nmatches_should=
            $this->Tournament_Group_Matches_N_Should($group);
        
        $nmatches_sql=
            count
            (
                $this->Tournament_Group_Matches_Read
                (
                    $group,array("ID")
                )
            );

        //$this->Tournament_Group_Matches_Create($group);   
    }

    //*
    //*
    //*

    function Tournament_Group_Matches_Create($group)
    {
        $teams=
            $this->Tournament_Group_Teams_Read($group);
        
        for ($team_no1=0;$team_no1<count($teams);$team_no1++)
        {
            for ($team_no2=$team_no1+1;$team_no2<count($teams);$team_no2++)
            {
                $this->Tournament_Group_Match_Create
                (
                    $group,
                    $teams[ $team_no1 ],
                    $teams[ $team_no2 ]
                );
            }
        }
        
    }

    //*
    //*
    //*

    function Tournament_Group_Match_Create($group,$team1,$team2)
    {
        $matches=
            $this->Tournament_MatchesObj()->Sql_Select_Hashes
            (
                $this->Tournament_Group_Match_Where
                (
                    $group,
                    $team1,$team2
                )
            );

        $nmatches_should=1;
        $rmatches=
            array
            (
                array($team1[ "Team" ],$team2[ "Team" ]),
            );
        
        if ($this->Tournament("HomeAndAway")==1)
        {
            $nmatches_should=2;
            array_push
            (
                $rmatches,
                array($team2[ "Team" ],$team1[ "Team" ])
            );
        }
        
        $key="Initials_".$this->MyLanguage_Get();
        
        if (count($matches)<$nmatches_should)
        {
            foreach ($rmatches as $rmatch)
            {
                $where=
                    $this->Tournament_Group_Matches_Where($group);
                

                $where[ "Team1" ]=$rmatch[0];
                $where[ "Team2" ]=$rmatch[1];

                $match=
                    $this->Tournament_MatchesObj()->Sql_Select_Hash
                    (
                        $where,
                        array("ID")
                    );

                if (empty($match))
                {
                    $match=$where;

                    $match[ "Name" ]=
                        $team1[ "Name" ].
                        "-".
                        $team2[ "Name" ].
                        "";
                        
                    $this->Tournament_MatchesObj()->Sql_Insert_Item($match);
                }
            }
        }
    }
    
    //*
    //*
    //*

    function Tournament_Group_Matches_N_Should($group)
    {
        $nteams=            
            count
            (
                $this->Tournament_Group_Teams_Read
                (
                    $group,
                    array("ID")
                )
            );
        
        $nmatches_total=$nteams*($nteams-1);
        
        if ($this->Tournament("HomeAndAway")==2)
        {
            $nmatches_total/=2;
        }

        return $nmatches_total;
    }



    //*
    //*
    //*

    function Tournament_Group_Matches_Read($group,$datas=array())
    {
        return
            $this->Tournament_MatchesObj()->Sql_Select_Hashes
            (
                $this->Tournament_Group_Matches_Where($group),
                array(),//$datas,
                "Date,HHMM,ID"
            );
    }


    //*
    //*
    //*

    function Tournament_Group_Match_Where($group,$team1,$team2)
    {
        $rteams=
            array
            (
                $team1[ "Team" ],
                $team2[ "Team" ],
            );
        
        return
            array_merge
            (
                $this->Tournament_Group_Matches_Where($group),
                array
                (
                    "Team1" => $rteams,
                    "Team2" => $rteams,
                )
            );
    }
    
    //*
    //*
    //*

    function Tournament_Group_Matches_Where($group)
    {
        return
            array
            (
                "Tournament"       => $this->Tournament("ID"),
                "Season"           => $this->Season("ID"),
                "Tournament_Group" => $group[ "ID" ],
            );
    }





    //*
    //* 
    //*

    function Tournament_Groups_Matches_N($tournament)
    {
        $nmatches=0;
        foreach (array_keys($tournament[ "Groups" ]) as $group_id)
        {
            $nmatches+=
                $this->Tournament_Group_Matches_N($tournament,$group_id);
        }

        return $nmatches;
    }
    
    //*
    //* 
    //*

    function Tournament_Group_Matches_N($tournament,$group_id)
    {
        $nteams=
            count($tournament[ "Groups" ][ $group_id ]);

        $nmatches=$nteams*($nteams-1);

        if ($tournament[ "HomeAndAway" ]==2)
        {
            $nmatches/=2;
        }
        
        return $nmatches;
    }
    
    
}

?>