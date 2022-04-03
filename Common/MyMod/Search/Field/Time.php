<?php

include_once("Time/CGI.php");
include_once("Time/Component.php");
include_once("Time/Components.php");
include_once("Time/Fields.php");
include_once("Time/Row.php");
include_once("Time/Titles.php");
include_once("Time/Table.php");

trait MyMod_Search_Field_Time
{
    use
        MyMod_Search_Field_Time_CGI,
        MyMod_Search_Field_Time_Component,
        MyMod_Search_Field_Time_Components,
        MyMod_Search_Field_Time_Fields,
        MyMod_Search_Field_Time_Titles,
        MyMod_Search_Field_Time_Row,
        MyMod_Search_Field_Time_Table;
     
    //*
    //* Time field search field generator: called by search table generator.
    //*

    function MyMod_Search_Field_Time($data,$rdata,$rval)
    {
        return
            $this->Htmls_Table
            (
                $this->MyMod_Search_Field_Time_Titles(),
                $this->MyMod_Search_Field_Time_Table
                (
                    $data,$rdata,$rval
                ),
                $options=array()
            );
    }
    
}

?>