<?php

trait Tournament_Matches_Classes
{
    //*
    //* 
    //*

    function Tournament_Match_Classes_Tournament($tournament)
    {
        return array("Tour_".$tournament[ "ID" ]);
    }
    
    //*
    //* 
    //*

    function Tournament_Match_Classes_Group($tournament,$group)
    {
        return
            array_merge
            (
                $this->Tournament_Match_Classes_Tournament($tournament),
                array("Group_".$group[ "ID" ])
            );
    }
    
    //*
    //* 
    //*

    function Tournament_Match_Classes_Group_Teams($tournament,$group,$team1_n,$team2_n)
    {
        $classes=
            $this->Tournament_Match_Classes_Group
            (
                $tournament,$group
            );

        if ($team1_n>0)
        {
            array_push($classes,"Team1_".$team1_n);
        }
        if ($team2_n>0)
        {
            array_push($classes,"Team2_".$team2_n);
        }

        return $classes;
    }
}

?>
