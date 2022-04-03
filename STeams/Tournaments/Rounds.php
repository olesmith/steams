<?php

include_once("Common.php");

include_once("Tournaments/Rounds/Access.php");
include_once("Tournaments/Rounds/Matches.php");
include_once("Tournaments/Rounds/Cells.php");

class Tournament_Rounds extends Common
{    
    use
        Tournaments_Rounds_Access,
        Tournaments_Rounds_Matches,
        Tournaments_Rounds_Cells;
    

    //*
    //* function Rounds, Parameter list: $args=array()
    //*
    //* Constructor.
    //*

    function Tournament_Rounds($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=array("Tournament","Team","Number",);
        $this->Sort=array("Number","Name");
        $this->IDGETVar="Round";

        
        $this->CellMethods[ "Round_Cell_Friend_NMatches" ]=TRUE;
        $this->CellMethods[ "Round_Cell_Friend_NBets" ]=TRUE;
        $this->CellMethods[ "Round_Cell_NMatches" ]=TRUE;
        $this->CellMethods[ "Round_Cell_Dates" ]=TRUE;
        $this->CellMethods[ "Round_Cell_Friend_Score" ]=TRUE;
        $this->CellMethods[ "Round_Dates_Cell" ]=TRUE;
    }

    //*
    //* Overrides SqlTableName, prepending period id.
    //* Calls ApplicationObj->SqlPeriodTableName.
    //*

    function SqlTableName($table="")
    {
        if (empty($table))
        {
            $table=$this->Tournament_Sql_Table($this->ModuleName);
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
        $this->PostProcess_Dates($item,$updatedatas);

        if (count($updatedatas)>0)
        {
            //var_dump($updatedatas);
            $this->Sql_Update_Item_Values_Set($updatedatas,$item);
        }
        return $item;
    }

    //*
    //*
    //*

    function PostProcess_Dates(&$item,&$updatedatas)
    {
        
        $where=
            array
            (
                "Tournament" => $item[ "Tournament" ],
                //"Tournament_Group" => $item[ "Tournament_Group" ],
                "Tournament_Round" => $item[ "ID" ],
            );
        
        $startdate=
            $this->MatchesObj()->Sql_Select_Min
            (
                $where,
                "Date"
            );

        $data="StartDate";
        if (empty($item[ $data ]) || $item[ $data ]!=$startdate)
        {
            $item[ $data ]=$startdate;
            array_push($updatedatas,$data);
        }
        
        $enddate=
            $this->MatchesObj()->Sql_Select_Max
            (
                $where,
                "Date"
            );

        $data="EndDate";
        if (empty($item[ $data ]) || $item[ $data ]!=$enddate)
        {
            $item[ $data ]=$enddate;
            array_push($updatedatas,$data);
        }
    }
}

?>