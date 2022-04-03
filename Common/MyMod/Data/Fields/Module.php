<?php

include_once("Module/Filter.php");
include_once("Module/Datas.php");
include_once("Module/SqlWhere.php");
include_once("Module/SubItems.php");
include_once("Module/Show.php");
include_once("Module/Select.php");
include_once("Module/Options.php");

trait MyMod_Data_Fields_Module
{
    use
        MyMod_Data_Fields_Module_Filter,
        MyMod_Data_Fields_Module_Datas,
        MyMod_Data_Fields_Module_SqlWhere,
        MyMod_Data_Fields_Module_SubItems,
        MyMod_Data_Fields_Module_Show,
        MyMod_Data_Fields_Module_Select,
        MyMod_Data_Fields_Module_Options;



    
    //*
    //* function MyMod_Data_Module_Name, Parameter list: $data
    //*
    //* Returns name of submodule $data.
    //*

    function MyMod_Data_Fields_Module_Name($data)
    {
        return
            $this->ApplicationObj()->MyApp_Module_GetObject
            (
                $this->MyMod_Data_Field_Is_Module($data)
            )->ModuleName;
    }


    //*
    //* function MyMod_Data_Module_2Object, Parameter list: $data
    //*
    //* Returns slq object to apply - or null.
    //*

    function MyMod_Data_Fields_Module_2Object($data)
    {
        return
            $this->ApplicationObj()->MyApp_Module_GetObject
            (
                $this->MyMod_Data_Field_Is_Module($data)
            );
    }

    //*
    //* function MyMod_Data_Fields_Module_Edit, Parameter list: $data,$item,$value="",$tabindex="",$plural=FALSE,$links=TRUE,$callmethod=TRUE,$rdata=""
    //*
    //* Creates sql object select field.
    //*

    function MyMod_Data_Fields_Module_Edit($data,$item,$value="",$tabindex="",$plural=FALSE,$options=array(),$rdata="")
    {
        $options[ "ID"]=
            join
            (
                "_",
                $this->MyMod_Data_Field_Enum_Classes($data,$item)
            );
        
        return
            $this->MyMod_Data_Fields_Module_Select
            (
                $data,$item,"",0,$rdata,"",FALSE
            );
    }

    


}

?>
