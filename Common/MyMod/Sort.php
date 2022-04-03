<?php

include_once("Sort/Titles.php");
include_once("Sort/Items.php");
include_once("Sort/List.php");
include_once("Sort/Icons.php");

trait MyMod_Sort
{
    use
        MyMod_Sort_Titles,
        MyMod_Sort_Items,
        MyMod_Sort_List,
        MyMod_Sort_Icons;
    
    var $Sort=array("Name");
    var $Reverse=0;

    //*
    //* function MyMod_Sort_Detect, Parameter list: $group=""
    //*
    //* Consider $group in detecting $sort value to use.
    //*

    function MyMod_Sort_Detect($group="")
    {
        $sort="";
        $reverse=$this->Reverse;

        if ($this->CGI_VarValue($this->ModuleName."_Sort")!="")
        {
            $sort=$this->CGI_VarValue($this->ModuleName."_Sort");
            $reverse=$this->CGI_VarValue($this->ModuleName."_Reverse");
        }
        
        if (!empty($group))
        {
            if (!empty($this->ItemDataGroups[ $group ][ "Sort" ]))
            {
                $sort=$this->ItemDataGroups[ $group ][ "Sort" ];
                $reverse=$this->ItemDataGroups[ $group ][ "Reverse" ];
            }
        }
        
        $sorts=array();

        //Avoid double sorts
        $rsorts=array();
        for ($n=0;$n<$this->MyMod_Search_Options_Sort_N;$n++)
        {
            $sort=$this->MyMod_Search_Options_Sort_CGI_Value($n);
            if (!empty($sort) && empty($rsorts[ $sort ]))
            {
                array_push($sorts,$sort);
                $rsorts[ $sort ]=True;
            }
        }

        $this->Sorts=$sorts;
        $this->Reverse=$reverse;

        return array($sort,$reverse);
    }

    //*
    //* function MyMod_Sort_Vars2Data, Parameter list: $datas=array()
    //*
    //* Returns effective search vars data list, adding to $datas.
    //* Uses $this->Sort, as string or list.
    //*

    function MyMod_Sort_Vars2Data($datas=array())
    {
        if (!is_array($this->Sort))
        {
            $this->Sort=array($this->Sort,"ID");
        }

        foreach ($this->Sort as $data)
        {
            if (!preg_grep('/^'.$data.'$/',$datas))
            {
                array_push($datas,$data);
            }
        }

        return $datas;
    }
        
    //*
    //*
    //* function MyMod_Sort_Get, Parameter list: $sort=""
    //*
    //* Looks at $sort and cgivalue of Module sort var,
    //* returns first defined value - should be and array!
    //*

    function MyMod_Sort_Get($sort="")
    {
        $this->MyMod_Sort_Detect();
        $sorts=$this->Sorts;
        if (empty($sorts)) { $sorts=$this->Sort; }

        return $sorts;
    }
    
    //*
    //*
    //* function MyMod_Sort_Reverse_Get, Parameter list: $sort=""
    //*
    //* As GetSort, but reads cgivalue of module Reverse.
    //*

    function MyMod_Sort_Reverse_Get($reverse="")
    {
        return $this->MyMod_Search_Options_Reversed_CGI_Value();
    }
}

?>