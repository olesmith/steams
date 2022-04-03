<?php

trait Tournaments_Access
{
    //*
    //* Access to Show: Coordinator Permissions
    //*

    function Tournament_Access_Show($item=array())
    {
        if (empty($item)) { return TRUE; }

        return
            $this->PermissionsObj()->
            Permissions_User_Tournament_Access_Show($item[ "ID" ]);
    }
    
    //*
    //* Access to Edit: Coordinator Permissions
    //*

    function Tournament_Access_Edit($item=array())
    {
        if (empty($item)) { return TRUE; }

        return
            $this->PermissionsObj()->
            Permissions_User_Tournament_Access_Edit($item[ "ID" ]);
    }
    
    //*
    //* 
    //*

    function Tournaments_Access_Show($item=array())
    {
        if (empty($item)) { return TRUE; }

        $res=True;

        return $res;
    }
    //*
    //* 
    //*

    function Tournament_Access_Pools($item=array())
    {
        if (empty($item)) { return TRUE; }

        $res=False;

        if
            (
                $this->PoolsObj()->Sql_Select_NHashes
                (
                    array("Tournament" => $item[ "ID" ])
                )>0
                &&
                !$this->Profile_Public_Is()
            )
        {
            $res=$this->Tournaments_Access_Show($item);
        }

        return $res;
    }
    
    //*
    //* Access to EditList
    //*

    function Tournaments_Access_Edit($item=array())
    {
        if (empty($item)) { return TRUE; }

        $res=$this->Tournaments_Access_Show();
        if (preg_match('/^Admin$/',$this->Profile()))
        {
            $res=True;
        }
        elseif (preg_match('/^Coordinator/',$this->Profile()))
        {
            $res=True;
        }
        
        return $res;
    }
    //*
    //* Access to Delete: Should include tests for subitem existences.
    //*

    function Tournament_Access_Delete($item=array())
    {
        if (empty($item)) { return TRUE; }

        $res=False;

        if
            (
                preg_match('/^Admin$/',$this->Profile())
                //&&
                //$this->SeasonsObj()->Sql_Select_NHashes()==0
            )
        {
            $res=True;
        }
        return $res;
    }

    
    //*
    //* 
    //*

    function CheckEditListAccess($item=array())
    {
        return $this->Tournaments_Access_Edit($item);
    }
    
    //*
    //* 
    //*

    function Tournament_Active($item)
    {
        return ($this->CGI_GETint("Tournament")==$item[ "ID" ]);
    }
    //*
    //* 
    //*

    function Tournament_API_Active($item)
    {
        if (empty($item)) { return TRUE; }

        return (intval($item[ "API_Matches_Latency" ])>0);
    }
}

?>