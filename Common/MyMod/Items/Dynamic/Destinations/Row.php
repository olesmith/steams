<?php

trait MyMod_Items_Dynamic_Destinations_Row
{
    //*
    //* Adds to row for displaying $item dynamically.
    //*

    function MyMod_Item_Dynamic_Destination_Item_Row($item,$group)
    {
        return
            array
            (
                "Row" => $this->MyMod_Item_Dynamic_Destination_Item_Cells
                (
                    $item,$group
                ),
                "Options" => $this->MyMod_Item_Dynamic_Destination_Item_Row_Options
                (
                    $item
                )
            );
    }
    
    //*
    //* Adds to row for displaying $item $dynamics.
    //*

    function MyMod_Item_Dynamic_Destination_Item_Row_Options($item)
    {
        return
            array
            (
                "ID" =>
                $this->MyMod_Item_Dynamic_Destination_Row_ID
                (
                    $item
                ),
                    
                "STYLE" => array
                (
                    'display'     => 'none',
                    'margin-left' => '10px',
                )
            );
    }
    
}

?>