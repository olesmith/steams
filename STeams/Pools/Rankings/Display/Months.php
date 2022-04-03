<?php

trait Pool_Rankings_Display_Months
{
    //*
    //* 
    //*

    function Pool_Rankings_Display_Months_Tables($pool)
    {
        $this_month=
            $this->CurrentYear().
            sprintf("%02d",$this->CurrentMonth());

        $table=array();
        foreach
            (
                $this->PoolsObj()->Pool_Ranking_Months($pool)
                as $month
            )
        {
            if ($this_month<$month) { continue; }
            
            $table=
                array_merge
                (
                    $table,
                    $this->Pool_Rankings_Display_Month_Table($pool,$month)
                );
        }
            
        return $table;
    }
    
    //*
    //* 
    //*

    function Pool_Rankings_Display_Month_Name($pool,$month)
    {
        $rmonth=$month;
        if (preg_match('/(\d\d\d\d)(\d\d)/',$month,$matches))
        {
            $rmonth=$matches[2]." ".$matches[1];
        }

        return $rmonth;
    }
    
    //*
    //* 
    //*

    function Pool_Rankings_Display_Month_Table($pool,$month)
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
                            $this->MyLanguage_GetMessage("Month").":",
                            $this->Pool_Rankings_Display_Month_Name
                            (
                                $pool,$month
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
                            "Month" => $month,
                        )
                    ),
                    $group="Basic"
                )
            );
    }
}

?>