<?php


trait App_CLI_Bets
{  
    //*
    //* 
    //*

    function MyApp_CLI_Bets_Update($base)
    {
    }
    
    //*
    //* 
    //*

    function MyApp_CLI_Bet_Update($base,$competition,$season_json,$our_season,$match_json)
    {
    }
    
    //*
    //* 
    //*

    function MyApp_CLI_Bets_Correct($tournament_id,$season_id,$pool_id)
    {        
        $this->Pool_BetsObj()->Sql_Table_Structure_Update_Force=True;
        $this->Pool_BetsObj()->Sql_Table_Structure_Updated=False;
        $this->Pool_BetsObj()->Sql_Table_Structure_Update();
        
        return
            array
            (
                $this->MyApp_CLI_Bets_Correct_Season($tournament_id,$season_id,$pool_id),
            );
    }
    
    //*
    //* 
    //*

    function MyApp_CLI_Bets_Correct_Season($tournament_id,$season_id,$pool_id)
    {
        return
            $this->Pool_BetsObj()->Sql_Update_Where
            (
                array
                (
                    "Season" => $season_id,
                ),
                array
                (
                    "Tournament" => $tournament_id,
                    "__Season__" => "(Season IS NULL OR Season='0')",
                ),
                array("Season")
            ).
            " Pool_Bets updated";
    }
    
    //*
    //* 
    //*

    function MyApp_CLI_Bets_Matches_Correct($tournament_id,$season_id,$pool_id,$pool_friends)
    {
        $nmatches=0;
        $ndoubles=0;
        foreach ($pool_friends as $pool_friend)
        {
            $match_ids=
                $this->Pool_BetsObj()->Sql_Select_Unique_Col_Values
                (
                    "Tournament_Match",
                    $this->Pool_Bets_Friend_Where
                    (
                        $pool_friend,
                        array
                        (
                            "Pool" => $pool_id,
                        )
                    )
                );
            
            $nmatches+=count($match_ids);

            $rmatch_ids=array();
            foreach ($match_ids as $match_id)
            {
                if (empty($rmatch_ids[ $match_id ]))
                {
                    $rmatch_ids[ $match_id ]=True;
                }
                else
                {
                    $this->MyApp_CLI_Print
                    (
                        array
                        (
                            "Participant ".$pool_friend[ "ID" ]." double match: ".
                            $match_id,
                        )
                    );
                    
                    $ndoubles++;
                }
            }

        }
        
        return $ndoubles." of ".$nmatches." double matches";
    }
    
    //*
    //* 
    //*

    function MyApp_CLI_Bets_Matches_POST($args,$tournament_id,$season_id)
    {
        $matches=
            array_reverse
            (
                $this->Tournament_MatchesObj()->Sql_Select_Hashes
                (
                    array
                    (
                        "Tournament" => $tournament_id,
                        "Season"     => $season_id,
                    ),
                    array(),
                    "Date,HHMM"
                )
            );

        $this->MyApp_CLI_Print
        (
            array
            (
                "Processing ".$this->Tournament("Name"),
                "Season ".$this->Tournament("Season"),
                count($matches)." Matches",
            )
        );
        
        foreach ($this->Sql_Tables_Module("Bets") as $bets_table)
        {
            $comps=preg_split("/_/",$bets_table);
            $pool_id=$comps[1];
            if ($comps[0]!=$tournament_id) { continue; }
            
            
            $this->STeams_Pool_Set($pool_id);
            $this->MyApp_CLI_Print
                (
                    array
                    (
                        "Processing Pool ".$pool_id." ".$this->Pool("Name"),
                    )
                );
        
            
            $this->MyApp_CLI_Bets_Pool_Matches_POST
            (
                $args,
                $tournament_id,$season_id,
                $bets_table,
                $matches
            );
        }
    }
    
    //*
    //* 
    //*

    function MyApp_CLI_Bets_Pool_Matches_POST($args,$tournament_id,$season_id,$bets_table,$matches)
    {
        $match_id=0;
        if (count($args)>3) { $match_id=$args[3]; }
        
        $nupdated=0;
        foreach ($matches as $match)
        {
            if ($match_id>0 && $match_id!=$match[ "ID" ]) { continue; }
            
            $nupdated+=
                $this->MyApp_CLI_Bets_Match_Update
                (
                    $tournament_id,$season_id,
                    $bets_table,
                    $match
                );
        }
        
        $nbets=
            $this->Pool_BetsObj()->Sql_Select_NHashes
            (
                $this->Tournament_Season_Where
                (
                    array
                    (
                        "Tournament" => $tournament_id,
                        "Season"     => $season_id,
                    )
                )
            );

        $this->MyApp_CLI_Print
        (
            array
            (
                count($matches).
                " Matches, ".$nupdated." de ".$nbets." Bets updated",
            )
        );
    }
    
    //*
    //* 
    //*

    function MyApp_CLI_Bets_Match_Update($tournament_id,$season_id,$bets_table,$match)
    {
        $where=
            $this->Pool_BetsObj()->Pool_Bets_Match_Where($match);
            
        $nbets=
            $this->Pool_BetsObj()->Sql_Select_NHashes
            (
                $where,
                $bets_table
            );

        $mtime=max($match[ "API_Last" ],$match[ "MTime" ]);
        
        $mtimes=
            $this->Pool_BetsObj()->Sql_Select_Unique_Col_Values
            (
                "MTime",
                $where
            );
                
        
        $where[ "__MTime__" ]="MTime<".$mtime;
        $bets_update=
            $this->Pool_BetsObj()->Sql_Select_Hashes
            (
                $where
            );

        $nupdated=0;
        foreach ($bets_update as $bet_update)
        {
            if
                (
                    $this->MyApp_CLI_Bet_Match_Update
                    (
                        $tournament_id,$season_id,
                        $bets_table,
                        $match,
                        $bet_update
                    )
                )
            {
                $nupdated++;
            }
        }

        if ($nupdated>0)
        {
            $this->MyApp_CLI_Print
            (
                array
                (
                    "Match ".$match[ "ID" ].", ".
                    $match[ "Name" ]."\t".
                    $this->TimeStamp($match[ "API_Last" ]).
                    ", Bets: ".
                    count($bets_update)."/".$nbets." - ".$nupdated." updated",
                )
            );
        }

        return $nupdated;
    }
    
    //*
    //* 
    //*

    function MyApp_CLI_Bet_Match_Update($tournament_id,$season_id,$bets_table,$match,$bet)
    {
        $updatedatas=array();
        $this->Pool_BetsObj()->Pool_Bet_Calc($bet,$updatedatas,$match);

        $update=False;
        if (count($updatedatas)>0)
        {
            /* $this->MyApp_CLI_Print */
            /* ( */
            /*     array */
            /*     ( */
            /*         "\tMatch ".$match[ "Name" ]."\t".$match[ "Date" ]."\t".$match[ "HHMM" ], */
                    
            /*         "\n\tBet ".$bet[ "ID" ].": ".$this->TimeStamp($bet[ "MTime" ]), */
            /*         "\n\tUpdate ".join(", ",$updatedatas), */
            /*     ) */
            /* ); */

            $update=True;
            $this->Pool_BetsObj()->Sql_Update_Item_Values_Set
            (
                $updatedatas,
                $bet
            );
            
        }

        return $update;
    }
}
