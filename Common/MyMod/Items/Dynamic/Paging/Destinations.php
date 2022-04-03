<?php

trait MyMod_Items_Dynamic_Paging_Destinations
{
    //*
    //*
    //*

    function MyMod_Items_Dynamic_Paging_Destinations($items_table)
    {
        $destinations=array();
        for ($n=1;$n<=$this->MyMod_Paging_N;$n++)
        {
            array_push
            (
                $destinations,
                $this->MyMod_Items_Dynamic_Paging_Destination($n,$items_table)
            );
        }

        return $destinations;
    }
}

?>