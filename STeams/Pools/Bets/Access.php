<?php

trait Pool_Bets_Access
{
    //*
    //* 
    //*

    function Pool_Bet_Access_Show($item=array())
    {
        if (empty($item)) { return TRUE; }

        return
            $this->PermissionsObj()->
            Permissions_User_Tournament_Access_Show($item[ "Tournament" ]);
    }
    
    //*
    //* 
    //*

    function Pool_Bet_Access_Edit($bet=array())
    {
        if (empty($bet)) { return TRUE; }

        $res=
            $this->PermissionsObj()->
            Permissions_User_Tournament_Access_Show($bet[ "Tournament" ]);

        if ($res)
        {
            $perms=$this->Pool_Bet_Permissions($bet);

            if ($perms<2)
            {
                $res=False;
            }
        }

        return $res;
    }
    
    //*
    //* 
    //*

    function Pool_Bets_Access_Show($item=array())
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
        return $this->Pool_Bets_Access_Edit();
    }
    
    //*
    //* 
    //*

    function Pool_Bets_Access_Edit($item=array())
    {
        if (empty($item)) { return TRUE; }

        return
            $this->PermissionsObj()->
            Permissions_User_Tournament_Access_EditList();
    }
    
    //*
    //* 
    //*

    function Pool_Bet_Access_Delete($item=array())
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