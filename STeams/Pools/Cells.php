<?php

trait Pools_Cells
{
    //*
    //*
    //*

    function Pool_Cell_Public_URL($edit=0,$pool=array(),$data="")
    {
        if (empty($pool))
        {
            return "Public URL:";
        }      

        return
            $this->CGI_Script_Protocol().
            "://".
            $this->CGI_Server_Name().
            $this->CGI_Script_Path().
            "?".
            "Tournament=".$this->Pool("Tournament").
            "&".
            "Season=".$this->Pool("Season").
            "&".
            "Pool=".$this->Pool("ID").
            "&".
            //"ModuleName=Pools".
            //"&".
            "Action=Start".
            "&".
            "Login=1".
            "";
    }

    //*
    //*
    //*

    function Pool_Cell_Mobile_URL($edit=0,$pool=array(),$data="")
    {
        if (empty($pool))
        {
            return "Mobile URL:";
        }      
       

        return
            $this->Pool_Cell_Public_URL($edit,$pool,$data).
            "&".
            "Mobile=1".
            "";
    }

    //*
    //*
    //*

    function Pool_Cell_NParticipants($edit=0,$pool=array(),$data="")
    {
        if (empty($pool))
        {
            return $this->Pool_FriendsObj()->MyMod_ItemsName(":");
        }


        return
            $this->Pool_FriendsObj()->Sql_Select_NHashes
            (
                array
                (
                    "Pool" => $pool[ "ID" ],
                )
            );
    }
}

?>