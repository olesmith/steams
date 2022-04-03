<?php

trait APIs_Access
{
    //*
    //* Access to Show: Coordinator Permissions
    //*

    function API_Access_Show($item=array())
    {
        if (empty($item)) { return TRUE; }

        return
            $this->PermissionsObj()->
            Permissions_User_Tournament_Access_Show($item[ "Tournament" ]);
    }
    
    //*
    //* Access to Edit: Coordinator Permissions
    //*

    function API_Access_Edit($item=array())
    {
        if (empty($item)) { return TRUE; }

        return
            $this->PermissionsObj()->
            Permissions_User_Tournament_Access_Edit($item[ "Tournament" ]);
    }
    
    //*
    //* 
    //*

    function APIs_Access_Show($item=array())
    {
        if (empty($item)) { return TRUE; }

        $res=True;

        return $res;
    }
    //*
    //* 
    //*

    function API_Access_Pools($item=array())
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
            $res=$this->APIs_Access_Show($item);
        }

        return $res;
    }
    
    //*
    //* Access to EditList
    //*

    function APIs_Access_Edit($item=array())
    {
        if (empty($item)) { return TRUE; }

        $res=$this->APIs_Access_Show();
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

    function API_Access_Delete($item=array())
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
        return $this->APIs_Access_Edit($item);
    }
}

?>