<?php

trait Friends_Access
{
    //*
    //* 
    //*

    function Friend_Access_Show($item=array())
    {
        if (empty($item)) { return TRUE; }

        $res=False;
        if ($item[ "ID" ]==$this->LoginData("ID"))
        {
            $res=True;
        }
        elseif (preg_match('/^Admin$/',$this->Profile()))
        {
            $res=True;
        }
        elseif (preg_match('/^Coordinator/',$this->Profile()))
        {
            $res=False;
        }
        
        return $res;
    }
    
    //*
    //* 
    //*

    function Friend_Access_Edit($item=array())
    {
        if (empty($item)) { return TRUE; }

        return $this->Friends_Access_Show($item);
    }
    
    //*
    //* 
    //*

    function Friends_Access_Show($item=array())
    {
        if (empty($item)) { return TRUE; }

        $res=False;
        if (preg_match('/^Admin$/',$this->Profile()))
        {
            $res=True;
        }
        elseif (preg_match('/^Coordinator/',$this->Profile()))
        {
            $res=False;
        }
        
        return $res;
    }
    
    //*
    //* 
    //*

    function CheckEditListAccess($item=array())
    {
        return $this->Friends_Access_Edit($item);
    }
    
    //*
    //* 
    //*

    function Friends_Access_Edit($item=array())
    {
        if (empty($item)) { return TRUE; }

        return $this->Friends_Access_Show($item);
    }
    //*
    //* 
    //*

    function Friend_Access_Delete($item=array())
    {
        if (empty($item)) { return TRUE; }

        $res=False;
        return $res;
    }

    //*
    //* Checks if $item may be downloaded. Admin may -
    //* and Person, if LoginData[ "ID" ]==$item[ "ID" ]
    //* Activated in System::Friends::Profiles.
    //*

    function CheckDownloadAccess($item=array())
    {
        if (empty($item)) { return TRUE; }

        return TRUE;
    }
}

?>