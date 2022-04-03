<?php

trait Pool_Bets_Round_Read
{
    //*
    //* 
    //*

    function Pool_Bets_Round_Read_Matches()
    {
        return
            $this->MatchesObj()->MyMod_Items_PostProcess
            (
                $this->MatchesObj()->Sql_Select_Hashes
                (
                    array
                    (
                        "Tournament"       => $this->Tournament("ID"),
                        "Tournament_Round" => $this->Round("ID"),
                    ),
                    array(),
                    "Date,HHMM,ID"
                ),
                True
            );
    }
}

?>