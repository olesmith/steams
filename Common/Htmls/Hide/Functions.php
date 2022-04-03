<?php

trait Htmls_Hide_Functions
{
    //*
    //* 
    //*

    function Htmls_Hide_Functions_Hide($spanid,$by)
    {
        return
            "\n".
            join
            (
                ";\n",
                array
                (
                    "Do_Hide_Elements_By_ID('On".  $spanid  ."')",
                    "Do_Show_Elements_By_ID('Off".  $spanid  ."') ",
                    "Do_Hide_Elements_By_".$by."('".  $spanid  ."')",
                )
            ).";";
    }

    //*
    //* 
    //*

    function Htmls_Hide_Functions_Show($spanid,$by)
    {
        return
            "\n".
            join
            (
                ";\n",
                array
                (
                    "Do_Show_Elements_By_ID('On".  $spanid  ."')",
                    "Do_Hide_Elements_By_ID('Off".  $spanid  ."') ",
                    "Do_Show_Elements_By_".$by."('".  $spanid  ."')",
                )
            ).";";
    }

    
    //*
    //* 
    //*

    function Htmls_Hide_Functions_Element_By_ID_Show($element_id,$display)
    {
        return
            "\n".
            join
            (
                ";\n",
                array
                (
                    "Do_Show_Element_By_ID('".  $element_id  .",".$display."')",
                )
            ).";";
    }
    //*
    //* 
    //*

    function Htmls_Hide_Functions_Element_By_ID_Hide($element_id)
    {
        return
            "\n".
            join
            (
                ";\n",
                array
                (
                    "Do_Hide_Element_By_ID('".  $element_id  ."')",
                )
            ).";";
    }
}


?>