<?php

include_once("Common.php");

include_once("Pools/Access.php");
include_once("Pools/Cells.php");
include_once("Pools/Read.php");
include_once("Pools/Handle.php");
include_once("Pools/Friend.php");
include_once("Pools/Ranking.php");

class Pools extends Common
{
    var $__Pools__=array();
    var $__Pool_Scores__=array(10,7,5,2,0);
    
    use
        Pools_Access,
        Pools_Cells,
        Pool_Read,
        Pool_Handle,
        Pool_Friend,
        Pool_Ranking;
    

    //*
    //* function Groups, Parameter list: $args=array()
    //*
    //* Constructor.
    //*

    function Pools($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=array("Tournament","Friend",);
        $this->Sort=array("Name");
        $this->IDGETVar="Pool";

        
        $this->CellMethods[ "Pool_Cell_Public_URL" ]=TRUE;
        $this->CellMethods[ "Pool_Cell_Mobile_URL" ]=TRUE;
        $this->CellMethods[ "Pool_Cell_NParticipants" ]=TRUE;
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
            $table=$this->ModuleName;
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
        //$this->Pool_FriendsObj()->Sql_Table_Structure_Update();
        //$this->Pool_BetsObj()->Sql_Table_Structure_Update();
    }

    //*
    //* Postprocesses and returns $item.
    //*

    function PostProcess($item)
    {
        if ($this->GetGET("ModuleName")!=$this->ModuleName)
        {
            return $item;
        }

        if (!isset($item[ "ID" ]) || $item[ "ID" ]==0) { return $item; }

        //Add owner to pool
        $where=
            array
            (
                "Tournament" => $item[ "Tournament" ],
                "Season" => $item[ "Season" ],
                "Pool" => $item[ "ID" ],
                "Friend" => $item[ "Friend" ],
            );
        
        $friend_pool=
            $this->Pool_FriendsObj()->Sql_Select_Hash
            (
                $where,
                array("ID")
            );
        
        if
            (
                empty($friend_pool)
            )
        {
            $this->Pool_FriendsObj()->Sql_Insert_Item
            (
                $where
            );
        }

        return $item;
    }

    var $__Pool__=array();
    
    //*
    //* Centralized reading for Pool. Called by Common.php.
    //*

    function Pool($key="")
    {
        if (empty($this->__Pool__))
        {
            $this->__Pool__=
                $this->Sql_Select_Hash
                (
                    array("ID" => $this->CGI_POSTOrGETint("Pool"))
                );
            
            $this->Sql_Pool_Update_Structure();
        }

        if (!empty($key))
        {
            return $this->__Pool__[ $key ];
        }
        
        return $this->__Pool__;
    }
    
    //*
    //* Updates table structure of derived modules: Friends and Bets
    //*

    function Sql_Pool_Update_Structure()
    {
        $this->Pool_FriendsObj()->Sql_Table_Structure_Update();
        $this->Pool_BetsObj()->Sql_Table_Structure_Update();    
    }

    //*
    //*
    //*

    function Pool_Scores()
    {
        return $this->__Pool_Scores__;
    }
    
    //*
    //*
    //*

    function Pool_Scores_Hash()
    {
        $scores=array();
        foreach ($this->Pool_Scores() as $score)
        {
            $scores[ $score ]=0;
        }

        return $scores;
    }

    
    //*
    //*
    //*

    function Tournament_Season_Sql_Where($data,$item)
    {
        return
            array
            (
                "Tournament" => $item[ "Tournament" ],
            );
    }
}

?>