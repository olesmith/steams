<?php

trait Tournaments_Rounds_Cells
{    
    //*
    //*
    //*

    function Round_Cell_NMatches($edit=0,$item=array(),$data="")
    {
       if (empty($item))
        {
            return "Nº ".$this->MatchesObj()->MyMod_ItemsName();
        }

        $where=
            array
            (
                "Tournament"       => $item[ "Tournament" ],
                "Season"           => $item[ "Season" ],
                "Tournament_Round" => $item[ "ID" ],
            );
        
        $nmatches=
            $this->MatchesObj()->Sql_Select_NHashes($where);

        $text="";
        $color='green';
        /* if ($nmatches<$nmatches_should) */
        /* { */
        /*     $text.=" (".$nmatches_should.")"; */
        /*     $color='red'; */
        /* } */

        $where[ "Status" ]=array(2,3,4);
        $nmatches_finished=
            $this->MatchesObj()->Sql_Select_NHashes($where);

        $text.=" ".$nmatches."/".$nmatches_finished;
        
        return
            $this->Htmls_Span
            (
                $text,
                array
                (
                    "STYLE" => array
                    (
                        "color" => $color,
                    )
                )
            );
    }
    
    //*
    //*
    //*

    function Round_Cell_Friend_NMatches($edit=0,$item=array(),$data="")
    {
        if (empty($item))
        {
            return "Nº ".$this->MatchesObj()->MyMod_ItemsName();
        }

        $where=
            array
            (
                "Tournament"       => $item[ "Tournament" ],
                "Season"           => $item[ "Season" ],
                //"Tournament_Group" => $item[ "Tournament_Group" ],
            );

        $match_where=
            array_merge
            (
                $where,
                array
                (
                    "Tournament_Round" => $item[ "ID" ],
                )
            );

        
        $nmatches=
            $this->MatchesObj()->Sql_Select_NHashes($match_where);

        $nmatches_should=
            $this->Tournament_TeamsObj()->Sql_Select_NHashes($where)/2;

        $text="";
        $color='green';
        if ($nmatches<$nmatches_should)
        {
            $text.=" (".$nmatches_should.")";
            $color='red';
        }

        $match_where[ "Status" ]=array(2,3,4);
        $nmatches_finished=
            $this->MatchesObj()->Sql_Select_NHashes($match_where);

        $text.=" ".$nmatches."/".$nmatches_finished;
        return
            $this->Htmls_Span
            (
                $text,
                array
                (
                    "STYLE" => array
                    (
                        "color" => $color,
                    )
                )
            );
    }
    //*
    //*
    //*

    function Round_Cell_Friend_ID()
    {
        $friend_id=$this->CGI_GET("Friend");
        if (empty($friend_id))
        {
            $friend_id=$this->LoginData("ID");
        }

        return $friend_id;
    }
    
    //*
    //*
    //*

    function Round_Cell_Friend_NBets($edit=0,$item=array(),$data="")
    {
        if (empty($item))
        {
            return "Nº ".$this->Pool_BetsObj()->MyMod_ItemsName();
        }

        $where=
            array
            (
                "Tournament"       => $item[ "Tournament" ],
                //"Season"           => $item[ "Season" ],
                "Tournament_Round" => $item[ "ID" ],
                "Friend" => $this->Round_Cell_Friend_ID(),
            );

        $where1=$where;
        $where1[ "__Goals__" ]="(Goals1!='-' AND Goals2!='-')";

        return
            $this->Pool_BetsObj()->Sql_Select_NHashes($where1).
            "/".
            $this->Pool_BetsObj()->Sql_Select_NHashes($where).
            "";
    }

    var $__Round__=array();
    
    //*
    //* Centralized reading for Round. Called by Common.php.
    //*

    function Round($key="")
    {
        if (empty($this->__Round__))
        {
            $this->__Round__=
                $this->Sql_Select_Hash
                (
                    array("ID" => $this->CGI_POSTOrGETint("Round"))
                );
        }

        if (!empty($key))
        {
            return $this->__Round__[ $key ];
        }
        
        return $this->__Round__;
    }
    
    //*
    //*
    //*

    function Round_Cell_Dates($edit=0,$round=array(),$data="")
    {
        if (empty($round)) { return $this->MyLanguage_GetMessage("Start_End"); }

        $start=$this->MyTime_Date2Hash($round[ "StartDate" ]);
        $end=$this->MyTime_Date2Hash($round[ "EndDate" ]);

        if ($start[ "Year" ]==$end[ "Year" ])
        {
            
            if ($start[ "Month" ]==$end[ "Month" ])
            {
                return
                    join
                    (
                        "/",
                        array
                        (
                            $start[ "Day" ]."-".$start[ "Day" ],
                            $start[ "Month" ],
                            $start[ "Year" ],
                        )
                    );                    
            }
            else
            {
                return                    
                    $start[ "Day" ]."/".$start[ "Month" ].
                    "-".
                    $end[ "Day" ]."/".$end[ "Month" ].
                    "/".
                    $start[ "Year" ].
                    "";
                
            }
        }
        

        return
            array
            (
                $this->MyMod_Data_Field
                (
                    $edit,$round,
                    "StartDate"
                ),
                "-",
                $this->MyMod_Data_Field
                (
                    $edit,$round,
                    "EndDate"
                ),
            );

        return "DDD";
    }
    
    //*
    //*
    //*

    function Round_Cell_Friend_Score($edit=0,$round=array(),$data="")
    {
        if (empty($round)) { return $this->MyLanguage_GetMessage("Score"); }
        
        $pool_friend=
            $this->Pool_FriendsObj()->Pool_Friend_Read();

        $scores=
            $this->Tournament_Round_Friend_Score
            (
                $pool_friend,$round
            );

        return
            $this->Round_Cell_Friend_Scores_DIV($pool_friend,$scores[ "Scores" ]);
    }
    
    //*
    //*
    //*

    function Round_Cell_Friend_Scores_DIV($pool_friend,$scores)
    {
        $cells=array();
        $titles=array();
        $titless=array();
        $points=0;
        foreach ($this->PoolsObj()->Pool_Scores() as $score)
        {
            array_push
            (
                $cells,
                $this->Round_Cell_Friend_Scores_SPAN($score,$scores[ $score ]),
                "-"
            );

            if ($score>0)
            {
                array_push
                (
                    $titles,
                    $score."*".$scores[ $score ]
                );

                array_push
                (
                    $titless,
                    $score*$scores[ $score ]
                );

                $points+=$score*$scores[ $score ];
            }

        }

        //trailing -
        array_pop($cells);
        array_push($cells," &nbsp;&nbsp;",$points);
        
        return
            $this->Htmls_DIV
            (
                $cells,
                array
                (
                    "TITLE" =>
                    join(" + ",$titles).
                    "\n".
                    join(" + ",$titless),
                    "CLASS" => "Result",
                )
            );
    }

    //*
    //*
    //*

    function Round_Cell_Friend_Scores_SPAN($score,$npoints)
    {
        return
            $this->Htmls_SPAN
            (
                $npoints." ",
                array
                (
                    "CLASS" => "Result Result_".$score,
                )
            );
    }

    
    //*
    //*
    //*

    function Tournament_Round_Friend_Score($pool_friend,$round=array(),$month="")
    {
        $where=
            array
            (
                "Tournament"   => $pool_friend[ "Tournament" ],
                "Pool_Friend"  => $pool_friend[ "ID" ],
            );

        if (!empty($round))
        {
            $where[ "Tournament_Round" ]=
                $round[ "ID" ];
        }
        
        elseif (!empty($month))
        {
            $from=$month."01";
            $to=$month."31";

            $matches=
                $this->MatchesObj()->Sql_Select_Unique_Col_Values
                (
                    "ID",
                    array
                    (
                        "__Date__" => "Date>='".$from."' AND Date<='".$to."'",
                    )
                );
            
            $where[ "Tournament_Match" ]=$matches;
        }

        $bets=
            $this->Pool_BetsObj()->Sql_Select_Hashes
            (
                $where,
                array("ID","Points")
            );

        $scores=$this->PoolsObj()->Pool_Scores_Hash();
        foreach ($bets as $bet)
        {
            if (empty($scores[ $bet[ "Points" ] ]))
            {
                $scores[ $bet[ "Points" ] ]=0;
            }
            $scores[ $bet[ "Points" ] ]++;
        }
        
        $scores=
            array
            (
                "Scores" => $scores,
                "Result_Goals" => $this->Pool_BetsObj()->Sql_Select_NHashes
                (
                    array_merge
                    (
                        $where,
                        array
                        (
                            "Result_Goals" => 2,
                        )
                    )
                ),
                "Result_Goal" => $this->Pool_BetsObj()->Sql_Select_NHashes
                (
                    array_merge
                    (
                        $where,
                        array
                        (
                            "Result_Goal" => 2,
                        )
                    )
                ),
                "Result" => $this->Pool_BetsObj()->Sql_Select_NHashes
                (
                    array_merge
                    (
                        $where,
                        array
                        (
                            "Result" => 2,
                        )
                    )
                ),
                "Points" => $this->Pool_BetsObj()->Sql_Select_Calc
                (
                    $where,
                    "Points"
                ),
            );
               
        
        if (empty($scores[ "Points" ]))
        {
            $scores[ "Points" ]=" 0";
        }

        return $scores;
    }
}

?>