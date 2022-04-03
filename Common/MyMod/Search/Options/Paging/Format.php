<?php


trait MyMod_Search_Options_Paging_Format
{
    //*
    //* 
    //*

    function MyMod_Search_Options_Format_N_Of_M($format,$n,$m,$msg=NULL)
    {
        if ($msg==NULL)
        {
            $msg=
                " ".
                $this->MyLanguage_GetMessage("Of").
                " ";
        }

        return
            sprintf($format,$n).$msg.sprintf($format,$m);
        
    }
    //*
    //* Number formatter.
    //*

    function MyMod_Search_Options_Paging_Format($n)
    {
        if ($n==0) { return "%d"; }
        
        return  "%0".(   intval(   log( abs($n) ,10)   )+1   )."d";
    }
}

?>