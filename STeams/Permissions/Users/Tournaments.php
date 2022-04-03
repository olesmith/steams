<?php



trait Permissions_Users_Tournaments
{
    //*
    //* Find cities $user (or current) may access.
    //*

    function Permissions_User_Tournaments($user=array())
    {
        if (empty($user)) { $user=$this->LoginData(); }

        $key="Tournament";

        if ($this->Profile_Admin_Is() || $this->Profile_Is("Friend"))
        {
            return
                $this->TournamentsObj()->Sql_Select_Unique_Col_Values("ID");
        }
        
        if (empty($this->User_Permission_Tournaments[ $user[ "ID" ] ]))
        {
            $tournaments=
                $this->PermissionsObj()->Sql_Select_Unique_Col_Values
                (
                    "Tournament",
                    array
                    (
                        "User" => $user[ "ID" ],
                    )
                );
             $this->User_Permission_Tournaments[ $user[ "ID" ] ]=
                $this->MyHash_List_Unique($tournaments);
        }

        return $this->User_Permission_Tournaments[ $user[ "ID" ] ];            
    }
    
    //*
    //* Determine if $user has access to $city.
    //*

    function Permissions_User_Tournament_Access_Show($tournament_id,$user=array())
    {
        $res=True;

        if ($this->Profile_Is("Coordinator"))
        {
            $res=
                $this->Permissions_User_Tournament_Access_Edit
                (
                    $tournament_id,$user
                );
        }
        
        return $res;
    }

    
    //*
    //* Determine if $user has access to shows.
    //*

    function Permissions_User_Tournament_Access_Search($user=array())
    {
        $res=True;

        return $res;
    }

    //*
    //* Determine if $user has access to shows.
    //*

    function Permissions_User_Tournament_Access_EditList($user=array())
    {
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
    //* Determine if $user has access to $city.
    //*

    function Permissions_User_Tournament_Access_Edit($tournament_id,$user=array())
    {        
        $res=False;
        
        if ($this->Profile_Admin_Is())
        {
            $res=True;
        }
        elseif
            (
                $this->Profile_Is("Coordinator")
                &&
                in_array
                (
                    $tournament_id,
                    $this->Permissions_User_Tournaments($user)
                )
            )
        {
            $res=True;
        }

        return $res;
    }
    
}

?>