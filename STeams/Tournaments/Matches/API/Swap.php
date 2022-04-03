<?php

trait Tournament_Matches_API_Swap
{
    //*
    //* 
    //*

    function Tournament_Matches_API_Swap(&$match)
    {
        print "Swapped match found, reversing Match Team IDs\n";
         
        if (!empty($match))
        {
            $team1_id=$match[ "Team1" ];
            $team2_id=$match[ "Team2" ];
            
            $this->Sql_Update_Item_Value_Set
            (
                $match[ "ID" ],
                "Team1",
                $match[ "Team2" ]
            );
                
            $this->Sql_Update_Item_Value_Set
            (
                $match[ "ID" ],
                "Team2",
                $match[ "Team1" ]
            );
                
            $match[ "Team1" ]=$team2_id;
            $match[ "Team2" ]=$team1_id;
        }
    }
}

?>