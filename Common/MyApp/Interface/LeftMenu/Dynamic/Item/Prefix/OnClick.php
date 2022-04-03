<?php

include_once("Common/JS.php");

trait MyApp_Interface_LeftMenu_Dynamic_Item_Prefix_OnClick
{
    //*
    //* ONCLICK  for $item Prefix DIV.
    //*

    function MyApp_Interface_LeftMenu_Dynamic_Item_Prefix_ONCLICK($base,$obj,$item,$visible,$href,$type="")
    {
        $shows=
            array
            (
                $this->MyApp_Interface_LeftMenu_Dynamic_Item_ID
                (
                    $base,$obj,$item,"LM"
                ),
                $this->MyApp_Interface_LeftMenu_Dynamic_Item_ID
                (
                    $base,$obj,$item,"Sub"
                ),
            );
        
         $hides=
            array
            (
                $this->MyApp_Interface_LeftMenu_Dynamic_Item_ID($base,$obj,$item,"Add"),
            );
        
        if (!$visible)
        {
            $tmp=$shows;
            $shows=$hides;
            $hides=$tmp;
        }
        
        $js=
            array
            (
                $this->JS_Show_Elements_By_ID($shows,'initial'),
                $this->JS_Hide_Elements_By_ID($hides),
            );

        if ($type=="Add")
        {
            array_push
            (
                $js,
                $this->MyApp_Interface_LeftMenu_Dynamic_Item_Prefix_Load
                (
                    $base,
                    $obj,
                    $item,
                    $href
                )
            );
        }
        
        return $js;
    }
}

?>