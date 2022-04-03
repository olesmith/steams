<?php

trait Countries_Access
{
    //*
    //* 
    //*

    function Country_Access_Show($item=array())
    {
        if (empty($item)) { return TRUE; }

        return True;
    }
    
    //*
    //* 
    //*

    function Country_Access_Edit($item=array())
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

    function Countries_Access_Show($item=array())
    {
        if (empty($item)) { return TRUE; }

        return True;
    }
    
    //*
    //* 
    //*

    function CheckEditListAccess($item=array())
    {
        return $this->Countries_Access_Edit($item);
    }
    
    //*
    //* 
    //*

    function Countries_Access_Edit($item=array())
    {
        if (empty($item)) { return TRUE; }

        return $this->Countries_Access_Show($item);
    }
    //*
    //* 
    //*

    function Country_Access_Delete($item=array())
    {
        if (empty($item)) { return TRUE; }
        
        return $this->Countries_Access_Edit($item);
    }
}

?>