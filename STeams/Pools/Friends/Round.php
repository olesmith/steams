<?php

trait Pool_Friend_Round
{
    //*
    //* 
    //*

    function Pool_Friend_Round_Handle()
    {
        $pool_friend=
            $this->Pool_Friend_Read();
        
        $round=
            $this->RoundsObj()->Sql_Select_Hash
            (
                array
                (
                    "ID" => $this->CGI_GET("Round"),
                )
            );

        
        $this->Htmls_Echo
        (            
            $this->Pool_Friend_Round_Form
            (
                $pool_friend,$round
            )
        );
        
    }
    
    //*
    //* 
    //*

    function Pool_Friend_Read($friend_id=0)
    {
        if ($friend_id==0)
        {
            $friend_id=$this->CGI_GETint("Owner");
            if ($friend_id==0)
            {
                $friend_id=$this->LoginData("ID");
            }
        }
        
        return
            $this->Pool_FriendsObj()->Sql_Select_Hash
            (
                array("Friend" => $friend_id)
            );
    }
    
    //*
    //* 
    //*

    function Pool_Friend_Round_Form($pool_friend,$round)
    {
        $edit=1;
        return
            $this->Htmls_Form
            (
                $edit,
                join
                (
                    "_",
                    array
                    (
                        "Friend",
                        $pool_friend[ "ID" ],
                        "Round",
                        $round[ "ID" ],
                    )
                ),
                "",

                //$contents=
                $this->Pool_Friend_Round_Html
                (
                    $edit,$pool_friend,$round
                ),

                //$args=
                array
                (
                    "Hiddens" => array
                    (
                        "Save" => 1,
                    ),
                    "Buttons" => $this->Buttons()
                )
            );
    }
    
    //*
    //* 
    //*

    function Pool_Friend_Round_Html($edit,$pool_friend,$round)
    {
        return
            array
            (
                $this->Htmls_H
                (
                    1,
                    array
                    (
                        $this->RoundsObj()->MyMod_ItemName(),
                        $round[ "Number" ],
                    )
                ),
                $this->Pool_BetsObj()->MyMod_Items_Dynamic
                (
                    $edit,
                    $this->Pool_Friend_Round_Read
                    (
                        $edit,$pool_friend,$round
                    ),
                    $datagroup="Friend"
                )
            );
    }
    
    //*
    //* 
    //*

    function Pool_Friend_Round_Read_Matches($round,$datas=array())
    {
        $matches=
            $this->MatchesObj()->Sql_Select_Hashes
            (
                array
                (
                    "Tournament"       => $round[ "Tournament" ],
                    "Tournament_Round" => $round[ "ID" ],
                ),
                $datas
            );

        foreach (array_keys($matches) as $id)
        {
            $matches[ $id ]=
                $this->MatchesObj()->PostProcess($matches[ $id ],True);
        }

        return $matches;
    }
    
    //*
    //* 
    //*

    function Pool_Friend_Round_Read($edit,$pool_friend,$round)
    {
        $matches=
            $this->Pool_Friend_Round_Read_Matches($round);

        $bets=array();
        $matches_byid=array();
        foreach ($matches as $match)
        {
            array_push
            (
                $bets,
                $this->Pool_BetsObj()->Pool_Bet_Round_Read_Create
                (
                    $match,$pool_friend
                )
            );

            $matches_byid[ $match[ "ID" ] ]=$match;
        }
        
        if
            (
                $edit==1
                &&
                $this->CGI_POSTint("Save")==1
            )
        {
            $this->Pool_Friend_Bets_Update
            (
                $pool_friend,$round,
                $bets,$matches_byid
            );
        }
            
        return $bets;
    }
    
    //*
    //* 
    //*

    function Pool_Friend_Bets_Update($pool_friend,$round,&$bets,$matches_byid)
    {
        $updated=0;
        foreach (array_keys($bets) as $bid)
        {
            $match_id=$bets[ $bid ][ "Tournament_Match" ];
            $match=$matches_byid[ $match_id ];
            
            if
                (
                    $this->Pool_Friend_Bet_Update
                    (
                        $pool_friend,$round,
                        $bets[ $bid ],
                        $match
                    )
                )
            {
                $updated++;
            }
        }
            
        return $updated;
    }
    
    //*
    //* 
    //*

    function Pool_Friend_Bet_Update($pool_friend,$round,&$bet,$match)
    {
        $permissions=
            $this->Pool_BetsObj()->Pool_Bet_Permissions($bet,$match);

        if ($permissions!=2) { return 0; }
        
        return
            $this->Pool_BetsObj()->Pool_Bet_Round_Update
            (
                $match,
                $pool_friend,
                $bet
            );
    }
}

?>