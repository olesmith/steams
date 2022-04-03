<?php

trait Tournaments_Seasons_Access
{
    //*
    //* 
    //*

    function Tournament_Season_Access_Show($item=array())
    {
        if (empty($item)) { return TRUE; }

        $tournament_id=$item[ "ID" ];
        if (!empty($item[ "Tournament" ]))
        {
            $tournament_id=$item[ "Tournament" ];
        }
        return
            $this->PermissionsObj()->
            Permissions_User_Tournament_Access_Show($tournament_id);
    }
    
    //*
    //* 
    //*

    function Tournament_Season_Access_Edit($item=array())
    {
        if (empty($item)) { return TRUE; }

        $tournament_id=$item[ "ID" ];
        if (!empty($item[ "Tournament" ]))
        {
            $tournament_id=$item[ "Tournament" ];
        }

        return
            $this->PermissionsObj()->
            Permissions_User_Tournament_Access_Edit($tournament_id);
    }
    
    //*
    //* 
    //*

    function Tournament_Seasons_Access_Show($item=array())
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
        return $this->Tournament_Seasons_Access_Edit();
    }
    
    //*
    //* 
    //*

    function Tournament_Seasons_Access_Edit($item=array())
    {
        if (empty($item)) { return TRUE; }

        return
            $this->PermissionsObj()->
            Permissions_User_Tournament_Access_EditList();
    }
    
    //*
    //* 
    //*

    function Tournament_Season_Access_Delete($item=array())
    {
        if (empty($item)) { return TRUE; }

        $res=False;

        if (preg_match('/^Admin$/',$this->Profile()))
        {
            $res=True;
        }
        return $res;
    }
    
    //*
    //* 
    //*

    function Tournament_Season_Active($season)
    {
        $res=False;
        if ($season[ "ID" ]==$this->Tournament("Season"))
        {
            $res=True;
        }
        
        return $res;
    }
}

?>