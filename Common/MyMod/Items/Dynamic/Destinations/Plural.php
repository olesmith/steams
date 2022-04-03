<?php


trait MyMod_Items_Dynamic_Destinations_Plural
{
    //*
    //* Create Destination rows.
    //*

    function MyMod_Items_Dynamic_Destination_Plural_Rows($group)
    {
        return
            array
            (
                $this->MyMod_Items_Dynamic_Destination_Plural_Row($group)
            );
    }


    //*
    //* 
    //*

    function MyMod_Items_Dynamic_Destination_Plural_Row($group)
    {
        $row=
            array
            (
                "Row" => array
                (
                    "",
                    $this->MyMod_Items_Dynamic_Destination_Plural_Cell($group),
                ),
                "Options" => array
                (
                    "ID" => $this->MyMod_Item_Dynamic_Destination_Row_ID
                    (
                        array()
                    ),
                    "STYLE" => "display: none;"
                )
            );

        return $row;
    }
    
    //*
    //* 
    //*

    function MyMod_Items_Dynamic_Destination_Plural_Cell($group)
    {
        return
            array
            (
                "Cell" =>
                array
                (
                    "",
                ),
                "Options" => array
                (
                    "ID" => $this->MyMod_Item_Dynamic_Destination_Cell_ID
                    (
                        array(),
                        $group,
                        "Plural"
                    ),
                )
            );
    }
}

?>