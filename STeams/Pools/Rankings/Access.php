<?php

trait Pool_Rankings_Access
{
    //*
    //* 
    //*

    function Pool_Ranking_Access_Show($item=array())
    {
        if (empty($item)) { return TRUE; }

        return
            $this->PermissionsObj()->
            Permissions_User_Tournament_Access_Show($item[ "Tournament" ]);
    }
    
    //*
    //* 
    //*

    function Pool_Ranking_Access_Edit($item=array())
    {
        return False;
    }
    
    //*
    //* 
    //*

    function Pool_Rankings_Access_Show($item=array())
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
        return $this->Pool_Rankings_Access_Edit($item);
    }
    
    //*
    //* 
    //*

    function Pool_Rankings_Access_Edit($item=array())
    {
        return $this->Profile_Admin_Is();
    }
    
    //*
    //* 
    //*

    function Pool_Ranking_Access_Delete($item=array())
    {
        if (empty($item)) { return TRUE; }

        $res=False;

        if ($this->Profile_Admin_Is())
        {
            $res=True;
        }
        
        return $res;
    }
}

?>