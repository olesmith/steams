<?php

trait Tournaments_Teams_Access
{
    //*
    //* 
    //*

    function Tournament_Team_Access_Show($item=array())
    {
        if (empty($item)) { return TRUE; }

        $res=
            $this->PermissionsObj()->
            Permissions_User_Tournament_Access_Show($item[ "Tournament" ]);
            
        return $res;
    }
    
    //*
    //* 
    //*

    function Tournament_Team_Access_Edit($item=array())
    {
        if (empty($item)) { return TRUE; }

        $res=
            $this->PermissionsObj()->
            Permissions_User_Tournament_Access_Edit($item[ "Tournament" ]);
        
        return  $res;
    }
    
    //*
    //* 
    //*

    function Tournament_Teams_Access_Show($item=array())
    {
        if (empty($item)) { return TRUE; }

 
        return
            $this->PermissionsObj()->
            Permissions_User_Tournament_Access_Search();
    }
    
    //*
    //* 
    //*

    function CheckEditListAccess($item=array())
    {
        return $this->Tournament_Teams_Access_Edit();
    }
    
    //*
    //* 
    //*

    function Tournament_Teams_Access_Edit($item=array())
    {
        if (empty($item)) { return TRUE; }
 
        return
            $this->PermissionsObj()->
            Permissions_User_Tournament_Access_EditList();
    }
    
    //*
    //* 
    //*

    function Tournament_Team_Access_Delete($item=array())
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