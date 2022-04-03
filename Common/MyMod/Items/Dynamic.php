<?php

include_once("Dynamic/CheckBoxes.php");
include_once("Dynamic/Actions.php");
include_once("Dynamic/Icon.php");
include_once("Dynamic/Entries.php");
include_once("Dynamic/Entry.php");
include_once("Dynamic/ID.php");
include_once("Dynamic/IDs.php");
include_once("Dynamic/Titles.php");
include_once("Dynamic/Row.php");
include_once("Dynamic/Rows.php");
include_once("Dynamic/Sums.php");

include_once("Dynamic/Destinations.php");



include_once("Dynamic/Table.php");
include_once("Dynamic/Plural.php");
include_once("Dynamic/Load.php");
include_once("Dynamic/UnLoad.php");
include_once("Dynamic/Html.php");
include_once("Dynamic/Paging.php");
include_once("Dynamic/Form.php");

trait MyMod_Items_Dynamic
{
    var $MyMod_Items_Dynamic_Icon_Color_Show="blue";
    var $MyMod_Items_Dynamic_Icon_Color_Hide="grey";
    var $MyMod_Items_Dynamic_Icon_Color_Reload="#5dade2";
    
    use
        MyMod_Items_Dynamic_CheckBoxes,
        MyMod_Items_Dynamic_Actions,
        MyMod_Items_Dynamic_Icon,
        MyMod_Items_Dynamic_Entries,
        MyMod_Items_Dynamic_Entry,
        MyMod_Items_Dynamic_ID,
        MyMod_Items_Dynamic_IDs,

        MyMod_Items_Dynamic_Titles,
        MyMod_Items_Dynamic_Row,
        MyMod_Items_Dynamic_Rows,
        MyMod_Items_Dynamic_Sums,
        
        
        MyMod_Items_Dynamic_Destinations,
        
        MyMod_Items_Dynamic_Table,
        MyMod_Items_Dynamic_Plural,
        MyMod_Items_Dynamic_Load,
        MyMod_Items_Dynamic_UnLoad,
        MyMod_Items_Dynamic_Html,
        MyMod_Items_Dynamic_Paging,
        MyMod_Items_Dynamic_Form;
    
    //*
    //* Creates table with $items
    //*

    function MyMod_Items_Dynamic($edit,$items,$group="",$extrarows=array(),$options=array(),$notitle=True)
    {
        $this->Singular=False;

        return
            array
            (
                $this->MyMod_Items_Dynamic_Html
                (
                    $edit,$items,$group,$extrarows,$options,
                    $notitle
                )
            );
    }
    
    //*
    //* Creates table with $items
    //*

    function MyMod_Items_Dynamic_IDs($edit,$ids,$group,$extrarows=array(),$options=array())
    {
        if (empty($ids))
        {
            return "No Items";
        }
        
        $this->CurrentDataGroup=$group;
        $this->ItemHashes=
            $this->Sql_Select_Hashes
            (
                array
                (
                    "ID" => $ids
                ),
                $this->MyMod_Handle_Search_Items_Read_Datas
                (
                    $this->MyMod_Data_Group_Datas_Get($group)
                ),
                $this->MyMod_Items_Read_OrderBy()
            );
        
        return
            $this->MyMod_Items_Dynamic
            (
                $edit,
                $this->ItemHashes,
                $group,
                $extrarows,
                $options
            );
    }
}

?>