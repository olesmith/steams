<?php


class Permissions_Access extends App_Permissions
{
    //*
    //* Checks if $item may be viewed. Admin may -
    //* and Person, if LoginData[ "ID" ]==$item[ "ID" ]
    //* Activated in System::Friends::Profiles.
    //*

    function CheckShowAccess($item=array())
    {
        if (empty($item)) { return TRUE; }
        
        $res=False;
        if ($this->Profile_Trust()>=$this->Profile_Trust("Coordinator"))
        {
            $res=True;
        }

        return $res;
    }

    //*
    //*

    function CheckShowListAccess()
    {
        $res=False;
        if ($this->Profile_Trust()>=$this->Profile_Trust("Coordinator"))
        {
            $res=True;
        }
        
        return $res;        
    }

    //*
    //*
    //* Checks if $item may be edited. Admin may -
    //* and Person, if LoginData[ "ID" ]==$item[ "ID" ].
    //* Activated in  System::Friends::Profiles.
    //*

    function CheckEditAccess($item=array())
    {
        if (empty($item)) { return TRUE; }

        $profile_trust=$this->Profile_Trust();

        $res=$this->CheckShowAccess($item);

        if ($this->Profile_Trust()>=$this->Profile_Trust("Admin"))
        {
            $res=True;
        }

        return $res;
    }

    //*
    //* 
    //*

    function CheckEditListAccess()
    {
        $res=False;
        if ($this->Profile_Trust()>=$this->Profile_Trust("Admin"))
        {
            $res=True;
        }
        return $res;
    }


    //*
    //* function CheckDeleteAccess, Parameter list: $item=array()
    //*
    //* Checks if $item may be deleted. That is:
    //* No questionary data defined - and no inscriptions.
    //*

    function CheckDeleteAccess($item=array())
    {
        if (empty($item)) { return TRUE; }
        if (empty($item[ "ID" ])) { return FALSE; }

        $res=False;
        if ($this->Profile_Trust()>=$this->Profile_Trust("Admin"))
        {
            $res=True;
        }
 
        return $res;
    }    
}

?>