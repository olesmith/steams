<?php

trait MyApp_Handle_Tables
{
    var $MyApp_Handle_Tables_Modules=array();
    
    //*
    //* Generates nested tables.
    //*

    function MyApp_Handle_Tables($edit,$module,$where=array())
    {
        $setup=$this->MyApp_Handle_Tables_Modules[ $module ];

        $moduleobj=$this->MyApp_Module_GetObject($module);

        
        $this->Htmls_Echo
        (
            array
            (
                $moduleobj->MyMod_Items_Rows_Html
                (
                    0,0,
                    $setup,
                    $where
                ),
            )
        );
    }
    
}

?>