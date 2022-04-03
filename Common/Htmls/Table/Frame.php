<?php

trait Htmls_Table_Frame
{
      //*
    //* function Htmls_Frame, Parameter list: $titles,$rows,$options=array()
    //*
    //* Generates a HTML table.
    //*

    function Htmls_Frame($contents,$options=array(),$troptions=array(),$tdoptions=array())
    {
        if (empty($options[ "CLASS" ]))
        {
            $options[ "CLASS" ]='card';
        }
        
        if (empty($options[ "ALIGN" ]))
        {
            $options[ "ALIGN" ]='center';
        }

        return
            $this->Htmls_DIV
            (
                array
                (
                    #Joined!
                    $this->Html_Tag_Start("TABLE",$options).
                    $this->Html_Tag_Start("TR",$troptions).
                    $this->Html_Tag_Start("TD",$tdoptions),
                        
                    $contents,
                        
                    #Joined!
                    $this->Html_Tag_Close("TD").
                    $this->Html_Tag_Close("TR").
                    $this->Html_Tag_Close("TABLE"),
                )
            );
    }
}

?>