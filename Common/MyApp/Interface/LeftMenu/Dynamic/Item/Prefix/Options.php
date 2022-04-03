<?php

include_once("Common/JS.php");

trait MyApp_Interface_LeftMenu_Dynamic_Item_Prefix_Options
{    
    //*
    //* Prefix div field options
    //*

    function MyApp_Interface_LeftMenu_Dynamic_Item_Prefix_Options($base,$obj,$item,$active,$type,$href,$options=array())
    {
        if ($active)
        {
            $style[ "display" ]="initial";
            $style[ "color" ]="blue";
        }
        else
        {
            $style[ "display" ]="none";
            $style[ "color" ]="grey";
        }

        $onclick=
            $this->MyApp_Interface_LeftMenu_Dynamic_Item_Prefix_ONCLICK
            (
                $base,$obj,$item,$active,$href,$type
            );

        return
            array_merge
            (
                $options,
                array
                (
                    "CLASS" => 'leftmenulinks',
                    "ID" => $this->MyApp_Interface_LeftMenu_Dynamic_Item_ID
                    (
                        $base,$obj,$item,
                        $type
                    ),
                    "STYLE" => $this->MyApp_Interface_LeftMenu_Dynamic_Item_Prefix_STYLE
                    (
                        $base,$obj,$item,$active,$style
                    ),
                
                    "ONCLICK" => $onclick,

                    "TITLE" => $onclick,
                )
            );   
    }
}

?>