<?php

class FieldFields extends ShowFields
{
    //*
    //* Variables of Fields class:
    //*

    //*
    //* Returns comment to add to field
    //*

    function FieldComment_remove($data,$edit=0)
    {
        if (
            !$this->NoFieldComments
            &&
            !isset($this->ItemData[ $data ][ "NoComment" ])
           )
        {
            $comment=$this->GetRealNameKey($this->ItemData[ $data ],"Comment");
            if ($comment!="")
            {
                return $comment;
            }
            
            $comment=$this->GetRealNameKey($this->ItemData[ $data ],"EditComment");
            if ($edit==1 && $comment!="")
            {
                return $comment;
            }
        }

        return "";
    }


    //*
    //* function PrependInputNameTag, Parameter list: $inputhtml,$prepend,$n=1
    //*
    //* Prepends $prepend to first occorrence of Name='...' in $inputhtml.
    //*

    function PrependInputNameTag($inputhtml,$prepend,$nmax=1)
    {
       $inputhtml=preg_replace  //Prepend $prepend to input Name=
        (
           '/NAME="/i',
           "NAME=\"".$prepend,
           $inputhtml,
           $nmax
        );

        return preg_replace  //Prepend $prepend to input Name=
        (
           '/NAME=\'/i',
           "NAME='".$prepend,
           $inputhtml,
           $nmax
        );
    }
}

?>