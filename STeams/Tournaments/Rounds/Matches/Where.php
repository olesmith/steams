<?php

trait Tournaments_Rounds_Matches_Where
{
    //*
    //* 
    //*

    function Tournament_Round_Matches_Where($tournament,$round,$group_id,$where=array())
    {
        return
            array_merge
            (
                $where,
                array
                (
                    "Tournament"       => $tournament[ "ID" ],
                    "Tournament_Group" => $group_id,
                    "Tournament_Round" => $round[ "ID" ],
                )
            );
    }    
}

?>