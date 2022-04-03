<?php

trait MyMod_Module
{
    //*
    //* function MyMod_Run, Parameter list: $args
    //*
    //* Application initializer.
    //*

    function MyMod_Run($args)
    {
        $this->MyMod_TakeArgs($args);
        if ($this->Handle)
        {
            $this->MyMod_Handle();
        }
    }


    //*
    //* function MyMod_TakeVars, Parameter list: 
    //*
    //* Application initializer.
    //*

    function MyMod_TakeVars()
    {
        foreach ($this->ApplicationObj()->SubModulesVars[ $this->ModuleName ] as $key => $value)
        {
            $this->$key=$value;
        }
    }
    
    //*
    //* Returns module object associated with $data.
    //*

    function MyMod_Data_Module_Object($data)
    {
        if ($data=="ID") { return $this; }
        $method=$this->ItemData($data,"SqlClass")."Obj";
        return $this->$method();
    }
}

?>