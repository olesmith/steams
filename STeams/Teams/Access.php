<?php

trait Teams_Access
{
    //*
    //* 
    //*

    function Team_Access_Edit($item=array())
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

    function Team_Access_Show($item=array())
    {
        if (empty($item)) { return TRUE; }

        return True;
    }
    
    //*
    //* 
    //*

    function Teams_Access_Show($item=array())
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
        return $this->Teams_Access_Edit($item);
    }
    
    //*
    //* 
    //*

    function Teams_Access_Edit($item=array())
    {
        if (empty($item)) { return TRUE; }

        return $this->Teams_Access_Show($item);
    }
    //*
    //* 
    //*

    function Team_Access_Delete($item=array())
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