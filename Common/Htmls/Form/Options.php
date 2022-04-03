<?php

include_once("Options/ID.php");
include_once("Options/Method.php");
include_once("Options/EncType.php");
include_once("Options/Supress.php");
include_once("Options/OnSubmit.php");

trait Htmls_Form_Options
{
    use
        Htmls_Form_Options_ID,
        Htmls_Form_Options_Method,
        Htmls_Form_Options_EncType,
        Htmls_Form_Options_Supress,
        Htmls_Form_Options_OnSubmit;
    
    //*
    //* Generates a HTML form options array.
    //*

    function Htmls_Form_Options($id,$action="",$args=array(),$options=array())
    {
        $item=$this->ItemHash;

        $options=
            array_merge
            (
                $options,
                array
                (
                    "ID"      => $this->Htmls_Form_Options_ID
                    (
                        $id,$action,$args,$item,$options
                    ),
                    "ACTION"  => $this->Htmls_Form_Action
                    (
                        $id,$action,$args,$item,$options
                    ),
                    "METHOD"  => $this->Htmls_Form_Options_Method($args),
                    "ENCTYPE" => $this->Htmls_Form_Options_EncType($args),

                    "CLASS"   => "form",
                    "WIDTH"   => "100%",
                ),
                $this->Htmls_Form_Options_OnSubmit($id,$args,$action,$item)
            );
        
        return $options;
    }
}

?>