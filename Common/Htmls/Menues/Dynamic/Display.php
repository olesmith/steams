<?php


trait Htmls_Menues_Dynamic_Display
{
    //*
    //* 
    //*

    function Htmls_Menues_Dynamic_Display($key)
    {
        $display=$this->Htmls_Menues_Dynamic_Entry_Key($key,"Display");
        if (empty($display))
        {
            $display="inline";
        }
        
        return $display;
    }
}
?>