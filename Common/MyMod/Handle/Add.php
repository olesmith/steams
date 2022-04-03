<?php

include_once("Add/Datas.php");
include_once("Add/Read.php");
include_once("Add/Table.php");
include_once("Add/Html.php");
include_once("Add/Update.php");
include_once("Add/Form.php");
include_once("Add/Redirect.php");
include_once("Add/Do.php");


trait MyMod_Handle_Add
{
    var $MyMod_Handle_Message="";


    use
        MyMod_Handle_Add_Datas,
        MyMod_Handle_Add_Read,
        MyMod_Handle_Add_Table,
        MyMod_Handle_Add_Html,
        MyMod_Handle_Add_Update,
        MyMod_Handle_Add_Form,
        MyMod_Handle_Add_Redirect,
        MyMod_Handle_Add_Do;
    
    //*
    //* function MyMod_Handle_Add, Parameter list: 
    //*
    //* 
    //*

    function MyMod_Handle_Add($echo=TRUE)
    {
        return
            $this->MyMod_Handle_Add_Form
            (
                "",
                "",
                $echo
            );
    }

    
}

?>