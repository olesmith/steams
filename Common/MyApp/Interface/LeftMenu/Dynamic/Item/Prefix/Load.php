<?php

//include_once("Common/JS.php");

trait MyApp_Interface_LeftMenu_Dynamic_Item_Prefix_Load
{
    //*
    //* The load part of ONCLICK for $item Prefix Add (+).
    //*

    function MyApp_Interface_LeftMenu_Dynamic_Item_Prefix_Load($base,$obj,$item,$href)
    {
        return
            array
            (
                $this->JS_Load_Once
                (
                    $this->MyApp_Interface_LeftMenu_Dynamic_Item_Prefix_URL
                    (
                        $base,$obj,$item,$href
                    ),
                    $this->MyApp_Interface_LeftMenu_Dynamic_Item_ID
                    (
                        $base,$obj,$item,
                        "LM"
                    ),
                    $display='initial'
                ),
                $this->MyApp_Interface_LeftMenu_Dynamic_Item_Prefix_Load_ModuleCell
                (
                    $base,$obj,$item,$href
                )
            );
    }
    //*
    //* Prefix URL
    //*

    function MyApp_Interface_LeftMenu_Dynamic_Item_Prefix_URL($base,$obj,$item,$href)
    {
        return
            array_merge
            (
                $this->URL_CommonArgs,
                array
                (
                    "Action" => "LeftMenu",
                    "Module" => $obj->ModuleName,
                    "ID"     => $item[ "ID" ],
                ),
                $this->MyApp_Interface_LeftMenu_Dynamic_Item_Prefix_Args
                (
                    $base,$obj,$item
                )
            );
    }
    
    //*
    //* The load part of ONCLICK for $item Prefix Add (+).
    //*

    function MyApp_Interface_LeftMenu_Dynamic_Item_Prefix_Load_ModuleCell($base,$obj,$item,$href)
    {
        if (empty($href)) { return ""; }
        
        return
            "\n".
            $this->MyApp_Interface_LeftMenu_Generate_SubMenu_Item_ONCLICK
            (
                "?".$this->Filter
                (
                    $this->CGI_Hash2URI
                    (
                        array_merge
                        (
                            $this->CGI_URI2Hash($href),
                            array
                            (
                                "RAW" => 1,
                                "Menu" => 1,
                                "Search" => 1,
                                "Dest" => "ModuleCell",
                            )
                        )
                    ),
                    $item
                ),
                $item
            );
    }
}

?>