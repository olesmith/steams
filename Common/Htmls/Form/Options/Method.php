<?php

trait Htmls_Form_Options_Method
{
    //*
    //* Detects form method option from args. Default is post.
    //*

    function Htmls_Form_Options_Method($args)
    {
        $method="post";
        if (!empty($args[ "Method" ])) { $method=$args[ "Method" ]; }

        return $method;            
    }    
}

?>