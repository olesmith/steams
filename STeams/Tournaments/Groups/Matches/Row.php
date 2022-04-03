<?php

trait Tournament_Groups_Matches_Row
{
    //*
    //*
    //*

    function Tournament_Group_Matches_Row($team1_n,$edit,$group,$teams,$matches,$team1)
    {
        $key="Name_".$this->MyLanguage_Get();
        
        $matches=
            $this->MyHash_HashesList_2ID
            (
                $matches,
                "Team2"
            );

        $row=
           array
            (
                $this->Tournament_Group_Matches_Team_Initials
                (
                    $group,$team1,
                    0,
                    array
                    (
                        "CLASS" => $this->Tournament_Groups_Matches_Classes_Teams
                        (
                            $group,$team1_n,0
                        )
                    )
                ),
               
                $this->Tournament_Group_Matches_Team_Icon
                (
                    $group,$team1,
                    0,
                    $this->Tournament_Groups_Matches_Classes_Teams
                    (
                        $group,$team1_n,0
                    )
                )             
            );



        $team2_n=0;
        foreach ($teams as $team2)
        {
            $team2_n++;
            $rmatch=array();
            if (!empty($matches[ $team2[ "Team" ] ]))
            {
                $rmatch=$matches[ $team2[ "Team" ] ];
            }

            array_push
            (
                $row,
                array
                (
                    "Text" => 
                    $this->Tournament_Matches_Group_Cells
                    (
                        $edit,
                        $rmatch,
                        $team1,$team2
                    ),
                    "Options" => $this->Tournament_MatchesObj()->Tournament_Match_TD_Options
                    (
                        $team1_n,$team2_n,
                        $edit,
                        $this->Tournament(),$rmatch,$group
                    ),
                )
            );
        }

        return $row;
    }
}

?>