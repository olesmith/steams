<?php


class Permissions_User extends Permissions_Users
{
    //*
    //*
    //*

    function Permissions_User_Html($edit,$user)
    {
        return
            $this->Htmls_Table
            (
                $this->Permissions_User_Titles(),
                $this->Permissions_User_Table($edit,$user)
            );
    }
    //*
    //*
    //*

    function Permissions_User_Table($edit,$user)
    {
        return
            $this->MyMod_Items_Table
            (
                $edit,
                $this->Permissions_User_Read($user),
                $this->Permissions_User_Data()
            );
    }
    //*
    //*
    //*

    function Permissions_User_Data_Read()
    {
        return
            array_merge
            (
                array("ID"),
                $this->Permissions_User_Data()
            );
    }
    
    //*
    //*
    //*

    function Permissions_User_Data()
    {
        return $this->MyMod_Data_Group_Datas_Get("Basic");
    }
    //*
    //*
    //*

    function Permissions_User_Titles()
    {
        return
            $this->MyMod_Data_Titles
            (
                $this->Permissions_User_Data()
            );
    }
    
    //*
    //*
    //*

    function Permissions_User_Read($user)
    {
        if (empty($user[ "ID" ])) { return array(); }
        
        return
            $this->Sql_Select_Hashes
            (
                array("User" => $user[ "ID" ]),
                $this->Permissions_User_Data_Read()
            );
    }
    //*
    //*
    //*

    function Permissions_User_Read_N($user)
    {
        return
            $this->Sql_Select_NHashes
            (
                array("User" => $user[ "ID" ])
            );
    }

}

?>