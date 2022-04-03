<?php

include_once("Common.php");

include_once("Bets/Access.php");
include_once("Bets/Cell.php");
include_once("Bets/Cells.php");
include_once("Bets/Round.php");
include_once("Bets/Friend.php");
include_once("Bets/Calc.php");

class Pool_Bets extends Common
{
    var $__Pools__=array();
    
    use
        Pool_Bets_Access,
        Pool_Bets_Cell,
        Pool_Bets_Cells,
        Pool_Bets_Round,
        Pool_Bets_Friend,
        Pool_Bets_Calc;
    

    //*
    //* function Groups, Parameter list: $args=array()
    //*
    //* Constructor.
    //*

    function Pool_Bets($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=array("Tournament","Pool_Friend","Friend","Result","Points","Updated",);
        $this->Sort=array("Name");
        $this->IDGETVar="Bet";

        
        $this->CellMethods[ "Pool_Bet_Cell_Match_Team_Icons" ]=TRUE;
        $this->CellMethods[ "Pool_Bet_Cell_Match_Date_Time" ]=TRUE;
        $this->CellMethods[ "Pool_Bet_Cell_Match_Result" ]=TRUE;
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

        $this->Pool_Bet_Calc($item,$updatedatas);
        
        if (count($updatedatas)>0)
        {
            $data="Updated";
            if (empty($item[ $data ])) { $item[ $data ]=1; }
            array_push($updatedatas,$data);
            $this->Sql_Update_Item_Values_Set($updatedatas,$item);
            $updated=True;
        }
        
        return $item;
    }
    
    //*
    //* Zeroes a bet.
    //*

    function Pool_Bet_Reset(&$bet,&$updatedatas)
    {
        foreach
            (
                array("Result","Points","Result_Goals","Result_Goal")
                as $data
            )
        {
            if (empty($bet[ $data ]) || $bet[ $data ]!=0)
            {
                $bet[ $data ]=0;
                array_push($updatedatas,$data);
            }
        }
    }
    
    //*
    //* Team icons as a span.
    //*

    function Pool_Bet_Match($bet,$datas=array())
    {
        $match=
            $this->MatchesObj()->Sql_Select_Hash
            (
                array
                (
                    "Tournament" => $bet[ "Tournament" ],
                    "ID"         => $bet[ "Tournament_Match" ],
                ),
                $datas
            );

        for ($i=1;$i<=2;$i++)
        {
            if
                (
                    isset($match[ "Goals".$i ])
                    &&
                    $match[ "Goals".$i ]==""
                )
            {
                $match[ "Goals".$i ]='0';
            }
        }

        $this->MatchesObj()->Match_Calc_Date_HHMM($match);
        
        return $match;
    }
    
    
    //*
    //* 
    //*

    function Bet_Team_Icon($bet,$n)
    {
        if (empty($bet)) { return ""; }

        $namer="Name_".$this->MyLanguage_Get();
        $data="Icon";

        $team=
            $this->MatchesObj()->Sql_Select_Hash_Value
            (
                $bet[ "Tournament_Match" ],
                "Team".$n
            );

        return
            $this->TeamsObj()->MyMod_Data_Fields_File_Decorator_Download_IMG
            (
                $this->TeamsObj()->Sql_Select_Hash
                (
                    array("ID" => $team),
                    array($data,$namer)
                ),
                $data
            );
    }
    
    //*
    //* 
    //*

    function Bet_Team1_Icon($bet)
    {
        return $this->Bet_Team_Icon($bet,1);
    }
    //*
    //* 
    //*

    function Bet_Team2_Icon($bet)
    {
        return $this->Bet_Team_Icon($bet,2);
    }
}

?>