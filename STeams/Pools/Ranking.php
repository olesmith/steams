<?php

include_once("Ranking/Months.php");

trait Pool_Ranking
{
    use
        Pool_Ranking_Months;
    //*
    //* 
    //*

    function Pool_Ranking_Handle()
    {
        $pool=$this->Pool();

        $this->Htmls_Echo
        (
            array
            (
                $this->Htmls_H
                (
                    1,
                    $pool[ "Name" ]
                ),
                
                $this->Pool_Ranking_Months_Menu($pool),
                
                $this->Pool_FriendsObj()->MyMod_Items_Dynamic
                (
                    0,
                    $this->Pool_Ranking_Read_Participants($pool),
                    "Ranking"
                )
            )
        );
    }
    
    //*
    //* 
    //*

    function Pool_Ranking_Read_Participants($pool)
    {
        $pool_friends=            
            $this->Pool_Read_Participants($pool);
        
        $round_id=$this->CGI_GETint("Round");
        $round=array();
        if (!empty($round_id))
        {
            $round=
                $this->RoundsObj()->Sql_Select_Hash
                (
                    array("ID" => $round_id)
                );                
        }
        
        $month=$this->CGI_GETint("Month");


        foreach (array_keys($pool_friends) as $id)// as $pool_friend)
        {
            $pool_friends[ $id ][ "Scores" ]=
                $this->RoundsObj()->Tournament_Round_Friend_Score
                (
                    $pool_friends[ $id ],$round,$month
                );

            foreach ($pool_friends[ $id ][ "Scores" ] as $key => $value)
            {
                $pool_friends[ $id ][ $key ]=$value;
            }
        }

        return
            $this->Pool_Rankings_Set($pool,$pool_friends);
    }

    
    //*
    //* 
    //*

    function Pool_Rankings_Set($pool,$pool_friends)
    {
        $rpool_friends=array();
        foreach ($pool_friends as $pool_friend)
        {
            $sort_value=
                $this->Pool_Ranking_Sort($pool,$pool_friend);

            if (empty($rpool_friends[ $sort_value ]))
            {
                $rpool_friends[ $sort_value ]=array();
            }
            
            array_push
            (
                $rpool_friends[ $sort_value ],
                $pool_friend
            );

            //var_dump($pool_friend);
        }

        $sort_keys=array_keys($rpool_friends);
        sort($sort_keys,SORT_NUMERIC);

        $pool_friends=array();
        $pos=1;
        foreach (array_reverse($sort_keys) as $sort_key)
        {
            foreach (array_keys($rpool_friends[ $sort_key ]) as $id)
            {
                $rpool_friends[ $sort_key ][ $id ][ "Ranking" ]=$pos;
            }

            $pos+=count($rpool_friends[ $sort_key ]);
            
            $pool_friends=
                array_merge
                (
                    $pool_friends,
                    $rpool_friends[ $sort_key ]
                );
        }

        $this->Pool_Rankings_Store($pool,$pool_friends);
        
        return $pool_friends;
    }
    
    //*
    //* 
    //*

    function Pool_Ranking_Sort($pool,$pool_friend)
    {
        $scores=$pool_friend[ "Scores" ];

        $sort_value=
            sprintf
            (
                "%06d",
                $pool_friend[ "Points" ]
            );
        
        foreach ($this->PoolsObj()->Pool_Scores() as $score)
        {
            $sort_value.=
                sprintf
                (
                    "%06d",
                    $scores[ $score ]
                );
        }

        return $sort_value;
    }
    
    //*
    //* 
    //*

    function Pool_Rankings_Store($pool,$pool_friends)
    {
        $this->Pool_RankingsObj()->Sql_Table_Structure_Update();
        
        $where=
            $this->Pool_Rankings_Where($pool);
        
        foreach ($pool_friends as $pool_friend)
        {
            $where[ "Pool_Friend" ]=$pool_friend[ "ID" ];
            
            $ranking=
                $this->Pool_RankingsObj()->Sql_Select_Hash
                (
                    $where,
                    array("ID","Ranking","Points")
                );

            if (empty($ranking))
            {
                //Create
                $ranking=
                    array_merge
                    (
                        $where,
                        array
                        (
                            "Friend"      => $pool_friend[ "Friend" ],
                            "Pool_Friend" => $pool_friend[ "ID" ],
                            "Ranking"     => $pool_friend[ "Ranking" ],
                            "Points"      => $pool_friend[ "Points" ],
                        )
                    );

                $this->Pool_RankingsObj()->Sql_Insert_Item($ranking);
            }
            else
            {
                //Update

                $updatedatas=array();
                foreach (array("Ranking","Points") as $data)
                {
                    if
                        (
                            !isset($ranking[ $data ])
                            ||
                            intval($ranking[ $data ])!=intval($pool_friend[ $data ])
                        )
                    {
                        //var_dump($ranking[ $data ],$pool_friend[ $data ]);
                        $ranking[ $data ]=intval($pool_friend[ $data ]);
                        array_push($updatedatas,$data);
                    }
                }

                if (count($updatedatas)>0)
                {
                    //var_dump($updatedatas);
                    $this->Pool_RankingsObj()->Sql_Update_Item_Values_Set
                    (
                        $updatedatas,$ranking
                    );

                }
            }
        }
    }
}

?>