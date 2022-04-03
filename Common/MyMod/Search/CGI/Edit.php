<?php


trait MyMod_Search_CGI_Edit
{
    //*
    //* Name of go edit items cgi field.
    //*

    function MyMod_Search_CGI_Edit_Key()
    {
        return $this->ModuleName."_".$this->MyMod_Search_Options_Edit_Key;
        
    }
    
    //*
    //* Name of go edit items cgi field.
    //*

    function MyMod_Search_CGI_Edit_Value()
    {
        $val=$this->CGI_GETOrPOSTint($this->MyMod_Search_CGI_Edit_Key());

        return $val;        
    }
}

?>