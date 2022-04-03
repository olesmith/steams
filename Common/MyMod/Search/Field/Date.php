<?php


trait MyMod_Search_Field_Date
{
    //*
    //* Creates date type search field.
    //*

    function MyMod_Search_Field_Date($data,$rdata,$rval)
    {
        return $this->HtmlDateInputField
        (
           $rdata,
           $rval
        );
    }
}

?>