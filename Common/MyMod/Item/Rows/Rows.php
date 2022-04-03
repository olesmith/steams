<?php

trait MyMod_Item_Rows_Rows
{
    //*
    //* Creates row with open/close item link.
    //*

    function MyMod_Item_Rows_Rows($edit,$setup,$item)
    {
        if (!$this->MyMod_Item_Rows_Details_Should($setup,$item)) { return array(); }
        
        $rows=
            array
            (
                $this->MyMod_Item_Rows_SGroup($edit,$setup,$item),
                $this->MyMod_Item_Rows_SGroups($edit,$setup,$item),
                $this->MyMod_Item_Rows_EditForm($edit,$setup,$item),
                $this->MyMod_Item_Rows_Modules_Menu($edit,$setup,$item),
            );

        $rows=
            array_merge
            (
                $rows,
                $this->MyMod_Item_Rows_Module_Rows($edit,$setup,$item)
            );

 
        return $rows;
    }
}

?>