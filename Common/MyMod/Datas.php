<?php


trait MyMod_Datas
{
    //*
    //* function MyMod_Data_Get, Parameter list: $item,$data,$key=""
    //*
    //* 
    //*

    function MyMod_Data_Get($item,$data,$key="")
    {
        return $this->ApplicationObj()->MyApp_Module_Data_Get($this->ModuleName,$item,$data,$key);
    }
    
    //*
    //* function MyMod_Data_Set, Parameter list: $item,$data,$key=""
    //*
    //* 
    //*

    function MyMod_Data_Set($item,$value,$data,$key="")
    {
        return $this->ApplicationObj()->MyApp_Module_Data_Set($this->ModuleName,$item,$value,$data,$key);
    }
    
}

?>