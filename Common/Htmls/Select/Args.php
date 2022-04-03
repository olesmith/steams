<?php

trait Htmls_Select_Args
{
    //*
    //* Generates options list.
    //*

    function Htmls_Select_Args_Titles($args)
    {
        $titles=array();
        if (!empty($args[ "Titles" ])) { $titles=$args[ "Titles" ]; }

        return $titles;
    }
    

    //*
    //* Generates options list.
    //*

    function Htmls_Select_Args_Disableds($args)
    {
        $disableds=array();
        if (!empty($args[ "Disableds" ])) { $disableds=$args[ "Disableds" ]; }
        
        return $disableds;
    }
    
    
    //*
    //* Detects empty option value from $args;
    //*

    function Htmls_Select_Args_Option_Options($args,$opt_options=array())
    {
        if (!empty($args[ "Option_Options" ]))
        {
            $opt_options=array_merge($opt_options,$args[ "Option_Options" ]);
        }

        return $opt_options;
    }
    
    //*
    //* Detects empty option value from $args;
    //*

    function Htmls_Select_Args_Empty($args)
    {
        $empty=FALSE;
        if (!empty($args[ "Empty" ])) { $empty=$args[ "Empty" ]; }
        
        return $empty;
    }
    
    //*
    //* Detects empty option value from $args;
    //*

    function Htmls_Select_Args_MaxLen($args)
    {
        $maxlen=0;
        if (!empty($args[ "MaxLen" ])) { $maxlen=$args[ "MaxLen" ]; }
        
        return $maxlen;
    }
    
    //*
    //* Detects empty option value from $args;
    //*

    function Htmls_Select_Args_ExcludeDisableds($args)
    {
        $excludedisableds=FALSE;
        if (!empty($args[ "ExcludeDisableds" ]))
        {
            $excludedisableds=$args[ "ExcludeDisableds" ];
        }
        
        return $excludedisableds;
    }
}


?>