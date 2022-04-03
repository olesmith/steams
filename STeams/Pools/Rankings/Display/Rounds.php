<?php

trait Pool_Rankings_Display_Rounds
{
    //*
    //* 
    //*

    function Pool_Rankings_Display_Rounds_Tables($pool)
    {
        $comps=$this->MyTime_Curent_Date_Comps();

        $today=$this->MyTime_2Sort();
        
        $table=array();
        foreach
            (
                $this->Tournament_RoundsObj()->Sql_Select_Hashes
                (
                    $this->Tournament_Season_Where
                    (
                        $pool,
                        array
                        (
                            "__Date__" => "EndDate<='".$today."'" 
                        )
                    ),
                    array(),
                    "StartDate"
                )
                as $round
            )
        {
            $table=
                array_merge
                (
                    $table,
                    $this->Pool_Rankings_Display_Round_Table($pool,$round)
                );
        }
            
        return $table;
    }
    
    //*
    //* 
    //*

    function Pool_Rankings_Display_Round_Table($pool,$round)
    {
        return
            array_merge
            (
                array(array
                (
                    $this->Htmls_H
                    (
                        2,
                        array
                        (
                            $this->Tournament_RoundsObj()->MyMod_ItemName(":"),
                            $round[ "Number" ].":",
                            $this->Tournament_RoundsObj()->MyMod_Data_Field
                            (
                                0,$round,
                                "StartDate"
                            ),
                            "-",
                            $this->Tournament_RoundsObj()->MyMod_Data_Field
                            (
                                0,$round,"EndDate"
                            )
                        )
                    ),
                )),
                
                $this->MyMod_Items_Dynamic_Table
                (
                    0,
                    $this->Pool_Rankings_Display_Read
                    (
                        $pool,
                        array
                        (
                            "Tournament_Round" => $round[ "ID" ],
                        )
                    ),
                    $group="Basic"
                )
            );
    }
}

?>