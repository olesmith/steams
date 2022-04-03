<?php

include_once("Display/Global.php");
include_once("Display/Months.php");
include_once("Display/Rounds.php");

trait Pool_Rankings_Display
{
    use
        Pool_Rankings_Display_Global,
        Pool_Rankings_Display_Months,
        Pool_Rankings_Display_Rounds;
    
    var $N=3;
    
    //*
    //* 
    //*

    function Pool_Rankings_Display_Handle()
    {
        $pool=$this->Pool();
        
        $rankings_global=
            $this->Sql_Select_Hashes
            (
                array_merge
                (
                    $this->Pool_Rankings_Where($pool),
                    array
                    (
                        "__N__" => "Ranking<='".$this->N."'",
                    )
                ),
                array(),
                $orderby="Ranking,Name,ID"
            );


        $this->Htmls_Echo
        (
            array
            (
                $this->Htmls_H
                (
                    1,
                    $this->MyMod_ItemsName()
                ),

                $this->Htmls_Table
                (
                    "",
                    array_merge
                    (
                        $this->Pool_Rankings_Display_Global_Table($pool),
                        $this->Pool_Rankings_Display_Months_Tables($pool),
                        $this->Pool_Rankings_Display_Rounds_Tables($pool)
                    )
                ),
            )
        );       
    }
    
    //*
    //* 
    //*

    function Pool_Rankings_Display_Read($pool,$where=array())
    {
        return
            $this->Sql_Select_Hashes
            (
                array_merge
                (
                    $this->Pool_Rankings_Where($pool),
                    array
                    (
                        "__N__" => "Ranking<='".$this->N."'",
                    ),
                    $where
                ),
                array(),
                $orderby="Ranking,Name,ID"
            );
    }
}

?>