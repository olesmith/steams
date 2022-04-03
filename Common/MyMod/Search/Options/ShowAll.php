<?php


trait MyMod_Search_Options_ShowAll
{
    //*
    //* function MyMod_Search_Options_Show_All_Cells, Parameter list: $omitvars
    //*
    //* 
    //*

    function MyMod_Search_Options_Show_All_Cells($omitvars)
    {
        if (!$this->MyMod_Search_Option_Should("ShowAll$",$omitvars))
        {
            return array();
        }
        
        return
            array
            (
                $this->Htmls_DIV
                (
                    $this->MyLanguage_GetMessage
                    (
                        "ShowAll"
                    ).":",
                    array("CLASS" => 'searchtitle')
                ),
                $this->MyMod_Search_CGI_Include_All_Radio_Field()
            );
    }
}

?>