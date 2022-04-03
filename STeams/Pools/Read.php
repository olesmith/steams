<?php

trait Pool_Read
{
    //*
    //* 
    //*

    function Pool_Read_Participants($pool=array())
    {
        if (empty($pool)) { $pool=$this->Pool(); }
        
        return
            $this->Pool_FriendsObj()->MyMod_Items_PostProcess
            (
                $this->Pool_FriendsObj()->Sql_Select_Hashes
                (
                    array
                    (
                        "Tournament" => $pool[ "Tournament" ],
                        "Pool" => $pool[ "ID" ],
                    ),
                    array(),
                    "Name"
                ),
                True
            );
    }
}

?>