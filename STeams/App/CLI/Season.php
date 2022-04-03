<?php


trait App_CLI_Season
{
    //*
    //* 
    //*

    function App_CLI_API_Competition_Season($competition,$season_json)
    {
        print
            join
            (
                "\t",
                array
                (
                    "",
                    $season_json[ 'id' ],
                    preg_replace('/-.*/',"",$season_json[ "startDate" ]),
                )
            ).
            "";

        $this->Tournament_SeasonsObj()->Sql_Table_Structure_Updated=False;
        $this->Tournament_SeasonsObj()->Sql_Table_Structure_Update();

        $where=
            array
            (
                "Tournament" => $this->Tournament("ID"),
                "API_ID" => $season_json[ "id" ],
            );
        
        $our_season=
            $this->Tournament_SeasonsObj()->Sql_Select_Hash
            (
                $where
            );

        

        if (empty($our_season))
        {
            $our_season=$where;
            
            $our_season=
                $this->Tournament_SeasonsObj()->Sql_Insert_Item
                (
                    $our_season
                );
        }

        $our_season=
            $this->Tournament_SeasonsObj()->Sql_Select_Hash
            (
                $where
            );

        $year=
            preg_replace('/-.*/',"",$season_json[ "startDate" ]);
        
        $name=
            $this->Tournament("Name").
            " ".
            preg_replace('/-.*/',"",$season_json[ "startDate" ]);
        
        $our_season=
            array_merge
            (
                $our_season,
                array
                (
                    "StartDate" => preg_replace
                    (
                        '/-/',"",
                        $season_json[ "startDate" ]
                    ),
                    "EndDate"   => preg_replace
                    (
                        '/-/',"",
                        $season_json[ "endDate" ]
                    ),
                    "Year" => $year,
                    "Name" => $name,
                    "API_Result" => json_encode($season_json,True),
                )
            );

        $this->Tournament_SeasonsObj()->Sql_Update_Item_Values_Set
        (
            array("StartDate","EndDate","Year","Name","API_Result"),
            $our_season
        );

        $this->App_CLI_Teams
        (
            $competition,$season_json,
            $our_season
        );

        $this->App_CLI_Matches
        (
            $competition,$season_json,
            $our_season
        );

        $this->App_CLI_Groups
        (
            $competition,$season_json,
            $our_season
        );
        $this->App_CLI_Rounds
        (
            $competition,$season_json,
            $our_season
        );

        $where=
            array
            (
                "Tournament" => $this->Tournament("ID"),
                "Season" => $our_season[ "ID" ],
            );
        
        print
            join
            (
                "\t",
                array
                (
                    "",
                    "Teams: ".
                    $this->Tournament_TeamsObj()->Sql_Select_NHashes($where),
                    "Matches: ".
                    $this->Tournament_MatchesObj()->Sql_Select_NHashes($where),
                    "Rounds: ".
                    $this->Tournament_RoundsObj()->Sql_Select_NHashes($where),
                    "Groups: ".
                    $this->Tournament_GroupsObj()->Sql_Select_NHashes($where),
                )
            ).
            "\n";
    }
}


?>