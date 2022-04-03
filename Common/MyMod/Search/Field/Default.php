<?php


trait MyMod_Search_Field_Default
{
    //*
    //* function MyMod_Search_Field_Default, Parameter list: $data,$rdata,$rval
    //*
    //* Creates default $data search field.
    //*

    function MyMod_Search_Field_Default($data,$rdata,$rval)
    {
        $wdt=10;
        if ($this->ItemData[ $data ][ "Size" ])
        {
            $wdt=$this->ItemData[ $data ][ "Size" ];
        }

        return $this->MakeInput
        (
           $rdata,
           $rval,
           $wdt,
           array
           (
               "TITLE" =>
               $this->MyLanguage_GetMessage("Search_Type_Message").
               " ".
               $this->LanguagesObj()->Language_Data_Name_Get($this,$data),
           )
        );
    }
}

?>