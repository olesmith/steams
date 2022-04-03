<?php


include_once("Test/Data.php");
include_once("Test/Datas.php");
include_once("Test/Cells.php");
include_once("Test/Rows.php");
include_once("Test/Status.php");
include_once("Test/Table.php");
include_once("Test/Titles.php");
include_once("Test/Html.php");

trait MyMod_Handle_Test
{
    use
        MyMod_Handle_Test_Data,
        MyMod_Handle_Test_Cells,
        MyMod_Handle_Test_Datas,
        MyMod_Handle_Test_Rows,
        MyMod_Handle_Test_Status,
        MyMod_Handle_Test_Table,
        MyMod_Handle_Test_Titles,
        MyMod_Handle_Test_Html;
    
    //*
    //*
    //*

    function MyMod_Handle_Test()
    {
        $this->ItemData();
        $this->Actions();
        
        $this->Htmls_Echo
        (
            array
            (
                $this->Htmls_H
                (
                    1,
                    "Test: ".
                    $this->ModuleName
                ),
                $this->MyMod_Handle_Test_Html()
            )
        );
                
    }   
   
    
    
    
}

?>