<?php


trait MyMod_Search_Field_Time_Row
{
    //*
    //* Creates time type search field.
    //*

    function MyMod_Search_Field_Time_Field_Row($cgi,$field,$data,$rdata,$rval)
    {
        return
            array_merge
            (
                $this->MyMod_Search_Field_Time_Field_Row_Leading
                (
                    $cgi,$field,$data,$rdata,$rval
                ),
                $this->MyMod_Search_Field_Time_Components_Row
                (
                    $cgi,$field,$data,$rdata,$rval
                )
            );
    }

    
    //*
    //* Leading part of row.
    //*

    function MyMod_Search_Field_Time_Field_Row_Leading($cgi,$field,$data,$rdata,$rval)
    {
        return
            array
            (
                $this->MyLanguage_GetMessage("Search_Date_".$field).":",
                $this->MyMod_Search_Field_Time_Field
                (
                    $cgi,$field,$data,$rdata,$rval
                ),
            );
    }
}

?>