<?php

include_once("DBGroups/Access.php");
include_once("DBGroups/Form.php");
include_once("DBGroups/Languages.php");

class DBGroups extends DBGroupsLanguages
{    
    //*
    //* function SqlTableName, Parameter list: $table=""
    //*
    //* Overrides SqlTableName, prepending period id.
    //* Calls ApplicationObj->SqlPeriodTableName.
    //*

    function SqlTableName($table="")
    {
        return $this->ApplicationObj->SqlEventTableName("GroupDatas",$table);
    }

    /* //\* */
    /* //\* function MyMod_Setup_Profiles_File, Parameter list: */
    /* //\* */
    /* //\* Returns name of file with Permissions and Accesses to Modules. */
    /* //\* Overrides trait! */
    /* //\* */

    /* function MyMod_Setup_Profiles_File0000() */
    /* { */
    /*     return join("/",array("..","Application","System","DBGroups","Profiles.php")); */
    /* } */
    
    //*
    //* function PreProcessItemData, Parameter list:
    //*
    //* Pre process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PreProcessItemData()
    {
        $this->Sql_Table_Column_Rename("Text","Text_PT");
        $this->Languages_Init_ItemData();
    }
    //*
    //* function PreProcessItemDataGroups, Parameter list:
    //*
    //* 
    //*

    function PreProcessItemDataGroups()
    {
    }
    
    //*
    //* function PreProcessItemData, Parameter list:
    //*
    //* Pre process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PreActions()
    {
    }
    
    //*
    //* function PostProcessItemData, Parameter list:
    //*
    //* Post process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PostProcessItemData()
    {
        $pertainsnames=array();
        foreach ($this->ApplicationObj()->PertainsSetup as $pertains => $def)
        {
            array_push($pertainsnames,$this->GetRealNameKey($def,"Title"));         
        }

        #$this->ItemData[ "Pertains" ][ "Values" ]=$pertainsnames;
    }

    //*
    //* function PostInit, Parameter list:
    //*
    //* Runs right after module has finished initializing.
    //*

    function PostInit()
    {
    }

    //*
    //* function PostProcess, Parameter list: $item
    //*
    //* Postprocesses and returns $item.
    //*

    function PostProcess($item)
    {
        if (!isset($item[ "ID" ]) || $item[ "ID" ]==0) { return $item; }

        $updatedatas=array();
        if (count($updatedatas)>0)
        {
            $this->Sql_Update_Item_Values_Set($updatedatas,$item);
        }

        return $item;
    }
    
    //*
    //* function Sql_Table_Default_Items, Parameter list:
    //*
    //* Returns items to add to empty table.
    //*

    function Sql_Table_Default_Items()
    {
        return
            array
            (
                array
                (
                    "SortOrder" => 1,
                    #"Pertains" => 1,
                    "Text_PT" => "Questionário, Básico",
                    "Text_UK" => "Questionary, Basic",
                )
            );
    }
    
}

?>