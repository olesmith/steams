<?php

trait Htmls_Hide_Contents
{
    //*
    //* 
    //*

    function Htmls_Hide_Content($content,$spanid,$by,$shouldhide=False)
    {
        $options=array($by => $spanid);
        if ($shouldhide)
        {
            $options[ "STYLE" ]='display: none;';
        }
        
        return
            $this->Htmls_Span
            (
                $content,
                $options
            );
    }
}


?>