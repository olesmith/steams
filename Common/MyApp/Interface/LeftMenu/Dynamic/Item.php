<?php

include_once("Item/Options.php");
include_once("Item/Prefix.php");


trait MyApp_Interface_LeftMenu_Dynamic_Item
{
    use
        MyApp_Interface_LeftMenu_Dynamic_Item_Options,
        MyApp_Interface_LeftMenu_Dynamic_Item_Prefix;
        
    //*
    //* Generates Dynamic Left menu for list of $items.
    //*

    function MyApp_Interface_LeftMenu_Dynamic_Item_Entry($base,$obj,$menumethod,$item,$activeid,$name,$title,$href,$class="leftmenulinks")
    {
        return
            array
            (
                $this->MyApp_Interface_LeftMenu_Dynamic_Item_Prefixes
                (
                    $base,$obj,$item,$activeid,
                    $name,$title,
                    $href,$class
                ),
                $this->Htmls_DIV
                (
                    "",//Called dynamically: $this->$menumethod($item),
                    $this->MyApp_Interface_LeftMenu_Dynamic_Item_Options
                    (
                        $base,
                        $obj,
                        $item,
                        $activeid,
                        $name
                    )
                )
            );

        return $text;
    }

       
    
    //*
    //* Name to display for $item.
    //*

    function MyApp_Interface_LeftMenu_Dynamic_Item_Name($name,$item)
    {
        return $this->Filter($name,$item);
    }
}

?>