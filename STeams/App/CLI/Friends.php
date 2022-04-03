<?php


trait App_CLI_Friends
{  
    //*
    //* 
    //*

    function MyApp_CLI_Friends_Correct($tournament_id,$season_id,$pool_id)
    {        
        return
            array
            (
                $this->MyApp_CLI_Friends_Correct_Season($tournament_id,$season_id,$pool_id),
            );
    }
    
    //*
    //* 
    //*

    function MyApp_CLI_Friends_Correct_Season($tournament_id,$season_id,$pool_id)
    {
        return
            $this->Pool_FriendsObj()->Sql_Update_Where
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
            " Pool_Friends updated";
    }
    
    //*
    //* 
    //*

    function MyApp_CLI_Friends_Bets_Test($tournament_id,$season_id,$pool_id,$pool_friends_data)
    {
        $this->MyApp_CLI_Print("Testing bets");

        $pool_friends_where=
                array
                (
                    "Tournament" => $tournament_id,
                    "Season"     => $season_id,
                    "Pool"       => $pool_id,
                );
        $pool_bets_where=$pool_friends_where;
        
        $bet_ids=
            $this->Pool_BetsObj()->Sql_Select_Unique_Col_Values
            (
                "ID",
                $pool_bets_where
            );

        $bet_ids_by_id=array();
        foreach ($bet_ids as $bet_id)
        {
            $bet_ids_by_id[ $bet_id ]=True;
        }
        
        $pool_friends=
            $this->Pool_FriendsObj()->Sql_Select_Hashes
            (
                $pool_friends_where,
                $pool_friends_data
            );

        $this->MyApp_CLI_Print
        (
            array
            (
                $this->Pool_FriendsObj()->SqlTableName()." ".count($pool_friends),
                $this->Pool_BetsObj()->SqlTableName()." ".count($bet_ids),
            )
        );

        $rpool_friends=array();
        foreach ($pool_friends as $pool_friend)
        {
            if (empty($rpool_friends[ $pool_friend[ "Friend" ] ]))
            {
                $rpool_friends[ $pool_friend[ "Friend" ] ]=$pool_friend;
            }
            else
            {
                $this->MyApp_CLI_Print
                (
                    "Friend ".$pool_friend[ "Friend" ]." multiple"
                );
            }
            
            $pool_bet_where=
                array_merge
                (
                    $pool_bets_where,
                    array
                    ( 
                        "Friend"     => $pool_friend[ "Friend" ],  
                    )
                );

            $bet_ids_friend=
                $this->Pool_BetsObj()->Sql_Select_Unique_Col_Values
                (
                    "ID",
                    $pool_bet_where
                );

            //$this->MyApp_CLI_Print("Friend ".$pool_friend[ "Friend" ]." ".count($bet_ids_friend));

            foreach ($bet_ids_friend as $bet_id_friend)
            {
                unset($bet_ids_by_id[ $bet_id_friend ]);
            }
        }

        $this->MyApp_CLI_Print(count(array_keys($bet_ids_by_id))." foreign bets");

        $this->MyApp_CLI_Print
        (
            $this->MyApp_CLI_Friends_Bets_Friend_Correct
            (
                $tournament_id,$season_id,$pool_id,
                $rpool_friends
            )
        );

        $this->MyApp_CLI_Print
        (
            $this->MyApp_CLI_Bets_Matches_Correct
            (
                $tournament_id,$season_id,$pool_id,$pool_friends

            )
        );
    }
    
    //*
    //* 
    //*

    function MyApp_CLI_Friends_Bets_Friend_Correct($tournament_id,$season_id,$pool_id,$pool_friends_by_id)
    {
        $pool_bets_where=
            array
            (
                "Tournament" => $tournament_id,
                "Season"     => $season_id,
                "Pool"       => $pool_id,
            );

        
        $bets=
            $this->Pool_BetsObj()->Sql_Select_Hashes
            (
                $pool_bets_where,
                array("ID","Friend","Pool_Friend")
            );

        $nempties=0;
        $n=0;
        foreach ($bets as $bet)
        {
            $n++;
            if (empty($bet[ "Pool_Friend" ]))
            {
                $this->MyApp_CLI_Print
                (
                    array
                    (
                        "Bet ".$bet[ "ID" ]." empty Pool_Friend",
                    )
                );
                
                $nempties++;

                if (!empty($pool_friends_by_id[ $bet[ "Friend" ] ]))
                {
                    $this->Pool_BetsObj()->Sql_Update_Item_Value_Set
                    (
                        $bet[ "ID" ],
                        "Pool_Friend",
                        $pool_friends_by_id[ $bet[ "Friend" ] ][ "ID" ]
                    );
                    
                    $this->MyApp_CLI_Print
                    (
                        array
                        (
                            "Bet ".$n.", ID=".$bet[ "ID" ]." updated: ".
                            $pool_friends_by_id[ $bet[ "Friend" ] ][ "ID" ],
                        )
                    );
                }
            }
        }

        return  $nempties." of ".count($bets)." empty Bet Pool_Friend";
    }
}
