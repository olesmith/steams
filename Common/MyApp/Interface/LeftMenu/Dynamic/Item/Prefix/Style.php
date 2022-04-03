<?php

include_once("Common/JS.php");

trait MyApp_Interface_LeftMenu_Dynamic_Item_Prefix_Style
{
    //*
    //* 
    //*

    function MyApp_Interface_LeftMenu_Dynamic_Item_Prefix_STYLE($base,$obj,$item,$active,$style=array())
    {
        if ($active)
        {
            $style[ "display" ]="initial";
        }
        else
        {
            $style[ "display" ]="none";
        }

        return $style;
    }    
}

?>