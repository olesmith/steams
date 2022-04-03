<?php

trait Pools_Access
{
    //*
    //* 
    //*

    function Pool_Access_Show($item=array())
    {
        if (empty($item)) { return TRUE; }

        return
            $this->PermissionsObj()->
            Permissions_User_Tournament_Access_Show($item[ "Tournament" ]);
    }
    
    //*
    //* 
    //*

    function Pool_Access_Edit($item=array())
    {
        if (empty($item)) { return TRUE; }

        return
            $this->PermissionsObj()->
            Permissions_User_Tournament_Access_Show($item[ "Tournament" ]);
    }
    
    //*
    //* 
    //*

    function Pools_Access_Show($item=array())
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
        return $this->Pools_Access_Edit();
    }
    
    //*
    //* 
    //*

    function Pools_Access_Edit($item=array())
    {
        if (empty($item)) { return TRUE; }

        return
            $this->PermissionsObj()->
            Permissions_User_Tournament_Access_EditList();
    }
    
    //*
    //* 
    //*

    function Pool_Access_Delete($item=array())
    {
        if (empty($item)) { return TRUE; }

        $res=False;

        if (preg_match('/^Admin$/',$this->Profile()))
        {
            if
                (
                    $this->Pool_FriendsObj()->Sql_Select_Hashes
                    (
                        array
                        (
                            "Pool" => $item[ "ID" ],
                        )
                    )==0
                )
            {
                $res=True;
            }
        }
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
                $this->Sql_Select_NHashes
                (
                    array
                    (
                        "Tournament" => $item[ "ID" ]
                    )
                )>0
            )
        {
            $res=True;
        }

        return $res;
    }
    //*
    //* 
    //*

    function Tournament_Season_Access_Pools($item=array())
    {
        if (empty($item)) { return TRUE; }

        $res=False;

        if
            (
                $this->Sql_Select_NHashes
                (
                    array
                    (
                        "Tournament" => $item[ "Tournament" ],
                        "Season" => $item[ "ID" ],
                    )
                )>0
            )
        {
            $res=True;
        }

        return $res;
    }
}

?>