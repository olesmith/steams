<?php

trait Htmls_Script
{
    //*
    //*
    //*

    function Htmls_SCRIPT($js,$options=array(),$style=array())
    {
        if (empty($js)) { return array($js); }
        
        if (!is_array($js)) { $js=array($js); }
        
        //if (!preg_grep('/\S/',$js)) { return array(); }
        
        if (empty($options))
        {
            $options=$this->SCRIPT_Options;
        }
        
        return
            array
            (
                $this->Htmls_Tag
                (
                    "SCRIPT",
                    $this->Htmls_Text
                    (
                        array($js)
                    ),
                    $options,
                    $style
                )
            );
    }
}
?>