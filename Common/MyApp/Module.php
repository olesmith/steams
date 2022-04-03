<?php

include_once("Module/Load.php");
include_once("Module/Access.php");
include_once("Module/Datas.php");
include_once("Module/Groups.php");

trait MyApp_Module
{
    use 
        MyApp_Module_Load,
        MyApp_Module_Access,
        MyApp_Module_Datas,
        MyApp_Module_Groups;

    //*
    //* function MyApp_Module_Init, Parameter list: $args=array(),$initdbtable=TRUE
    //*
    //* Calls module's handler.
    //*

    function MyApp_Module_Init($args=array(),$initdbtable=TRUE)
    {
        if (!$this->Module)
        {
            if (empty($this->ModuleFile)) { $this->ModuleFile=$this->ModuleName; }

            if (!preg_grep('/^'.$this->ModuleName.'$/',$this->AllowedModules))
            {
                $this->DoDie("Module access not permitted",$this->ModuleName);
            }

            $this->LoadMTime=time();
            if (file_exists($this->MyMod_Setup_Item_Data_File($this->ModuleName)))
            {
               $this->MyMod_SubModules_Load();
            }
        }

        if (method_exists($this->Module,"PostInit"))
        {
            $this->Module->PostInit();
        }

        $this->PostInit();
        ###$this->ModuleName=$this->Module->ModuleName;
    }

  
    //*
    //* Calls module's handler.
    //*

    function MyApp_Module_GetObject($module)
    {
        if (empty($this->SubModulesVars[ $module ]))
        {
            $this->ApplicationObj()->LogMessage
            (
                "MyApp_Module_GetObject",
                $module." not in SubModulesVars: "
            );
        }
        $accessor=$this->SubModulesVars[ $module ][ "SqlClass" ]."Obj";
        return $this->$accessor();
    }
    
    //*
    //* Calls module's handler.
    //*

    function MyApp_Module_Derived_Data($module)
    {
        return
            array_merge
            (
                array("ID",),
                $this->ApplicationObj()->SubModulesVars[ $module ][ "SqlDerivedData" ]
            );
    }
    
    //*
    //* Calls module's handler.
    //*

    function MyApp_Module_Derived_Data_Filter($module)
    {
        return
            $this->ApplicationObj()->SubModulesVars[ $module ][ "SqlFilter" ];
    }
    
    //*
    //* Returns list of application modules.
    //*

    function MyApp_Modules_Get()
    {
        return array_keys($this->SubModulesVars);
    }
    
    //*
    //* Generates a select field selecting module.
    //*

    function MyApp_Module_Select($module,$name="Module")
    {
        $modules=$this->MyApp_Modules_Get();
        sort($modules);
        
        return
            $this->Htmls_Form
            (
                1,
                "Module",$action="",
                //$contents=
                array
                (
                    $this->Htmls_Select
                    (
                        $name,
                        $modules,
                        $modules,
                        $this->CGI_GET("ModuleName"),
                        $args=array(),$htmloptions=array()
                    ),
                    $this->Html_Input_Button_Make("submit","GO")
                ),
                //$args=
                array
                (
                    "CGI_Args"  => array
                    (
                        "Dest" => "Module_Info_Field",
                    ),
                    "Dest" => $this->ModuleName."_Info_Field",
                )
            );
    }
}

?>