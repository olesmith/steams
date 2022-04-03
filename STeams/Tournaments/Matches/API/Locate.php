<?php

trait Tournament_Matches_API_Locate
{
    //*
    //* 
    //*

    function Tournament_Match_API_Locate($tournament,$season,$jmatch)
    {
        $match=
            $this->Sql_Select_Hash
            (
                array("API_ID" => $jmatch[ "id" ])
            );

        if (empty($match))
        {
            $jteam1_id=$jmatch[ "homeTeam" ][ "id" ];
            $jteam2_id=$jmatch[ "awayTeam" ][ "id" ];

            //var_dump($jmatch);
            $team1=
                $this->TeamsObj()->Sql_Select_Hash
                (
                    array("API_ID" => $jteam1_id)
                );
        
            $team2=
                $this->TeamsObj()->Sql_Select_Hash
                (
                    array("API_ID" => $jteam2_id)
                );

            $match=
                $this->Sql_Select_Hash
                (
                    array
                    (
                        "Tournament" => $tournament[ "ID" ],
                        "Season"     => $season[ "ID" ],
                        "Team1"      => $team1[ "ID" ],
                        "Team2"      => $team2[ "ID" ],
                    )
                );

            if ($tournament[ "HomeAndAway" ]==2 && empty($match))
            {
                $match=
                    $this->Sql_Select_Hash
                    (
                        array
                        (
                            "Tournament" => $tournament[ "ID" ],
                            "Season"     => $season[ "ID" ],
                            "Team1"      => $team2[ "ID" ],
                            "Team2"      => $team1[ "ID" ],
                        )
                    );
                
                if (!empty($match))
                {
                    $this->Tournament_Matches_API_Swap($match);
                }           
            }

                
            if (!empty($match))
            {
                $match[ "API_ID" ]=$jmatch[ "id" ];   
                $this->MatchesObj()->Sql_Update_Item_Value_Set
                (
                    $match[ "ID" ],
                    "API_ID",
                    $match[ "API_ID" ]
                );
            }           
            
        }
        
        return $match;
    }
}

?>