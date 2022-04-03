<?php


trait MyMod_Items_Dynamic_Rows
{
    //*
    //* Adds to row for displaying $item $dynamics.
    //*

    function MyMod_Item_Dynamic_Rows($edit,$n,$item,$group)
    {
        return
            array
            (
                //Row with toggable links
                $this->MyMod_Item_Dynamic_Row
                (
                    $edit,
                    $n,
                    $item,
                    $group
                ),

                
                //Row with destinations
                $this->MyMod_Item_Dynamic_Destination_Item_Row
                (
                    $item,
                    $group
                ),
            );
    }
}

?>