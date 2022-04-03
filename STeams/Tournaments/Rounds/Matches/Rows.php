<?php

trait Tournaments_Rounds_Matches_Rows
{
    //*
    //* 
    //*

    function Tournament_Round_Match_Rows($edit,$n,$tournament,$round,$group_id,$match)
    {
        return
            array
            (
                $this->Tournament_Round_Match_Row
                (
                    $edit,$n,
                    $tournament,$round,
                    $group_id,
                    $match
                ),
            );
    }

    //*
    //* 
    //*

    function Tournament_Round_Match_Row($edit,$n,$tournament,$round,$group_id,$match)
    {
        if (empty($match[ "Date" ]))
        {
            $match[ "Date" ]=$round[ "Date" ];
        }
        
        if (empty($match[ "HHMM" ]))
        {
            $match[ "HHMM" ]=$tournament[ "HHMM" ];
        }
        
        return
            array
            (
                $this->B($n),
                $this->Tournament_Round_Match_Cell
                (
                    $edit,
                    1,
                    $tournament,$round,$group_id,$match
                ),
                $this->Tournament_MatchesObj()->MyMod_Data_Field
                (
                    $edit,
                    $match,
                    "Goals1",
                    True,
                    $tabindex=2,
                    $this->Tournament_Round_Match_CGI_Name
                    (
                        "Goals1",$match
                    )
                ),
                $this->Tournament_MatchesObj()->MyMod_Data_Field
                (
                    $edit,
                    $match,
                    "Goals2",
                    True,
                    $tabindex=2,
                    $this->Tournament_Round_Match_CGI_Name
                    (
                        "Goals2",$match
                    )
                ),
                $this->Tournament_Round_Match_Cell
                (
                    $edit,
                    2,
                    $tournament,$round,$group_id,$match
                ),
                $this->Tournament_MatchesObj()->MyMod_Data_Field
                (
                    $edit,
                    $match,
                    "Date",
                    True,
                    $tabindex=3,
                    $this->Tournament_Round_Match_CGI_Name
                    (
                        "Date",$match
                    )
                ),
                $this->Tournament_MatchesObj()->MyMod_Data_Field
                (
                    $edit,
                    $match,
                    "HHMM",
                    True,
                    $tabindex=3,
                    $this->Tournament_Round_Match_CGI_Name
                    (
                        "HHMM",$match
                    )
                ),
            );
    }
}

?>