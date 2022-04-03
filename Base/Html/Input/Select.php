<?php


class HtmlSelect extends HtmlRadioButton
{


    //*
    //* sub GetSelectNumbers, Parameter list: $list
    //*
    //* For elements in $list, create the slect numbers< 1,..,nelements in $list.
    //*

    function GetSelectNumbers(&$list)
    {
        $names=array();
        $numbers=array();
        if ($list[0]!="")
        {
            array_unshift($names,"");
            array_unshift($numbers,0);
        }
        else
        {
            array_shift($list);
        }

        $n=1;
        foreach ($list as $id => $val)
        {
            array_push($names,$val);
            array_push($numbers,$n);
            $n++;
        }

        $list=$names;

        return $numbers;
    }

    //*
    //* sub MakeSelectField, Parameter list: $name,$values,$valuenames,$selected="",
    //*                                       $disableds=array(),$titles=array(),$title="",
    //*                                       $maxlen=0,$noincludedisableds=FALSE,$multiple=FALSE,
    //*                                       $onchange=NULL,$options=array()
    //*
    //* Creates SELECT input element.
    //*
    //*

    function MakeSelectField($name,$values,$valuenames,$selected="",$disableds=array(),$titles=array(),$title="",$maxlen=0,$noincludedisableds=FALSE,$multiple=FALSE,$onchange=NULL,$options=array())
    {
        return
            $this->Htmls_Select
            (
                $name,$values,$valuenames,$selected,
                array
                (
                    "Disableds" => $disableds,
                    "Titles" => $titles,
                    "Title" => $title,
                    "MaxLen" => $maxlen,
                    "ExcludeDisableds" => $noincludedisableds,
                    "Multiple" => $multiple,
                    "OnChange" => $onchange,
                ),
                $options
            );
    
    }

}


?>