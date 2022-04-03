<?php
;

trait Tournaments_Teams_Matches
{
    //*
    //* 
    //*

    function Tournament_Team_Matches_Handle($team=array())
    {
        if (empty($team)) { $team=$this->ItemHash; }

        $this->Htmls_Echo
        (
            array
            (
                $this->Htmls_H
                (
                    1,
                    $this->Tournament_MatchesObj()->MyMod_ItemsName().
                    ", ".
                    $this->Team_Name($team[ "Team" ]).
                    ""
                ),
                $this->Tournament_MatchesObj()->MyMod_Items_Dynamic
                (
                    0,
                    $this->Tournament_Team_Matches_Get($team),
                    "Basic"
                ),
            )           
        );       
        
    }
    
    //*
    //* 
    //*

    function Tournament_Team_Matches_Get($team)
    {
        return
            $this->Tournament_MatchesObj()->MyMod_Items_PostProcess
            (
                $this->Tournament_MatchesObj()->Sql_Select_Hashes
                (
                    array
                    (
                        "ID" => $this->Tournament_Team_Matches_IDs($team)
                    ),
                    array(),                        
                    "Date,HHMM,ID"
                ),
                True
            );
    }
    
    //*
    //* 
    //*

    function Tournament_Team_Matches_IDs($team)
    {
        return
            $this->Tournament_MatchesObj()->Sql_Select_Unique_Col_Values
            (
                "ID",
                array
                (
                    "Tournament" => $this->Tournament("ID"),
                    "Season"     => $this->Season("ID"),
                    "__Team__" =>
                    "(".
                    join
                    (
                        " OR ",
                        array
                        (
                            $this->Sql_Table_Column_Name_Qualify("Team1").
                            "=".
                            $this->Sql_Table_Column_Value_Qualify($team[ "Team" ]),
                            
                            $this->Sql_Table_Column_Name_Qualify("Team2").
                            "=".
                            $this->Sql_Table_Column_Value_Qualify($team[ "Team" ]),
                        )
                    ).
                    ")",
                ),
                "Date,HHMM,ID"
            );
    }
}

?>