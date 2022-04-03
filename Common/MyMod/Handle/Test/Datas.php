<?php


trait MyMod_Handle_Test_Datas
{
    //*
    //*
    //*

    function MyMod_Handle_Test_Datas()
    {
        return $this->MyMod_Data_Fields_Is_Module();
    }
    
    //*
    //*
    //*

    function MyMod_Handle_Test_Datas_Read()
    {
        return
            array_merge
            (
                array("ID"),
                $this->MyMod_Handle_Test_Datas()
            );
    }
    //*
    //*
    //*

    function MyMod_Handle_Test_Datas_Show()
    {
        return
            array_merge
            (
                array("Show","Edit","ID",),
                $this->MyMod_Handle_Test_Datas()
            );
    }
}

?>