<?php

trait Tournaments_Rounds_Matches_Create
{
    //*
    //* 
    //*

    function Tournament_Round_Matches_Create($tournament,$round)
    {
        $sql_table=
            $this->Tournament_MatchesObj()->Tournament_Sql_Table
            (
                $this->Tournament_MatchesObj()->ModuleName,
                $tournament
            );
        
        foreach (array_keys($tournament[ "Groups" ]) as $group_id)
        {
            $nteams=count($tournament[ "Groups" ][$group_id ]);
            if ($tournament[ "HomeAndAway" ]==2)
            {
                $ntemas*=2;
            }

            $nmatches=floor($nteams/2);

            $where=
                array
                (
                    "Tournament"       => $tournament[ "ID" ],
                    "Tournament_Group" => $group_id,
                    "Tournament_Round" => $round[ "ID" ],
                );

            $nmatches_db=
                $this->Tournament_MatchesObj()->Sql_Select_NHashes
                (
                    $where,
                    $sql_table
                );
            
            for ($n=$nmatches_db+1;$n<=$nmatches;$n++)
            {
                $match=
                    array_merge
                    (
                        $where,
                        array
                        (
                            //"Date" => $round[ "Date" ],
                            "Team1" => 0,
                            "Team2" => 0,
                            "Goals1" => 0,
                            "Goals2" => 0,
                        )
                    );

                $this->Tournament_MatchesObj()->Sql_Insert_Item
                (
                    $match,
                    $sql_table
                );
            }          
        }
    }
    
}

?>