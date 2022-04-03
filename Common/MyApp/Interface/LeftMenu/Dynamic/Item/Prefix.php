<?php

include_once("Prefix/Icon.php");
include_once("Prefix/Style.php");
include_once("Prefix/OnClick.php");
include_once("Prefix/Load.php");
include_once("Prefix/Options.php");

trait MyApp_Interface_LeftMenu_Dynamic_Item_Prefix
{
    use
        MyApp_Interface_LeftMenu_Dynamic_Item_Prefix_Icon,
        MyApp_Interface_LeftMenu_Dynamic_Item_Prefix_Style,
        MyApp_Interface_LeftMenu_Dynamic_Item_Prefix_OnClick,
        MyApp_Interface_LeftMenu_Dynamic_Item_Prefix_Load,
        MyApp_Interface_LeftMenu_Dynamic_Item_Prefix_Options;
    
    //*
    //* Generates Dynamic Left menu for list of $items.
    //*

    function MyApp_Interface_LeftMenu_Dynamic_Item_Prefixes($base,$obj,$item,$activeid,$name,$title,$href,$class)
    {
        $options=
            array
            (
                //"COLOR" => $this->MyMod_Items_Dynamic_Icon_Color_Show,
            );

        return
            array
            (
                $this->MyApp_Interface_LeftMenu_Dynamic_Item_Prefix_Icon
                (
                    $base,$obj,$item,True,$name,$title,$href,$class,
                    "Add",
                    $options
                ),
                $this->MyApp_Interface_LeftMenu_Dynamic_Item_Prefix_Icon
                (
                    $base,$obj,$item,False,$name,$title,$href,$class,
                    "Sub",
                    $options
                ),
            );
    }
        
    //*
    //* Function returning CGI arguments to transfer between submenus.
    //* Should be overriden my specific app.
    //*

    function MyApp_Interface_LeftMenu_Dynamic_Item_Prefix_Args($base,$obj,$item)
    {
        return array();
    }
}

?>