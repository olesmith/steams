<?php

include_once("Countries/Access.php");

class Countries extends ModulesCommon
{
    use
        Countries_Access;
    

    //*
    //* function Countries, Parameter list: $args=array()
    //*
    //* Constructor.
    //*

    function Countries($args=array())
    {
        $this->Hash2Object($args);

        $language="_".$this->MyLanguage_Get();
        
        $this->AlwaysReadData=
            array
            (
                "Name".$language,
                "Title".$language,
                "Continent"
            );

        $this->ItemNamer="Name".$language;
        
        $this->Sort=array("Name".$language);
        $this->IDGETVar="Country";
    }

    //*
    //* Overrides SqlTableName, prepending period id.
    //* Calls ApplicationObj->SqlPeriodTableName.
    //*

    function SqlTableName($table="")
    {
        if (empty($table)) { $table="Countries"; }
        
        return $table;
    }

    
    //*
    //* Post process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PostProcessItemData()
    {
        $language="_".$this->MyLanguage_Get();
        $this->ItemData[ "Name".$language ][ "Add" ]=True;
        $this->ItemData[ "Title".$language ][ "Add" ]=True;
       $this->ItemData[ "Name".$language ][ "Search" ]=True;
        $this->ItemData[ "Title".$language ][ "Search" ]=True;
        
        //parent::PostProcessItemData();
    }

    //*
    //* Runs right after module has finished initializing.
    //*

    use cURL;
    
    function PostInit()
    {
        //parent::PostInit();
    }

    //*
    //* function PostProcess, Parameter list: $item
    //*
    //* Postprocesses and returns $item.
    //*

    function PostProcess($item)
    {
        $module=$this->GetGET("ModuleName");
        if ($module!=$this->ModuleName)
        {
            return $item;
        }

        if (!isset($item[ "ID" ]) || $item[ "ID" ]==0) { return $item; }
        
        $language="_".$this->MyLanguage_Get();
        

        $updatedatas=array();
        if (empty($item[ "Title".$language ]))
        {
            $item[ "Title".$language ]=$item[ "Name".$language ];
            array_push($updatedatas,"Title".$language);
        }

        
        if (count($updatedatas)>0)
        {
            $this->Sql_Update_Item_Values_Set($updatedatas,$item);
        }

        return $item;
    }
}

?>