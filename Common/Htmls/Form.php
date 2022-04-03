<?php

include_once("Form/Buttons.php");
include_once("Form/Hiddens.php");
include_once("Form/Start.php");
include_once("Form/End.php");
include_once("Form/Options.php");
include_once("Form/Args.php");
include_once("Form/Action.php");

trait Htmls_Form
{
    use
        Htmls_Form_Buttons,
        Htmls_Form_Hiddens,
        Htmls_Form_Start,
        Htmls_Form_End,
        Htmls_Form_Options,
        Htmls_Form_Args,
        Htmls_Form_Action;
    //*
    //* function Htmls_Form, Parameter list:
    //*
    //* Generates a HTML form as listed html.
    //*

    function Htmls_Form($edit,$id,$action="",$contents=array(),$args=array(),$options=array())
    {
        if (!empty($args[ "Pre" ]))
        {
            $contents=
                array_merge
                (
                    $args[ "Pre" ],
                    $contents
                );
        }
        
        if ($edit==1)
        {
            $contents=
                $this->Htmls_Form_Start
                (
                    $id,
                    $action,
                    $contents,
                    $args,
                    $options
                );

            array_push
            (
                $contents,
                array
                (
                    $this->Htmls_Form_Hiddens($args),
                    array
                    (
                        $this->Htmls_Form_Buttons($edit,$args)
                    ),
                ),
                $this->Htmls_Form_End()
            );
            
        }
         
        if (!empty($args[ "Post" ]))
        {
            $contents=
                array_merge
                (
                    $contents,
                    $args[ "Post" ]
                );
        }
        
        if ($edit==1)
        {
            $frame_id=
                $this->Htmls_Form_Options_ID
                (
                    $id,$action,$args,$this->ItemHash,$options
                ).
                "_Frame";
            
            $contents=
                $this->Htmls_Frame
                (
                    $contents,
                    $frameargs=
                    array
                    (
                        "ID" => $frame_id,
                        "WIDTH" => '100%',
                        "ONMOUSEOVER" =>
                        $this->JS_Function_Call_As_String
                        (
                            "Highlight_Element_By_ID",
                            array($frame_id,'#EEEEEE')
                        ),

                    
                        "ONMOUSEOUT" =>
                        $this->JS_Function_Call_As_String
                        (
                            "Highlight_Element_By_ID",
                            array($frame_id)
                        ),

                    )
                );
        }
        else
        {
            $contents=
                $this->Htmls_Div
                (
                    $contents,
                    array
                    (
                        "ID" => $id,
                    )
                );
        }

        return $contents;    
    }
}

?>