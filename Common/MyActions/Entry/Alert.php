<?php

trait MyActions_Entry_Alert
{
    //*
    //* Creates Alert'ed link: will raise confirming message, via java.
    //*
    //* Raises box with $text, $pre_$text may be a method.
    //*

    function MyActions_Entry_Alert($url,$text,$item=array())
    {
        if (empty($item)) { $item=$this->ItemHash; }
       
        if (method_exists($this,$text))
        {
            $text=$this->$text($item);
        }

        return
            "javascript:goto('".$url."','".
            $this->Html2Text($text).
            "')";
    }

}