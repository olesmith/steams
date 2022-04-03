<?php

trait Tournament_Groups_Matches_Classes
{
    //*
    //* 
    //*

    function Tournament_Groups_Matches_Classes()
    {
        return array("Tour_".$this->Tournament("ID"));
    }
    
    //*
    //* 
    //*

    function Tournament_Groups_Matches_Classes_Group($group)
    {
        return
            array_merge
            (
                $this->Tournament_Groups_Matches_Classes(),
                array("Group_".$group[ "ID" ])
            );
    }
    
    //*
    //* 
    //*

    function Tournament_Groups_Matches_Classes_Teams($group,$team1_n,$team2_n)
    {
        $classes=
            $this->Tournament_Groups_Matches_Classes_Group
            (
                $group
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