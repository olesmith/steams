<?php


trait MyMod_Search_Field_Sql
{
    //*
    //* function MyMod_Search_Field_Sql, Parameter list: $data,$rdata,$rval
    //*
    //* Creates enum type search field.
    //*

    function MyMod_Search_Field_Sql($data,$rdata,$rval)
    {
        return $this->MyMod_Data_Fields_Sql_Search_Select($data,$rdata,$rval);
    }
}

?>