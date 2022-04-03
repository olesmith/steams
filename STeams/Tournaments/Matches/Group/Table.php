<?php

trait Tournament_Matches_Group_Table
{
    //*
    //* 
    //*

    function Tournament_Matches_Group_Table($edit,$tournament,$group_id,$group,$teams,$matches)
    {
        $matches=
            $this->MyMod_Sort_List
            (
                $matches,
                array("Date","HHMM","ID")
            );
        
        $matches=
            $this->MyHash_HashesList_2IDs
            (
                $matches,
                "Team1"
            );

        
        $table=
            $this->Tournament_Matches_Group_Titles
            (
                $tournament,$group_id,$group,
                $teams
            );

        $team1_n=0;
        foreach ($tournament[ "Groups" ][ $group_id ] as $team1_id)
        {
            $team1_n++;
            
            $rmatches=array();
            if (!empty($matches[ $team1_id ]))
            {
                $rmatches=$matches[ $team1_id ];
            }
            
            $table=
                array_merge
                (
                    $table,
                    $this->Tournament_Matches_Group_Rows
                    (
                        $team1_n,$edit,$tournament,$group_id,$group,$teams,
                        $rmatches,$team1_id
                    )
                );
        }

        return $table;
    }
}

?>
