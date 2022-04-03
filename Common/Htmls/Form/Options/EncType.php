<?php

trait Htmls_Form_Options_EncType
{
    //*
    //* function Htmls_Form_Options_EncType, Parameter list:
    //*
    //* Detects whether we have file uploads or not.
    //*

    function Htmls_Form_Options_EncType($args)
    {
        ##Always turn on file upload... hehehe.
        return "multipart/form-data";
    }
}

?>