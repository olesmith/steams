<?php

include_once("Options/ShowAll.php");
include_once("Options/Edit.php");
include_once("Options/Details.php");
include_once("Options/DataGroups.php");
include_once("Options/Paging.php");
include_once("Options/Latex.php");
include_once("Options/Tabulator.php");
include_once("Options/Sorts.php");
include_once("Options/Reversed.php");
include_once("Options/Export.php");


trait MyMod_Search_Options
{
    var $MyMod_Search_Options_Export_Key="Export";
    var $MyMod_Search_Options_Export_Orientation_Key="Orientation";
    
    var $MyMod_Search_Options_Sort_Key="Sort";
    var $MyMod_Search_Options_Sort_Reversed_Key="Reversed";
    var $MyMod_Search_Options_Sort_N=3;
    
    
    use
        MyMod_Search_Options_ShowAll,
        MyMod_Search_Options_Edit,
        MyMod_Search_Options_Details,
        MyMod_Search_Options_DataGroups,
        MyMod_Search_Options_Paging,
        MyMod_Search_Options_Latex,
        MyMod_Search_Options_Tabulator,
        MyMod_Search_Options_Sorts,
        MyMod_Search_Options_Reversed,
        MyMod_Search_Options_Export;
    
    //*
    //* function MyMod_Search_Options_Rows, Parameter list: $omitvars
    //*
    //* Adds the IncludeAll, Output, Paging and Data Group fields.
    //*

    function MyMod_Search_Options_Rows($omitvars)
    {
        if (preg_grep('/^(All)$/',$omitvars)) { return array(); }
        
        return
            array_merge
            (
                array
                (
                    array_merge
                    (
                        $this->MyMod_Search_Options_Data_Groups_Cells($omitvars),
                        $this->MyMod_Search_Options_Show_All_Cells($omitvars),
                        $this->MyMod_Search_Options_Edit_Row($omitvars)
                    )
                ),
                $this->MyMod_Search_Options_Paging_Rows($omitvars),
                array
                (
                    $this->MyMod_Search_Options_Sort_Cells($omitvars),
                ),
                array
                (
                    array_merge
                    (
                        $this->MyMod_Search_Options_Reversed_Cells($omitvars),
                        $this->MyMod_Search_Options_Export_Cells($omitvars)
                    ),
                ),
                $this->MyMod_Search_Options_Latex_Rows($omitvars,"Plural"),
                $this->MyMod_Search_Options_Tab_Moves_Down_Row($omitvars)
           );
    }
    
    //*
    //* 
    //*

    function MyMod_Search_Option_Should($option,$omitvars)
    {
        if (preg_grep('/^('.$option.'|All)$/',$omitvars)) { return False; }

        return True;
    }
    
    
    
}

?>