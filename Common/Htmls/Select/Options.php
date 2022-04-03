<?php

trait Htmls_Select_Options
{
    //*
    //* Generates options list.
    //*

    function Htmls_Select_Options_Fields($values,$valuenames,$titles,$selected,$args,$optoptions=array())
    {
        $maxlen=$this->Htmls_Select_Args_MaxLen($args);
        $excludedisableds=$this->Htmls_Select_Args_ExcludeDisableds($args);
        
        $disableds=$this->Htmls_Select_Args_Disableds($args);

        $options=$this->Htmls_Select_Options_Empty($args);
        foreach ($values as $n => $value)
        {
            array_push
            (
                $options,
                $this->Htmls_Select_Options_Field
                (
                    $n,$value,
                    $values,$valuenames,$titles,
                    $disableds,
                    $selected,
                    $args,
                    $optoptions
                )
            );
        }

        return $options;
    }
    
    
    //*
    //* Generates empty part (first field) of options fields.
    //*

    function Htmls_Select_Options_Empty($args)
    {
        $options=array();
        if ($this->Htmls_Select_Args_Empty($args))
        {
            array_push
            (
                $options,
                $this->Htmls_Tag
                (
                    "OPTION",
                    "",
                    array("VALUE" => 0)
                )
            );
        }

        return $options;
    }
}


?>