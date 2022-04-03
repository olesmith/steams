<?php

include_once("Common.php");

include_once("Pools/Friends/Access.php");
include_once("Pools/Friends/Cells.php");
include_once("Pools/Friends/Round.php");

class Pool_Friends extends Common
{
    var $__Pool_Friends__=array();
    
    use
        Pool_Friends_Access,
        Pool_Friends_Cells,
        Pool_Friend_Round;
    

    //*
    //* function Groups, Parameter list: $args=array()
    //*
    //* Constructor.
    //*

    function Pool_Friends($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=array("Tournament","Friend",);
        $this->Sort=array("Name");
        $this->IDGETVar="Owner";

        
        $this->CellMethods[ "Pool_Friend_Cell_Points" ]=TRUE;
        $this->CellMethods[ "Pool_Friend_Cell_Stats" ]=TRUE;
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
        if ($this->GetGET("ModuleName")!=$this->ModuleName)
        {
            if (!$force) { return $item; }
        }

        if (!isset($item[ "ID" ]) || $item[ "ID" ]==0) { return $item; }

        $updatedatas=array();

        $name=
            $this->FriendsObj()->Sql_Select_Hash_Value
            (
                $item[ "Friend" ],
                "Name"
            );
        if (empty($item[ "Name" ]) || $item[ "Name" ]!=$name)
        {
            $item[ "Name" ]=$name;
            array_push($updatedatas,"Name");
        }

        if (count($updatedatas)>0)
        {
            $this->Sql_Update_Item_Values_Set($updatedatas,$item);
        }
        
        return $item;
    }
}

?>