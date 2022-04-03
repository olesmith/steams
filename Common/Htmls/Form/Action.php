<?php

trait Htmls_Form_Action
{
    //*
    //* function Htmls_Form_Action, Parameter list:
    //*
    //* Detects form action option from args.
    //*

    function Htmls_Form_Action($id,$action,$args,$item,$options=array())
    {
        if (preg_match('/(.*)\?(.*)/',$action,$matches))
        {
            $action=$matches[2];
        }

        return
            "?".
            $this->CGI_Hash2Query
            (
                $this->Htmls_Form_Args($action,$args)
            ).
            "#".
            $this->Htmls_Form_Action_Anchor($id,$action,$args,$item,$options);
    }
    
    //*
    //* function Htmls_Form_Action_Anchor, Parameter list:
    //*
    //* Detects form action option from args.
    //*

    function Htmls_Form_Action_Anchor($id,$action,$args,$item,$options=array())
    {
        return $this->Htmls_Form_Options_ID($id,$action,$args,$item,$options);
        
        if (!empty($args[ "Anchor" ]))
        {
            $anchor=$args[ "Anchor" ];
        }
        
        return preg_replace('/#/',"",$anchor);
    }
}

?>