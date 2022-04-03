<?php


trait MyMod_Handle_Import_Titles
{
    //*
    //* Generates import items table title row.
    //*

    function MyMod_Handle_Import_Titles()
    {
        return
            array_merge
            (
                array("No."),
                $this->MyMod_Data_Titles
                (
                    $this->Import_Datas
                ),
                array
                (
                    $this->MyLanguage_GetMessage("Status"),
                    $this->MyMod_Handle_Import_Items_Add_Cell(),
                )
            );
    }
}
?>