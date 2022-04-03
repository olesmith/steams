<?php


trait MyMod_Handle_Test_Titles
{
    //*
    //*
    //*

    function MyMod_Handle_Test_Titles()
    {
        return
            array_merge
            (
                array("No"),
                $this->MyMod_Data_Titles
                (
                
                    $this->MyMod_Handle_Test_Datas_Show()
                ),
                array("Status")
            );
    }
}

?>