<?php


class App_Permissions extends ModulesCommon
{
    var $Users_Permissions=array();
    var $Users_Languages=array();
    
    //*
    //* Reads user permissions if necessary.
    //*

    function Permissions_Friend_Get($user=array())
    {
        if (empty($user)) { $user=$this->LoginData("ID"); }
        
        if (is_array($user)) { $user=$user[ "ID" ]; }
                
        if (!isset($this->Users_Permissions[ $user ]))
        {
            $this->Users_Permissions[ $user ]=
                $this->Sql_Select_Hashes
                (
                    array
                    (
                        "User" => $user,
                    )
                );
        }

        return $this->Users_Permissions[ $user ];
    }
    
    //*
    //* Reads user permissions if necessary.
    //*

    function Permissions_Friend_Languages_Edit_Get($user=array())
    {
        if (empty($user)) { $user=$this->LoginData("ID"); }
        
        if (is_array($user)) { $user=$user[ "ID" ]; }

        
        if (!isset($this->Users_Permissions[ $user ]))
        {
            $this->Users_Languages[ $user ]=array();
            foreach
                (
                    $this->Permissions_Friend_Get()
                    as $perms
                )
            {
                foreach
                    (
                        array_keys($this->ApplicationObj()->Languages)
                        as $lang
                    )
                {
                    if
                        (
                            !empty($perms[ $lang ])
                            &&
                            intval($perms[ $lang ])>=2
                        )
                    {
                        $this->Users_Languages[ $user ][ $lang ]=True;
                    }
                }
            }
        }

        return $this->Users_Languages[ $user ];
    }
}

?>