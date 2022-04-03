<?php

trait MyMod_Items_Dynamic_Plural_Entry
{
    //*
    //* Create plural row.
    //*

    function MyMod_Items_Dynamic_Plural_Entry($items,$group,$action,$def)
    {
        return
            array
            (
                //"Tag" => "SPAN",
                "Hide" => False,
                
                "ID" => join("_",array($group,$action)),
                
                "Icon" => $this->MyMod_Item_Dynamic_Entry_Icon($def),

                "Title" => "title",
                
                "Onclick" => $this->MyMod_Items_Dynamic_Plural_Entry_JS
                (
                    $items,$group,$action,$def
                ),
                
                "Destination" =>
                $this->MyMod_Items_Dynamic_Plural_Destination_ID
                (
                    $items,$group,$action,$def
                ),
            );
    }
}

?>