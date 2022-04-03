<?php

trait Tournaments_Rounds_Matches_Read
{
    //*
    //* 
    //*

    function Tournament_Round_Matches_Read00000000000000($tournament,$round,$group_id)
    {
        var_dump("here");
        $tournament_team_ids=
            $this->Tournament_TeamsObj()->Sql_Select_Unique_Col_Values
            (
                "Team",
                array
                (
                    "Tournament" => $tournament[ "ID" ],
                    "Tournament_Group" => $group_id,
                ),
                "ID",
                $this->Tournament_TeamsObj()->Tournament_Sql_Table
                (
                    $this->Tournament_TeamsObj()->ModuleName,
                    $tournament
                )
            );

        if (empty($tournament_team_ids)) { return array(); }


        $this->__Teams_Group__=
            $this->MyHash_HashesList_2ID
            (
                $this->TeamsObj()->Sql_Select_Hashes
                (
                    array
                    (
                        "ID" => $tournament_team_ids,
                    ),
                    array(),
                    "Name_".$this->MyLanguage_Get()
                )
            );

        var_dump("here");
        $matches=
            $this->Tournament_MatchesObj()->Sql_Select_Hashes
            (
                $this->Tournament_Round_Matches_Where
                (
                    $tournament,$round,$group_id
                ),
                array(),
                "ID",
                False,
                $this->Tournament_MatchesObj()->Tournament_Sql_Table
                (
                    $this->Tournament_MatchesObj()->ModuleName,
                    $tournament
                )
            );

        foreach (arrray_keys($matches) as $id)
        {
            var_dump($matches[ $id ]);
        }

        return $matches;        
    }
    
    //*
    //* 
    //*

    function Tournament_Round_Matches_Disableds($tournament,$round,$group_id,$matches)
    {
        foreach ($matches as $match)
        {
            if (!empty($match[ "Team1" ]))
            {
                $this->__Teams_Group__
                    [ $match[ "Team1" ] ]
                    [ "Disabled" ]=True;
            }
            
            if (!empty($match[ "Team2" ]))
            {
                $this->__Teams_Group__
                    [ $match[ "Team2" ] ]
                    [ "Disabled" ]=True;
            }
        }

    }
 }

?>