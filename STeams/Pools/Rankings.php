<?php

include_once("Common.php");

include_once("Rankings/Access.php");
include_once("Rankings/Display.php");

class Pool_Rankings extends Common
{
    use
        Pool_Rankings_Access,
        Pool_Rankings_Display;
    

    //*
    //* function Groups, Parameter list: $args=array()
    //*
    //* Constructor.
    //*

    function Pool_Rankings($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=array("Tournament","Pool_Friend","Friend","Ranking","Points");
        $this->Sort=array("Name");
        $this->IDGETVar="ID";

        
        //$this->CellMethods[ "Pool_Bet_Cell_Match_Result" ]=TRUE;
    }

    //*
    //* Overrides SqlTableName, prepending period id.
    //* Calls ApplicationObj->SqlPeriodTableName.
    //*

    function SqlTableName($table="")
    {
        if (empty($table))
        {
            $table=$this->Tournament_Pool_Sql_Table($this->ModuleName);
        }
                
        return $table;
    }

    
    //*
    //* Post process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PreProcessItemData()
    {
        //parent::PostProcessItemData();
    }

    //*
    //* Post process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PostProcessItemData()
    {
        //parent::PostProcessItemData();
    }

    //*
    //* Runs right after module has finished initializing.
    //*
    //* Create number of groups given by Tournament.
    //*

    function PostInit()
    {
    }

    //*
    //* Postprocesses and returns $item.
    //*

    function PostProcess($item,$force=False)
    {
        if
            (
                !$force
                &&
                $this->GetGET("ModuleName")!=$this->ModuleName
            )
        {
            return $item;
        }
        
        if (!isset($item[ "ID" ]) || $item[ "ID" ]==0) { return $item; }

        $updatedatas=array();

        if (count($updatedatas)>0)
        {
            $this->Sql_Update_Item_Values_Set($updatedatas,$item);
        }
        
        return $item;
    }
}

?>