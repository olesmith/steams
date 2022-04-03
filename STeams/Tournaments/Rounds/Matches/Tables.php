<?php

trait Tournaments_Rounds_Matches_Tables
{
    //*
    //* 
    //*

    function Tournament_Round_Matches_Tables($edit,$tournament,$round)
    {
        $table=
            array
            (
                $this->Tournament_Round_Matches_Titles
                (
                    $edit,$tournament,$round
                )
            );
        foreach (array_keys($tournament[ "Groups" ]) as $group_id)
        {
            $table=
                array_merge
                (
                    $table,
                    $this->Tournament_Round_Matches_Table
                    (
                        $edit,$tournament,$round,
                        $group_id
                    )
                );
        }
        
        return $table;
    }
}

?>