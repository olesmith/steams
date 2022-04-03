<?php

include_once("Users/Tournaments.php");

class Permissions_Users extends Permissions_Units
{
    use
        Permissions_Users_Tournaments;

    //Global lists, used for fast access.
    var $User_Permission_Tournaments=array();
    
    var $User_Permissions=array();
    
    //*
    //* Reads user permissions if necessary.
    //*

    function Permissions_User_Get($user=array(),$profile="")
    {
        if (empty($user))    { $user=$this->LoginData(); }

        if (empty($this->User_Permissions[ $user[ "ID" ] ]))
        {
            $this->User_Permissions[ $user[ "ID" ] ]=
                $this->Sql_Select_Hashes
                (
                    $this->Permissions_User_Where
                    (
                        $user,$profile
                    )
                );
        }

        return $this->User_Permissions[ $user[ "ID" ] ];
        
    }
    
    //*
    //* Returns where clause for read of user permissions.
    //*

    function Permissions_User_Where($user=array(),$profile="")
    {
        if (empty($user)) { $user=$this->LoginData(); }
        if (empty($profile)) { $profile=$this->ApplicationObj()->MyApp_Profile_Def(); }
        if ($this->Profile_Public_Is())
        {
            return array();
        }
        
        return
            array
            (
                "User" => $user[ "ID" ],
                "Profile" => $profile[ "N" ],
            );
    }
    
    //*
    //* Reads user permissions if necessary.
    //*

    function Permissions_User_Access_Has($item,$datas,$user=array())
    {
        $permissions=$this->PermissionsObj()->Permissions_User_Get();
        foreach ($permissions as $permission)
        {
            foreach ($datas as $data)
            {
                if
                    (
                        $permission[ $data ]=="0"
                        ||
                        $permission[ $data ]==$item[ $data ]
                    )
                {
                    return True;
                }
                elseif
                    (
                        $permission[ $data ]>"0"
                        ||
                        $permission[ $data ]!=$item[ $data ]
                    )
                {
                    return False;
                }
            }
        }

        return False;            
    }


}

?>