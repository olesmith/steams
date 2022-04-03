<?php

trait Pool_Friends_Access
{
    //*
    //* 
    //*

    function Pool_Friend_Access_Show($item=array())
    {
        if (empty($item)) { return TRUE; }

        return
            $this->PermissionsObj()->
            Permissions_User_Tournament_Access_Show($item[ "Tournament" ]);
    }
    
    //*
    //* 
    //*

    function Pool_Friend_Access_Edit($item=array(),$action="",$def=array())
    {
        if (empty($item)) { return TRUE; }

        if (preg_match('/^(Friend)$/',$this->Profile()))
        {
            $res=False;
            if ($item[ "Friend" ]==$this->LoginData("ID"))
            {
                $res=True;
            }

            return $res;
        }

        //var_dump($item,$action,$def);
        return
            $this->PermissionsObj()->
            Permissions_User_Tournament_Access_Show($item[ "Tournament" ]);
    }
    
    //*
    //* 
    //*

    function Pool_Friends_Access_Show($item=array())
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
        return $this->Pool_Friends_Access_Edit();
    }
    
    //*
    //* 
    //*

    function Pool_Friends_Access_Edit($item=array())
    {
        if (empty($item)) { return TRUE; }

        return
            $this->PermissionsObj()->
            Permissions_User_Tournament_Access_EditList();
    }
    
    //*
    //* 
    //*

    function Pool_Friend_Access_Delete($item=array())
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