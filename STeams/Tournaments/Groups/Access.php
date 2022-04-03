<?php

trait Tournaments_Groups_Access
{
    //*
    //* 
    //*

    function Tournament_Group_Access_Show($item=array())
    {
        if (empty($item)) { return TRUE; }

        return
            $this->PermissionsObj()->
            Permissions_User_Tournament_Access_Show($item[ "Tournament" ]);
    }
    
    //*
    //* 
    //*

    function Tournament_Group_Access_Edit($item=array())
    {
        if (empty($item)) { return TRUE; }

        return
            $this->PermissionsObj()->
            Permissions_User_Tournament_Access_Show($item[ "Tournament" ]);
    }
    
    //*
    //* 
    //*

    function Tournament_Groups_Access_Show($item=array())
    {
        if (empty($item)) { return TRUE; }

        return
            $this->PermissionsObj()->
            Permissions_User_Tournament_Access_Search();
        
        return $res;
    }
    
    //*
    //* 
    //*

    function CheckEditListAccess($item=array())
    {
        return $this->Tournament_Groups_Access_Edit();
    }
    
    //*
    //* 
    //*

    function Tournament_Groups_Access_Edit($item=array())
    {
        if (empty($item)) { return TRUE; }

        return
            $this->PermissionsObj()->
            Permissions_User_Tournament_Access_EditList();
    }
    
    //*
    //* 
    //*

    function Tournament_Group_Access_Delete($item=array())
    {
        if (empty($item)) { return TRUE; }

        $res=False;

        if (preg_match('/^Admin$/',$this->Profile()))
        {
            $res=True;
        }
        return $res;
    }
}

?>