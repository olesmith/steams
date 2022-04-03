<?php

trait Htmls_Checkbox
{
    //*
    //* sub Htmls_CheckBox, Parameter list: $name,$value=FALSE,$checked=FALSE,$disabled=FALSE,$options=array()
    //*
    //* Create CheckBox of name $name. The box is checked if argument
    //* $checked is defined.
    //*
    //*

    function Htmls_CheckBox($name,$value=1,$checked=FALSE,$disabled=FALSE,$options=array())
    {
        $options[ "TYPE" ]="checkbox";
        $options[ "NAME" ]=$name;

        if ($value) { $options[ "VALUE" ]=$value; }
        if ($checked) { $options[ "CHECKED" ]=""; }
        if ($disabled) { $options[ "DISABLED" ]=""; }
    
        return
            $this->Html_Tag
            (
                "INPUT",
                $options
            )."\n";
    }

    
}


?>