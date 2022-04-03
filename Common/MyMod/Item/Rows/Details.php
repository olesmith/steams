<?php

trait MyMod_Item_Rows_Details
{
    //*
    //* Creates row with open/close item link.
    //*

    function MyMod_Item_Rows_Details($edit,$setup,$item)
    {
        return
            $this->Htmls_DIV
            (
                $this->Htmls_Table
                (
                    "",
                    $this->MyMod_Item_Rows_Rows($edit,$setup,$item)
                ),
                array
                (
                    "CLASS" => 'center',
                )                
            );
    }

    //*
    //* 
    //*

    function MyMod_Item_Rows_Details_Should($setup,$item)
    {
        return ($this->CGI_GETint($setup[ "GET" ])==$item[ "ID" ]);
    }

        
}

?>