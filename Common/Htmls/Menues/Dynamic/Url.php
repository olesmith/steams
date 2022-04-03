<?php


trait Htmls_Menues_Dynamic_Url
{
    //*
    //* 
    //*

    function Htmls_Menues_Dynamic_URL($key)
    {
        return
            "?".
            $this->CGI_URI2Hash
            (
                $this->MyMod_CGI_RAW
                (
                    $this->Htmls_Menues_Dynamic_Entry_Value($key,"URL")
                )
            );
    }
    
}
?>