<?php

include_once("Paging/Format.php");
include_once("Paging/CGI.php");
include_once("Paging/Values.php");
include_once("Paging/Items.php");
include_once("Paging/Cells.php");
include_once("Paging/Row.php");
include_once("Paging/Select.php");

trait MyMod_Search_Options_Paging
{
    use
        MyMod_Search_Options_Paging_Format,
        MyMod_Search_Options_Paging_CGI,
        MyMod_Search_Options_Paging_Values,
        MyMod_Search_Options_Paging_Items,
        MyMod_Search_Options_Paging_Cells,
        MyMod_Search_Options_Paging_Row,
        MyMod_Search_Options_Paging_Select;
    
    var $MyMod_Search_Options_Page_Key="Page";
    var $MyMod_Search_Options_No_Paging_Key="NoPaging";
    var $MyMod_Search_Options_NItems_PP_Key="NItemsPerPage";

    
    //*
    //* Genrate Paging Rows: Row_1 and Row_2
    //*

    function MyMod_Search_Options_Paging_Rows($omitvars)
    {
        //Skip if requested
        if (!$this->MyMod_Search_Option_Should("Paging",$omitvars))
        {
            return array();
        }
        
        return
            array
            (
                $this->MyMod_Search_Options_Paging_Row_1($omitvars),
                $this->MyMod_Search_Options_Paging_Row_2($omitvars),
            );
    }
}

?>