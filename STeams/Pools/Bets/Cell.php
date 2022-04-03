<?php

trait Pool_Bets_cell
{

//*
    //* Team icons as a span.
    //*

    function Pool_Bet_Cell_Match_Team_Icons($edit=0,$bet=array(),$data="")
    {
        if (empty($bet)) { return $this->TeamsObj()->MyMod_ItemsName(); }

        $match=
            $this->Pool_Bet_Match
            (
                $bet
            );

        return $this->MatchesObj()->Tournament_Match_Cell_Teams_Icons(0,$match);
    }
    
    //*
    //*
    //*

    function Pool_Bet_Calc_Date_HHMM(&$bet)
    {
    }

    
    //*
    //* Team icons as a span.
    //*

    function Pool_Bet_Cell_Match_Result($edit=0,$bet=array(),$data="")
    {
        if (empty($bet)) { return $this->MyLanguage_GetMessage("Result"); }

        $match=
            $this->Pool_Bet_Match
            (
                $bet
            );

        if ($match[ "Goals1" ]=="") { $match[ "Goals1" ]=" 0"; }
        if ($match[ "Goals2" ]=="") { $match[ "Goals2" ]=" 0"; }
        
        return
            array
            (
                $match[ "Goals1" ],
                "-",
                $match[ "Goals2" ],
                $this->BR(),
                $this->MatchesObj()->MyMod_Data_Fields_Show
                (
                    "Status",
                    $match
                )
            );        
    }
     //*
    //* Team icons as a span.
    //*

    function Pool_Bet_Cell_Match_Date_Time($edit=0,$bet=array(),$data="")
    {
        if (empty($bet)) { return $this->MatchesObj()->MyMod_Data_Title("Date"); }

        $match=
            $this->Pool_Bet_Match
            (
                $bet
            );

        return
            array
            (
                $this->MatchesObj()->MyMod_Data_Fields_Show
                (
                    "Date",
                    $match
                ),
                " ",
                preg_replace('/(\d\d)$/',"",$match[ "HHMM" ]).
                ":".
                preg_replace('/^(\d\d)/',"",$match[ "HHMM" ])                
            );        
    }
    
    //*
    //* Team icon.
    //*

    function Pool_Bet_Cell_Teams($edit=0,$bet=array(),$data="")
    {
        if (empty($bet)) { return $this->TeamsObj()->MyMod_ItemsName(); }
        
        return
            $this->MatchesObj()->Tournament_Match_Cell_Teams_Icons
            (
                $edit,
                $this->Pool_Bet_Match
                (
                    $bet,
                    array("ID","Team1","Team2")
                ),
                "Icon",$with_minus=True
            );  
    }
}

?>