<?php


trait MyMod_Search_Field_File
{
    //*
    //* function MyMod_Search_Field_File, Parameter list: $data,$rdata,$rval
    //*
    //* Creates enum file search field: has uploaded file or not.
    //*

    function MyMod_Search_Field_File($data,$rdata,$rval)
    {
        $value=
            $this->Htmls_CheckBox
            (
                $rdata,
                1,
                $rval
            );
        
        return $value;
   }
}

?>