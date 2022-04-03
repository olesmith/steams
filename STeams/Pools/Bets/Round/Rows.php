<?php

trait Pool_Bets_Round_Rows
{       
    //*
    //* 
    //*

    function Pool_Bet_Round_Rows($edit,$n,$matches,$pool_friend)
    {
        return
            array
            (
                array
                (
                    "Row" => $this->Pool_Bet_Round_Row
                    (
                        $edit,$n,$matches,$pool_friend
                    ),
                    "Options" => array
                    (
                        "ONMOUSEOVER" => "Highlight_TR(this,'lightgray');",
                        "ONMOUSEOUT" =>  "Highlight_TR(this);",
                    ), 
                ),
            );
    }
    
    //*
    //* 
    //*

    function Pool_Bet_Round_Row($edit,$n,$matches,$pool_friend)
    {
        $row=
            array
            (
                $this->B($n),
                $pool_friend[ "Name" ]
            );

        $m=0;
        foreach ($matches as $match)
        {
            $m++;            
            array_push
            (
                $row,
                $this->Pool_Bet_Round_Cells_SPAN
                (
                    $edit,
                    $m,
                    $match,$pool_friend
                )
            );
        }

        //Summed Points
        array_push
        (
            $row,
            $this->B
            (
                $this->Sql_Select_Calc
                (
                    array
                    (
                        "Tournament"       => $this->Tournament("ID"),
                        "Tournament_Round" => $this->Round("ID"),
                        "Pool_Friend"           => $pool_friend[ "ID" ],
                    ),
                    "Points"
                )
            ),
            $this->B
            (
                $this->Sql_Select_Calc
                (
                    array
                    (
                        "Tournament"       => $this->Tournament("ID"),
                        "Pool_Friend"       => $pool_friend[ "ID" ],
                    ),
                    "Points"
                )
            )
        );

        return $row;
    }
}

?>