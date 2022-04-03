<?php

trait Tournament_Groups_Matches_Table
{
    //*
    //*
    //*

    function Tournament_Group_Matches_Table($edit,$group,$teams,$matches)
    {
        $matches=
            $this->MyHash_HashesList_2IDs
            (
                $matches,
                "Team1"
            );

        $table=array();
        $team1_n=0;
        foreach ($teams as $team1)
        {
            $team1_n++;
            
            $rmatches=array();
            if (!empty($matches[ $team1[ "Team" ] ]))
            {
                $rmatches=$matches[ $team1[ "Team" ] ];
            }
            
            $table=
                array_merge
                (
                    $table,
                    $this->Tournament_Group_Matches_Rows
                    (
                        $team1_n,$edit,$group,$teams,
                        $rmatches,$team1
                    )
                );
        }

        return $table;
    }
}

?>