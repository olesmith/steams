<?php

trait Tournaments_Rounds_Access
{
    //*
    //* Show one
    //*

    function Tournament_Round_Access_Show($item=array())
    {
        if (empty($item)) { return TRUE; }

         return
            $this->PermissionsObj()->
            Permissions_User_Tournament_Access_Show($item[ "Tournament" ]);
    }
    
    //*
    //* Edit one
    //*

    function Tournament_Round_Access_Edit($item=array())
    {
        if (empty($item)) { return TRUE; }

        return
            $this->PermissionsObj()->
            Permissions_User_Tournament_Access_Edit($item[ "Tournament" ]);
    }
    
    //*
    //* Listing read
    //*

    function Tournament_Rounds_Access_Show($item=array())
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
        return $this->Tournament_Rounds_Access_Edit();
    }
    
    //*
    //* List edit
    //*

    function Tournament_Rounds_Access_Edit($item=array())
    {
        if (empty($item)) { return TRUE; }

        return
            $this->PermissionsObj()->
            Permissions_User_Tournament_Access_EditList();
    }
    //*
    //* 
    //*

    function Tournament_Round_Access_Delete($item=array())
    {
        if (empty($item)) { return TRUE; }

        $res=False;

        if (preg_match('/^Admin$/',$this->Profile()))
        {
            $res=True;
        }
        return $res;
    }

    var $__Tournament_Round_Active__=-1;

    
    //*
    //* Show one
    //*

    function Tournament_Round_Active_Is($item,$items)
    {
        //var_dump($item);
        if ($this->__Tournament_Round_Active__<0)
        {
            $today=$this->MyTime_2Sort();

            $date_key="StartDate";

            $item_ids=array_reverse(array_keys($items));
            
            $this->__Tournament_Round_Active__=
                $items[ $item_ids[ count($item_ids)-1 ] ][ "ID" ];

            for ($n=0;$n<count($item_ids);$n++)
            {
                if ($today>=$items[ $item_ids[ $n ] ][ $date_key ])
                {
                    $this->__Tournament_Round_Active__=
                        $items[ $item_ids[ $n ] ][ "ID" ];

                    break;//found!
                }
            }
        }
        
        $res=False;
        if ($item[ "ID" ]==$this->__Tournament_Round_Active__)
        {
            $res=True;
        }

        return $res;
    }
    
}

?>