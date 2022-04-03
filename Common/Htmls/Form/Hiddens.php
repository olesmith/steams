<?php

trait Htmls_Form_Hiddens
{
    //*
    //* function Html_Form_Hiddens, Parameter list:
    //*
    //* Generates a HTML form hidden fields.
    //*

    function Htmls_Form_Hiddens($args)
    {
        $hiddens=array();
        if (!empty($args[ "Hiddens" ])) { $hiddens=$args[ "Hiddens" ]; }

        
        if (!empty($args[ "Save_CGI_Key" ]))
        {
            $value=1;
            if (!empty($args[ "Save_CGI_Value" ])) { $value=$args[ "Save_CGI_Value" ]; }
            $hiddens[   $args[ "Save_CGI_Key" ]   ]=$value;
        }
        
        if (!is_array($hiddens)) { $hiddens=array($hiddens => 1); }

        $rhiddens=array();
        foreach ($hiddens as $key => $value)
        {
            if (!empty($value))
            {
                if (is_array($value))
                {
                    $value=array_shift($value);
                }
                
                array_push
                (
                    $rhiddens,
                    $this->Htmls_Hidden($key,$value)
                );
            }
        }

        return $rhiddens;
    }
    
}

?>