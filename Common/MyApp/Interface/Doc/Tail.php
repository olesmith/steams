<?php


trait MyApp_Interface_Doc_Tail
{
    //*=
    //* Returns nothing, in between Middle and Final rows (TR).
    //* Supposed to be overwritten, printing something more.
    //*
    //*

    function MyApp_Interface_Post_Row()
    {
        return "";
    }
    
    //*
    //* Sends the HTML doc tail.
    //*
    //*

    function MyApp_Interface_Doc_Tail()
    {
        return "";
    }
    
}

?>