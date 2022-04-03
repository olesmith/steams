<?php

trait Htmls_Form_Options_ID
{
    //*
    //* Detects form method option from args. Default is post.
    //*

    function Htmls_Form_Options_ID($id,$action,$args,$item,$options=array())
    {
        if (empty($id)) { $id=$this->ModuleName."_".$action."_Form"; }
        
        if (!empty($item[ "ID" ])) { $id=$id."_".$item[ "ID" ]; }

        return $id;            
    }
    
}

?>