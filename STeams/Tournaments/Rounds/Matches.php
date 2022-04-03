<?php

include_once("Matches/Where.php");
include_once("Matches/Read.php");
include_once("Matches/Cell.php");
include_once("Matches/Rows.php");
include_once("Matches/Titles.php");
include_once("Matches/Table.php");
include_once("Matches/Tables.php");
include_once("Matches/Html.php");
include_once("Matches/Update.php");
include_once("Matches/Form.php");
include_once("Matches/Create.php");

trait Tournaments_Rounds_Matches
{
    use
        Tournaments_Rounds_Matches_Where,
        Tournaments_Rounds_Matches_Read,
        Tournaments_Rounds_Matches_Cell,
        Tournaments_Rounds_Matches_Rows,
        Tournaments_Rounds_Matches_Titles,
        Tournaments_Rounds_Matches_Table,
        Tournaments_Rounds_Matches_Tables,
        Tournaments_Rounds_Matches_Html,
        Tournaments_Rounds_Matches_Update,
        Tournaments_Rounds_Matches_Form,
        Tournaments_Rounds_Matches_Create;
    
    //*
    //* 
    //*

    function Tournament_Round_Matches_Handle_Edit($round=array())
    {
        $edit=0;
        if ($this->Profile_Trust()>=$this->Profile_Trust("Coordinator"))
        {
            $edit=1;
        }

        return $edit;
    }
    
    //*
    //* 
    //*

    function Tournament_Round_Matches_Handle($round=array())
    {
        if (empty($round)) { $round=$this->ItemHash; }

        $group=
            $this->Tournament_GroupsObj()->Sql_Select_Hash
            (
                array("ID" => $round[ "Tournament_Group" ])
            );
        
        $team_ids=
            $this->Tournament_TeamsObj()->Sql_Select_Unique_Col_Values
            (
                "Team",
                array
                (
                    "Tournament"       => $round[ "Tournament" ],
                    "Season"           => $round[ "Season" ],
                    "Tournament_Group" => $round[ "Tournament_Group" ],
                )
            );

        $edit=
            $this->Tournament_Round_Matches_Handle_Edit($round);
        
        $round_matches=
            $this->Tournament_Round_Matches_Read($round);

        if ($edit==1 && $this->CGI_POSTint("Add")==1)
        {
            $round_matches=
                $this->Tournament_Round_Match_Update
                (
                    $edit,$round,$group,$team_ids,
                    $round_matches
                );
        }

        $this->Htmls_Echo
        (
            array
            (
                $this->Htmls_H
                (
                    1,
                    $this->MatchesObj()->MyMod_ItemsName().
                    ", ".
                    $this->Season("Name")
                ),

                $this->Htmls_H
                (
                    2,
                    array
                    (
                        $this->RoundsObj()->MyMod_Data_Fields_Show
                        (
                            "StartDate",$round
                        ),
                        "-",
                        $this->RoundsObj()->MyMod_Data_Fields_Show
                        (
                            "EndDate",$round
                        ),
                    )
                ),
                $this->Tournament_MatchesObj()->MyMod_Items_Dynamic
                (
                    0,
                    $round_matches,
                    "Basic"
                ),
                /* $this->Tournament_Round_Matches_Add_Form */
                /* ( */
                /*     $edit,$round,$group,$team_ids,$round_matches */
                /* ), */
            )           
        );       
        
    }

    
    //*
    //* 
    //*

    function Tournament_Round_Matches_Add_Form($edit,$round,$group,$team_ids,&$round_matches)
    {
        if ($edit!=1)
        {
            return array();
        }

        $nteams=
            $this->Tournament_TeamsObj()->Sql_Select_NHashes
            (
                array
                (
                    "Tournament"       => $round[ "Tournament" ],
                    "Season"           => $round[ "Season" ],
                    "Tournament_Group" => $round[ "Tournament_Group" ],
                )
            );

        $nmatches=$nteams/2;
        if ($nmatches<=count($round_matches))
        {
            return array();
        }

        return
            $this->Htmls_Form
            (
                $edit,
                $this->Tournament_Round_Match_Form_ID($round,$group),
                "",
                //$contents=
                array
                (
                    $this->Htmls_H
                    (
                        4,
                        array
                        (
                            $this->MyLanguage_GetMessage("Select"),
                            $this->MatchesObj()->MyMod_ItemName(),
                            $this->Tournament_Round_Match_Select
                            (
                                $round,$group,$team_ids,$round_matches
                            )
                        )
                    )
                ),
                //$args=
                array
                (
                    "Buttons" =>$this->Buttons("Add"),
                    "Hiddens" => array
                    (
                        "Add" => 1,
                    ),
                )
            );
        
    }
    
    
    //*
    //* 
    //*

    function Tournament_Round_Matches_Read($round)
    {
        $matches=
            $this->Tournament_MatchesObj()->Sql_Select_Hashes
            (
                $this->Tournament_Round_Matches_Where($round)
            );

        foreach (array_keys($matches) as $id)
        {
            $matches[ $id ]=
                $this->Tournament_MatchesObj()->PostProcess
                (
                    $matches[ $id ],
                    $force=True
                );
        }

        return $matches;
        
    }    
    //*
    //* 
    //*

    function Tournament_Round_Matches_Where($round)
    {
        return
            array
            (
                "Tournament"       => $round[ "Tournament" ],
                "Season"           => $round[ "Season" ],
                //"Tournament_Group" => $round[ "Tournament_Group" ],
                "Tournament_Round" => $round[ "ID" ],
            );        
    }
    
    //*
    //* 
    //*

    function Tournament_Round_Matches_Allowed($round,$group,$team_ids,$matches)
    {
        $teams=
            array_diff
            (
                $team_ids,
                array_merge
                (
                    $this->MyHash_HashesList_Values($matches,"Team1"),
                    $this->MyHash_HashesList_Values($matches,"Team2")
                )
            );

        return
            $this->MatchesObj()->Sql_Select_Hashes
            (
                array
                (
                    "Tournament"       => $round[ "Tournament" ],
                    "__Round" =>
                    "(Tournament_Round='0' OR Tournament_Round IS NULL)",
                    "Team1" => $teams,
                    "Team2" => $teams,
                ),
                array(),
                "Team1,Team2,ID"
            );        
    }
    
    //*
    //* 
    //*

    function Tournament_Round_Match_Update($edit,$round,$group,$team_ids,$round_matches)
    {
        if ($edit!=1 || $this->CGI_POSTint("Add")!=1) { return $round_matches; }

        $match_cgi_value=
            $this->Tournament_Round_Match_Select_Value($round,$group);

        if ($match_cgi_value>0)
        {
            $allowed_matches=
                $this->Tournament_Round_Matches_Allowed
                (
                    $round,$group,$team_ids,$round_matches
                );

            $update=False;
            foreach ($allowed_matches as $allowed_match)
            {
                if ($match_cgi_value==$allowed_match[ "ID" ])
                {
                    $this->MatchesObj()->Sql_Update_Item_Value_Set
                    (
                        $allowed_match[ "ID" ],
                        "Tournament_Round",
                        $round[ "ID" ]
                    );
                    $this->MatchesObj()->Sql_Update_Item_Value_Set
                    (
                        $allowed_match[ "ID" ],
                        "Date",
                        $round[ "Date" ]
                    );
                    $this->MatchesObj()->Sql_Update_Item_Value_Set
                    (
                        $allowed_match[ "ID" ],
                        "HHMM",
                        $round[ "HHMM" ]
                    );

                    return
                        $this->Tournament_Round_Matches_Read($round);
                }
            }
        }

        return $round_matches;
    }
    
    //*
    //* 
    //*

    function Tournament_Round_Match_Select($round,$group,$team_ids,$round_matches)
    {
        if (count($team_ids)==0) { return "-"; }
        
        $name_key="Initials_".$this->MyLanguage_Get();
        $title_key="Title_".$this->MyLanguage_Get();
        
        $names=array("");
        $values=array(0);
        $titles=array("");
        foreach
            (
                $this->Tournament_Round_Matches_Allowed
                (
                    $round,$group,$team_ids,$round_matches
                )
                as $match
            )
        {
            array_push($values,$match[ "ID" ]);

            array_push
            (
                $names,
                $this->Match_Name($match)
            );
            
            array_push
            (
                $titles,
                $this->Match_Name($match,"Title")
            );
        }
        
        return
            $this->Htmls_Select
            (
                $this->Tournament_Round_Match_Select_Name
                (
                    $round,$group
                ),
                $values,$names,
                0,
                array
                (
                    "Titles" => $titles,
                )
            );
    }    
    //*
    //* 
    //*

    function Tournament_Round_Match_Form_ID($round,$group)
    {
        return "Match_".$round[ "ID" ]."_".$group[ "ID" ];
    }
    
    //*
    //* 
    //*

    function Tournament_Round_Match_Select_Value($round,$group)
    {
        return
            $this->CGI_POSTint
            (
                $this->Tournament_Round_Match_Select_Name($round,$group)
            );
    }
    
    //*
    //* 
    //*

    function Tournament_Round_Match_Select_Name($round,$group)
    {
        return "Match_".$round[ "ID" ]."_".$group[ "ID" ];
    }
    
}

?>