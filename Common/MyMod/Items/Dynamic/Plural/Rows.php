<?php

trait MyMod_Items_Dynamic_Plural_Rows
{
    //*
    //* Plural row, below items table. For instance addrow.
    //* Create rows with plural dynamic actions, addind Area destination row.
    //*

    function MyMod_Items_Dynamic_Plural_Rows($items,$group,$extrarows)
    {        
        return
            array_merge
            (
                array
                (
                    $this->MyMod_Items_Dynamic_Plural_Menu($items,$group)
                ),
                //$this->MyMod_Items_Dynamic_Destination_Plural_Rows($group),
                $extrarows
            );
    }
}

?>