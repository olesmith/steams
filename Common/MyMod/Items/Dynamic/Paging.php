<?php

include_once("Paging/Entry.php");
include_once("Paging/Entries.php");
include_once("Paging/Destination.php");
include_once("Paging/Destinations.php");


trait MyMod_Items_Dynamic_Paging
{
    use
        MyMod_Items_Dynamic_Paging_Entry,
        MyMod_Items_Dynamic_Paging_Entries,
        MyMod_Items_Dynamic_Paging_Destination,
        MyMod_Items_Dynamic_Paging_Destinations;
    
    //*
    //* Dynamic items paging menu.
    //*

    function MyMod_Items_Dynamic_Paging($items_table)
    {
        if ($this->MyMod_Paging_N==1) { return array($items_table); }
        
        return
            array
            (
                $this->Htmls_Menues_Dynamic
                (
                    //$menu info
                    array
                    (
                        "Items_Per_Line" => 6,
                        "Name" =>
                        $this->Htmls_H(4,$this->MyLanguage_GetMessage("Pages").":"),
                        
                        "Color" => "orange",
                        "Hide_Color" => "grey",
                        "Reload_Color" => "#efa572",
                        "Toggle_Others" => True,
                    ),

                
                    //Entries
                    $this->MyMod_Items_Dynamic_Paging_Entries(),

                    //Destinations
                    $this->MyMod_Items_Dynamic_Paging_Destinations($items_table)
                ),
            );
    }
    
    //*
    //* 
    //*

    function MyMod_Items_Dynamic_Paging_Title($items)
    {
        return
            $this->Htmls_H
            (
                1,
                join
                (
                    " ",
                    $this->MyMod_Items_Dynamic_Paging_Titles($items)
                )
            );
            
    }
    //*
    //* 
    //*

    function MyMod_Items_Dynamic_Paging_Titles($items)
    {
        $titles=
            array
            (
                count($items),
                $this->MyMod_ItemsName(),
            );

        if ($this->MyMod_Paging_N>1)
        {
            $titles[ count($titles)-1 ].=",";
            $titles=
                array_merge
                (
                    $titles,
                    array
                    (
                        $this->MyLanguage_GetMessage("Page"),
                        $this->MyMod_Paging_No,
                        $this->MyLanguage_GetMessage("of"),
                        $this->MyMod_Paging_N
                    )
                );
        }

        return $titles;
            
    }
}

?>