<?php

include_once("Field/Date.php");
include_once("Field/Time.php");
include_once("Field/Default.php");
include_once("Field/Enum.php");
include_once("Field/Method.php");
include_once("Field/Sql.php");
include_once("Field/Text.php");
include_once("Field/File.php");

trait MyMod_Search_Field
{
    use
        MyMod_Search_Field_Date,
        MyMod_Search_Field_Time,
        MyMod_Search_Field_Default,
        MyMod_Search_Field_Enum,
        MyMod_Search_Field_Method,
        MyMod_Search_Field_Sql,
        MyMod_Search_Field_Text,
        MyMod_Search_Field_File;
    //*
    //* function MyMod_Search_Field_Make, Parameter list: $data,$fixedvalues,$rval=""
    //*
    //* Creates search var input field.
    //*

    function MyMod_Search_Field_Make($data,$fixedvalues,$rval="")
    {
        return
            $this->MyMod_Search_Field_Value($data,$fixedvalues,$rval);
    }

    //*
    //* function MyMod_Search_Field_Value, Parameter list: $data,$fixedvalues,$rval=""
    //*
    //* Creates search var input value.
    //*

    function MyMod_Search_Field_Value($data,$fixedvalues,$rval="")
    {
        $fixedvalue="";
        if (!empty($fixedvalues[ $data ]))
        {
            $fixedvalue=$fixedvalues[ $data ];
        }
                
        $rdata=$this->MyMod_Search_CGI_Name($data);
        if (empty($rval)) { $rval=$this->MyMod_Search_CGI_Value($data); }

        if (!empty($rval) && !is_array($rval))
        {
            $rval=html_entity_decode($rval,ENT_COMPAT,'UTF-8');
        }

        if (empty($rval) && !empty($this->ItemData[ $data ][ "SearchDefault" ]))
        {
            $rval=$this->ItemData[ $data ][ "SearchDefault" ];
        }

        if ($this->LoginType!="Public")
        {
            $rval=preg_replace('/#Login/',$this->LoginData[ "ID" ],$rval);
        }

        $value="";
        if ($this->ItemData[ $data ][ "SearchFieldMethod" ])
        {
            $value=$this->MyMod_Search_Field_Method_Call($data,$fixedvalue,$rval);
        }
        elseif ($this->MyMod_Data_Field_Is_Date($data))
        {
            $value=$this->MyMod_Search_Field_Date($data,$rdata,"");
        }
        elseif ($this->MyMod_Data_Field_Is_Time($data))
        {
            $value=$this->MyMod_Search_Field_Time($data,$rdata,$rval);
        }
        elseif ($this->MyMod_Data_Field_Is_Enum($data))
        {
            $value=$this->MyMod_Search_Field_Enum($data,$rdata,$rval);
        }
        elseif ($this->MyMod_Data_Field_Is_Sql($data))
        {
            $value=$this->MyMod_Search_Field_Sql($data,$rdata,$rval);
        }
        elseif ($this->MyMod_Data_Field_Is_File($data))
        {
            $value=$this->MyMod_Search_Field_File($data,$rdata,$rval);
        }
        else
        {
            $value=$this->MyMod_Search_Field_Default($data,$rdata,$rval);
        }


        return $value;
    }
    
    //*
    //* function MyMod_Search_Field_Title, Parameter list: $data
    //*
    //* Creates search var row title cell.
    //*

    function MyMod_Search_Field_Title($data)
    {
        $name=$this->LanguagesObj()->Language_Data_Name_Get($this,$data."_Search");

        if (preg_match('/^undef:/',$name))
        {
            $name=$this->LanguagesObj()->Language_Data_Name_Get($this,$data);
        }

        return $name;
    }
    
    
    
    
    //*
    //* function MyMod_Search_Field_Date, Parameter list: $data,$rdata,$rval
    //*
    //* Creates date type search field.
    //*

    function MyMod_Search_Field_Date($data,$rdata,$rval)
    {
        return $this->HtmlDateInputField
        (
           $rdata,
           $rval
        );
    }

    
    
}

?>