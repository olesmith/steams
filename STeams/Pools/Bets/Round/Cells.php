<?php

trait Pool_Bets_Round_Cells
{       
    //*
    //* 
    //*

    function Pool_Bet_Round_Cells_SPAN($edit,$m,$match,$pool_friend,$bet=array())
    {
        return
            array
            (
                "Cell" => $this->Pool_Bet_Round_Cells
                (
                    $edit,$match,$pool_friend,$bet
                ),
                "Options" => $this->Pool_Bet_Round_Cell_Options
                (
                    $edit,$m,$match,$pool_friend,$bet
                )
            );
    }
    //*
    //* 
    //*

    function Pool_Bet_Round_Cell_Options($edit,$m,$match,$pool_friend=array(),$bet=array())
    {
        return
            array
            (
                "STYLE" => array
                (
                    "white-space" => "nowrap",
                    "background-color" => $this->Pool_Bet_Round_Cell_Color
                    (
                        $m
                    ),
                ),
            );
    }
    
    
    //*
    //* 
    //*

    function Pool_Bet_Round_Cell_Color($m)
    {
        $back_color="#e6f2ff";
        if ( ($m%2)==0) { $back_color="#ffeee6"; }

        return $back_color;
    }
    
    //*
    //* 
    //*

    function Pool_Bet_Round_Cells($edit,$match,$pool_friend,$bet=array())
    {
        if (empty($bet))
        {
            $bet=
                $this->Pool_Bet_Round_Read_Create
                (
                    $match,$pool_friend
                );
        }

        $permissions=
            $this->Pool_Bet_Permissions($bet,$match);

        if ($permissions<1) { return array(""); }
        
        if
            (
                $permissions==2
                &&
                $this->CGI_POSTint("Save")==1
            )
        {
            $this->Pool_Bet_Round_Update($match,$pool_friend,$bet);
        }
        
        $edit=min($edit,$permissions-1);

        return
            $this->Htmls_Span
            (
                array
                (
                    $this->Pool_Bet_Round_Cell($edit,1,$match,$pool_friend,$bet),
                    "-",
                    $this->Pool_Bet_Round_Cell($edit,2,$match,$pool_friend,$bet),
                    $this->BR(),
                    $this->Pool_Bet_Round_Cell_Points($edit,$match,$pool_friend,$bet)
                ),
                array
                (
                )
            );
    }
    
     
    //*
    //* 
    //*

    function Pool_Bet_Round_Cell_Points($edit,$match,$pool_friend,$bet)
    {
        $title="-";
        if (!empty($bet[ "Points" ]))
        {
            $title=$bet[ "Points" ]." pts";
        }

        return $title;
    }
    //*
    //* 
    //*

    function Pool_Bet_Round_Cell($edit,$n,$match,$pool_friend,$bet)
    {
        if ($bet[ "Goals".$n ]=="")
        {
            $bet[ "Goals".$n ]=="-";
        }

        //var_dump($bet[ "Goals".$n ]);
        return
            $this->MyMod_Data_Field
            (
                $edit,
                $bet,
                "Goals".$n,
                True
            );
    }
}

?>