<?php

trait Tournament_Groups_Matches_Titles
{
    //*
    //*
    //*

    function Tournament_Group_Matches_Titles($group,$teams)
    {
        return
            array
            (
                array
                (
                    array
                    (
                        "Text" => $this->Tournament_Group_Matches_Title($group),
                        "Options" => array
                        (
                            "COLSPAN" => count($teams)+5,
                        ),
                    ),
                ),
                $this->Tournament_Group_Matches_Titles1
                (
                    $group,$teams
                ),
                $this->Tournament_Group_Matches_Titles2
                (
                    $group,$teams
                ),
            );
    }

    
    
    //* 
    //* 
    //*

    function Tournament_Group_Matches_Titles1($group,$teams)
    {
        $titles=
            $this->Tournament_Group_Matches_Titles_Leading
            (
                $group,$teams
            );
        
        $team2_n=0;
        foreach ($teams as $team)
        {
            $team2_n++;   
            array_push
            (
                $titles,
                $this->Tournament_Group_Matches_Team_Icon
                (
                    $group,
                    $team,
                    $team2_n,
                    $this->Tournament_Groups_Matches_Classes_Teams
                    (
                        $group,0,$team2_n
                    )
                )
            );
        }

        return $titles;
    }

    //*
    //* 
    //*

    function Tournament_Group_Matches_Titles2($group,$teams)
    {
        $titles=
            $this->Tournament_Group_Matches_Titles_Leading
            (
                $group,$teams
            );
        
        $team2_n=0;
        foreach ($teams as $team)
        {
            $team2_n++;
            array_push
            (
                $titles,
                $this->Tournament_Group_Matches_Team_Initials
                (
                    $group,$team,
                    $team2_n,
                    array
                    (
                        "CLASS" => $this->Tournament_Groups_Matches_Classes_Teams
                        (
                            $group,0,$team2_n
                        )
                    )
                )
            );
        }

        return $titles;
    }
    
    //* 
    //* 
    //*

    function Tournament_Group_Matches_Titles_Leading($group,$teams)
    {
       return
            array
            (
                $this->Tournament_Group_Matches_Title_TD($group),
                $this->Tournament_Group_Matches_Title_TD($group)
            );
    }

}

?>