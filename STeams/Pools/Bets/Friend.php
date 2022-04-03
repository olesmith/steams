<?php

trait Pool_Bets_Friend
{
    //*
    //* 
    //*

    function Pool_Bets_Friend_Handle()
    {
        $this->Htmls_Echo
        (
            array
            (
                $this->Pool_Bets_Friend_Form()
            )
        );
    }
    //*
    //* 
    //*

    function Pool_Bets_Friend_Get()
    {
        return
            $this->Pool_FriendsObj()->Sql_Select_Hash
            (
                array("ID" => $this->CGI_GETint("Owner"))
            );
    }
    
    //*
    //* 
    //*

    function Pool_Bets_Friend_Form()
    {
        return        
            array
            (
                $this->Htmls_Form
                (
                    $this->Pool_Bets_Round_Edit(),
                    "Bets_Round_".$this->Round("ID"),
                    "",

                    //$contents=
                    array
                    (
                        $this->Pool_Bets_Friend_Html(),
                    ),

                    //$args=
                    array
                    (
                        "Hiddens" => array
                        (
                            "Save" => 1,
                        ),
                        "Buttons" => $this->Buttons(),
                    )
                )
            );
    }
    
    //*
    //* 
    //*

    function Pool_Bets_Friend_Edit($bet)
    {
        $edit=0;
        if ($this->Pool_Bet_Access_Edit($bet))
        {
            $edit=1;
        }
        
        return $edit;
    }
    
    //*
    //* 
    //*

    function Pool_Bets_Friend_Html()
    {
        $pool_friend=
            $this->Pool_Bets_Friend_Get();
        
        return
            array
            (
                $this->Htmls_H
                (
                    1,
                    array
                    (
                        $this->Pool_BetsObj()->MyMod_ItemsName()
                    )
                ),
                $this->Htmls_H
                (
                    2,
                    array
                    (
                        $this->Pool_FriendsObj()->MyMod_ItemName(),
                        $this->MyLanguage_GetMessage("by"),
                        $this->RoundsObj()->MyMod_ItemName(),
                    )
                ),
                $this->Htmls_Table
                (
                    array(),
                    $this->Pool_Bets_Friend_Table($pool_friend)
                )
            );
    }

    var $__Bets_Friend__=array();
    
    //*
    //* 
    //*

    function Pool_Bets_Friend_Table($pool_friend)
    {
        $time=time();

        $this->Pool_Bets_Friend_Read();
        
        $table=array();
        $n=0;
        foreach
            (
                $this->Pool_Bets_Friend_Read_Rounds()
                as $round
            )
        {
            $n++;
            $table=
                array_merge
                (
                    $table,
                    $this->Pool_Bets_Friend_Rows
                    (
                        $pool_friend,$n,$round
                    )
                );
        }

        array_push($table,array(array(time()-$time),"seconds"));
        
        return $table;
    }
    
    //*
    //* 
    //*

    function Pool_Bets_Friend_Rows($pool_friend,$n,$round)
    {
        $matches=
            $this->Pool_Bets_Friend_Read_Round_Matches($round);

        $options=
            $this->Pool_Bets_Friend_Rows_Options($round);
        
        return
            array
            (
                array
                (
                    $this->Htmls_H
                    (
                        3,
                        array
                        (
                            $this->RoundsObj()->MyMod_ItemName(),
                            $round[ "Number" ].
                            ": ",
                            $this->RoundsObj()->MyMod_Data_Field
                            (
                                0,$round,"StartDate"
                            ),
                            " - ",   
                            $this->RoundsObj()->MyMod_Data_Field
                            (
                                0,$round,"EndDate"
                            ),
                        )
                    )
                ),
                array
                (
                    $this->Htmls_H
                    (
                        4,
                        array
                        (
                            $pool_friend[ "Name" ]
                        )
                    )
                ),
                array
                (
                    "Row" => $this->Pool_Bets_Friend_Row_Round_Matches
                    (
                        $n,$round,$matches
                    ),
                    "Options" => $options,
                ),
                array
                (
                    "Row" => $this->Pool_Bets_Friend_Row_Round_Scores
                    (
                        $n,$round,$matches
                    ),
                    "Options" => $options,
                ),
                array
                (
                    "Row" => $this->Pool_Bets_Friend_Row_Round
                    (
                        $n,$round,$matches
                    ),
                    "Options" => $options,
                ),
                array
                (
                    "","",
                    
                    $this->Htmls_Multi_Cell
                    (
                        "<HR>",
                        3*count($matches)+2
                    )
                )
            );
    }
    
    //*
    //* 
    //*

    function Pool_Bets_Friend_Rows_Options($round)
    {
        return
            array
            (
                "ONMOUSEOVER" => "Highlight_TR(this,'lightgray');",
                "ONMOUSEOUT" =>  "Highlight_TR(this);",
            ); 
    }
    
    //*
    //* 
    //*

    function Pool_Bets_Friend_Row_Round_Matches($n,$round,$matches)
    {
        $row=
            $this->Pool_Bets_Friend_Row_Leading($n,$round,$matches);
        
        $empty="***";
        foreach ($matches as $match)
        {
            $row=
                array_merge
                (
                    $row,
                    $this->MatchesObj()->Tournament_Match_Cells_Teams_Icons
                    (
                        $match
                    )
                );

            array_push($row,$empty);
        }

        return $row;        
    }
    
    //*
    //* 
    //*

    function Pool_Bets_Friend_Row_Round_Scores($n,$round,$matches)
    {
        $row=
            $this->Pool_Bets_Friend_Row_Empty($n,$round,$matches);
        
        $empty="***";
        
        foreach ($matches as $match)
        {
            $row=
                array_merge
                (
                    $row,
                    $this->MatchesObj()->Tournament_Match_Cells_Score
                    (
                        $match
                    )
                );

            array_push($row,$empty);
        }

        return $row;        
    }
    
    //*
    //* 
    //*

    function Pool_Bets_Friend_Row_Round($n,$round,$matches)
    {
        $row=
            $this->Pool_Bets_Friend_Row_Empty
            (
                $n,$round,$matches,
                $this->B($this->MyMod_ItemsName().":")
            );

        $empty="***";
        
        foreach ($matches as $match)
        {
            $row=
                array_merge
                (
                    $row,
                    $this->Pool_Bets_Friend_Cells($round,$match)
                );

            array_push($row,$empty);
        }

        return $row;
    }
    
    //*
    //* 
    //*

    function Pool_Bets_Friend_Row_Leading($n,$round,$matches)
    {
        return
            array
            (
                $this->B($n),
            );
    }
    
   //*
    //* 
    //*

    function Pool_Bets_Friend_Row_Empty($n,$round,$matches,$last="")
    {
        $row=array();
        for ($n=0;$n<0;$n++)
        {
            array_push($row,"");
        }
        
        array_push($row,$last);
        return $row;
    }
    
    //*
    //* 
    //*

    function Pool_Bets_Friend_Cells($round,$match)
    {
        $pool_friend=$this->Pool_Bets_Friend_Get();
        
        $bet=
            $this->Pool_Bets_Friend_Round_Match_Get($round,$match);

        return
            $this->Pool_Bet_Round_Cells
            (
                $this->Pool_Bets_Friend_Edit($bet),
                $match,$pool_friend,
                $bet
            );
        
    }

    
    //*
    //* 
    //*

    function Pool_Bets_Friend_Read_Round_Matches($round)
    {
        return
            $this->MatchesObj()->Sql_Select_Hashes
            (
                array
                (
                    "Tournament"       => $this->Tournament("ID"),
                    "Tournament_Round" => $round[ "ID" ],
                ),
                array()
            );
    }
    
    //*
    //* 
    //*

    function Pool_Bets_Friend_Read_Rounds($sort="StartDate,Number")
    {
        return
            $this->RoundsObj()->MyMod_Items_PostProcess
            (
                $this->RoundsObj()->Sql_Select_Hashes
                (
                    array
                    (
                        "Tournament"       => $this->Tournament("ID"),
                    ),
                    array(),
                    $sort
                ),
                True
            );
    }
    
    //*
    //* 
    //*

    function Pool_Bets_Friend_Read()
    {
        $pool_friend=$this->Pool_Bets_Friend_Get();
        
        $bets=
            $this->Sql_Select_Hashes
            (
                array
                (
                    "Tournament"  => $this->Tournament("ID"),
                    "Pool"        => $pool_friend[ "Pool" ],
                    "Season"      => $pool_friend[ "Season" ],
                    "Pool_Friend" => $pool_friend[ "ID" ],
                )
            );
        
        foreach ($bets as $bet)
        {
            $rid=$bet[ "Tournament_Round" ];
            $mid=$bet[ "Tournament_Match" ];

            if (empty($this->__Bets_Friend__[ $rid ]))
            {
                $this->__Bets_Friend__[ $rid ]=array();
            }

            $this->__Bets_Friend__[ $rid ][ $mid ]=$bet;
        }        
    }

    //*
    //* 
    //*

    function Pool_Bets_Friend_Round_Get($round)
    {
        $rid=$round[ "ID" ];
        if (!empty($this->__Bets_Friend__[ $rid ]))
        {
            return $this->__Bets_Friend__[ $rid ];
        }

        return array();
    }
    
    //*
    //* 
    //*

    function Pool_Bets_Friend_Round_Match_Get($round,$match)
    {
        $rid=$round[ "ID" ];
        $mid=$match[ "ID" ];
        
        if
            (
                !empty($this->__Bets_Friend__[ $rid ])
                &&
                !empty($this->__Bets_Friend__[ $rid ][ $mid ])
            )
        {
            return $this->__Bets_Friend__[ $rid ][ $mid ];
        }

        
        //var_dump("$rid $mid empty match");
        return
            $this->Pool_Bet_Round_Read_Create
            (
                $match,
                $this->Pool_Bets_Friend_Get()
            );
    }
}

?>