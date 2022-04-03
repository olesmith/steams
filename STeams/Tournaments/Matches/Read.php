<?php

trait Tournament_Matches_Read
{
    //*
    //* 
    //*

    function Tournament_Matches_Read($tournament)
    {
        $matches=
            $this->Sql_Select_Hashes
            (
                array("Tournament" => $tournament[ "ID" ]),
                array(),
                "Date,HHMM,ID"
            );
        
        $this->__Teams__=array();
        foreach (array_keys($tournament[ "Groups" ]) as $group_id)
        {
            $this->__Teams__[ $group_id ]=
                $this->TeamsObj()->Sql_Select_Hashes_ByID
                (
                    array
                    (
                        "ID" => $tournament[ "Groups" ][ $group_id ]
                    )
                );
            
        }

        return
            $this->MyHash_HashesList_2IDs
            (
                $matches,
                $key="Tournament_Group"
            );


        return $matches;
    }
    
}

?>