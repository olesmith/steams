<?php

trait Tournament_Matches_Group_Titles
{
    //*
    //* 
    //*

    function Tournament_Matches_Group_Titles($tournament,$group_id,$group,$teams)
    {
        return
            array
            (
                array
                (
                    $this->Tournament_Matches_Group_Title
                    (
                        $tournament,$group
                    ),
                ),
                $this->Tournament_Matches_Group_Titles1
                (
                    $tournament,$group_id,$group,$teams
                ),
                $this->Tournament_Matches_Group_Titles2
                (
                    $tournament,$group_id,$group,$teams
                ),
            );
    }
    
    //*
    //* 
    //*

    function Tournament_Matches_Group_Titles2($tournament,$group_id,$group,$teams)
    {
        $titles=
            array
            (
                $this->Tournament_Matches_Group_Text($tournament),
                $this->Tournament_Matches_Group_Text($tournament)
            );
        
        $team2_n=0;
        foreach ($tournament[ "Groups" ][ $group_id ] as $team_id)
        {
            $team2_n++;
            array_push
            (
                $titles,
                $this->Tournament_Matches_Group_Icon_Team
                (
                    $tournament,$teams[ $team_id ],
                    $team2_n,
                    $this->Tournament_Match_Classes_Group_Teams
                    (
                        $tournament,$group,0,$team2_n
                    )

                )
            );
        }

        return $titles;
    }
    
    //* 
    //*

    function Tournament_Matches_Group_Titles1($tournament,$group_id,$group,$teams)
    {
        $titles=
            array
            (
                $this->Tournament_Matches_Group_Text($tournament),
                $this->Tournament_Matches_Group_Text($tournament)
            );
        
        $team2_n=0;
        foreach ($tournament[ "Groups" ][ $group_id ] as $team_id)
        {
            $team2_n++;   
            array_push
            (
                $titles,
                $this->Tournament_Matches_Group_Initials_Team
                (
                    $tournament,$teams[ $team_id ],
                    $team2_n,
                    array
                    (
                        "CLASS" => $this->Tournament_Match_Classes_Group_Teams
                        (
                            $tournament,$group,0,$team2_n
                        )
                    )
                )
            );
        }

        return $titles;
    }
}

?>
