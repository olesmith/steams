<?php

trait Tournaments_Rounds_Matches_Titles
{
    //*
    //* 
    //*

    function Tournament_Round_Matches_Titles($edit,$tournament,$round)
    {
        return
            $this->B(array
            (
                "Nº",
                $this->Tournament_MatchesObj()->MyMod_Data_Title
                (
                    "Team1"
                ),
                $this->Tournament_MatchesObj()->MyMod_Data_Title
                (
                    "Goals1"
                ),
                $this->Tournament_MatchesObj()->MyMod_Data_Title
                (
                    "Goals2"
                ),
                $this->Tournament_MatchesObj()->MyMod_Data_Title
                (
                    "Team2"
                ),
                $this->Tournament_MatchesObj()->MyMod_Data_Title
                (
                    "Date"
                ),
                $this->Tournament_MatchesObj()->MyMod_Data_Title
                (
                    "HHMM"
                ),
            ));
    }
}

?>