<?php

include_once("Common.php");

include_once("Tournaments/Groups/Access.php");
include_once("Tournaments/Groups/Get.php");
include_once("Tournaments/Groups/Create.php");
include_once("Tournaments/Groups/Teams.php");
include_once("Tournaments/Groups/Rounds.php");
include_once("Tournaments/Groups/Matches.php");

class Tournament_Groups extends Common
{
    var $__Groups__=array();

    
    use
        Tournaments_Groups_Access,
        Tournament_Groups_Get,
        Tournament_Groups_Create,
        Tournament_Groups_Teams,
        Tournament_Groups_Matches,
        Tournament_Groups_Rounds;
    

    //*
    //* function Groups, Parameter list: $args=array()
    //*
    //* Constructor.
    //*

    function Tournament_Groups($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=array("Tournament","Team",);
        $this->Sort=array("Name");
        $this->IDGETVar="Group";

        
        $this->CellMethods[ "Group_NRounds_Cell" ]=TRUE;
        $this->CellMethods[ "Group_NMatches_Cell" ]=TRUE;
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

    function PostProcess($item)
    {
        if ($this->GetGET("ModuleName")!=$this->ModuleName)
        {
            return $item;
        }

        if (!isset($item[ "ID" ]) || $item[ "ID" ]==0) { return $item; }

        return $item;
    }
    
    //*
    //*
    //*

    function Group_NRounds_Cell($edit=0,$item=array(),$data="")
    {
        if (empty($item))
        {
            return "Nº ".$this->RoundsObj()->MyMod_ItemsName();
        }

        $where=
            array
            (
                "Tournament"       => $item[ "Tournament" ],
                "Tournament_Group" => $item[ "ID" ],
            );
        
         return
            $this->RoundsObj()->Sql_Select_NHashes($where);
    }
    
    //*
    //*
    //*

    function Group_NMatches_Cell($edit=0,$item=array(),$data="")
    {
        if (empty($item))
        {
            return "Nº ".$this->MatchesObj()->MyMod_ItemsName();
        }

        $where=
            array
            (
                "Tournament"       => $item[ "Tournament" ],
                "Tournament_Group" => $item[ "ID" ],
            );
        
        $rounds_where=
            array_merge
            (
                $where,
                array
                (
                    "__Round" => "Tournament_Round>'0'",
                )
            );

        $nmatches=
            $this->MatchesObj()->Sql_Select_NHashes($where);
        
        $nmatches_should=
            $this->MatchesObj()->Sql_Select_NHashes($rounds_where);
        
        $text=$nmatches;
        $color='green';
        if ($nmatches_should<$nmatches)
        {
            $text.=" (".$nmatches_should.")";
            $color='red';
        }
        
        return
            $this->Htmls_Span
            (
                $text,
                array
                (
                    "STYLE" => array
                    (
                        "color" => $color,
                    )
                )
            );
    }

    //*
    //* Read group.
    //*

    function Tournament_Group($group_id,$key="")
    {
        if (is_array($group_id))
        {
            if (isset($group_id[ "Tournament_Group" ]))
            {
                $group_id=$group_id[ "Tournament_Group" ];
            }
        }
        
        if (empty($this->__Groups__[ $group_id ]))
        {
            $this->__Groups__[ $group_id ]=
                $this->GroupsObj()->Sql_Select_Hash
                (
                    array("ID" => $group_id)
                );
        }

        if (!empty($key))
        {
            return $this->__Groups__[ $group_id ][ $key ];
        }
        
        return $this->__Groups__[ $group_id ];
    }
    
    //*
    //* Return group name.
    //*

    function Tournament_Group_Name($group_id,$key="Name")
    {
        return $this->Tournament_Group($group_id,$key);
    }
}

?>