<?php


trait MyMod_Search_Field_Text
{
    //*
    //* function MyMod_Search_Field_Text, Parameter list: $data,$rdata,$rval
    //*
    //* Creates time type search field.
    //*

    function MyMod_Search_Field_Text($data,$rdata,$rval)
    {
        return
            $this->MakeInput
            (
                $this->MyMod_Search_CGI_Text_Name($data),
                $this->MyMod_Search_CGI_Text_Value($data),
                $this->ItemData[ $data ][ "SqlTextSearch" ],
                array
                (
                    "TITLE" => "Digite uma parte de ".$this->ItemData[ $data ][ "Name" ],
                )
            );
    }
}

?>