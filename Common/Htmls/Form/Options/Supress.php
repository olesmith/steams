<?php

trait Htmls_Form_Options_Supress
{    //*
    //* Detects cgi vars to suppress on action link.
    //*

    function Htmls_Form_Suppress_CGI($args)
    {
        $suppresscgis=array();
        if (!empty($args[ "Suppress" ])) { $suppresscgis=$args[ "Suppress" ]; }

        return $suppresscgis;
    }
}

?>