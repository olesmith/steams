<?php


trait App_CLI_Matches
{  
    //*
    //* 
    //*

    function App_CLI_Matches($competition,$season_json,$our_season)
    {
        $year=
            preg_replace('/-.*/',"",$season_json[ "startDate" ]);
        
        $name=
            $this->Tournament("Name").
            " ".
            preg_replace('/-.*/',"",$season_json[ "startDate" ]);
        
        $matches_result=
            $this->MyApp_CLI_APIs_Get
            (
                $this->App_CLI_Matches_URL($competition,$season_json),
                $this->App_CLI_Matches_File($competition,$season_json),
                array(),
                $this->Tournament("API_Teams_Latency")
            );

        $matches_json=json_decode($matches_result,True);
        
        if (!empty($matches_json[ "matches" ]))
        {
            $matches_json=$matches_json[ "matches" ];
            
            $added=0;
            $n=1;
            foreach ($matches_json as $match_json)
            {
                $added+=
                    $this->App_CLI_Match
                    (
                        $competition,
                        $season_json,$our_season,
                        $match_json
                    );
            }

            print
                join
                (
                    "\t",
                    array
                    (
                        "",
                        count($matches_json)." matches",
                        $added." matches added",
                    )
                );
        }
        else { print "\tNo matches"; }            
    }
    
    //*
    //* 
    //*

    function App_CLI_Match($competition,$season_json,$our_season,$match_json)
    {
        $our_match=
            $this->Tournament_MatchesObj()->Sql_Select_Hash
            (
                array
                (
                    "API_ID" => $match_json[ "id" ],
                )
            );
        
        if (empty($our_match))
        {
            $our_match[ "API_ID" ]=$match_json[ "id" ];
            $our_match[ "Tournament" ]=$this->Tournament("ID");
            $our_match[ "Season" ]=$our_season[ "ID" ];

            if
                (
                    $match_json[ 'homeTeam' ][ 'id' ]==NULL
                    ||
                    $match_json[ 'awayTeam' ][ 'id' ]==NULL
                )
            {
                return 0;
            }

            $home=
                $this->TeamsObj()->Sql_Select_Hash
                (
                    array
                    (
                        "API_ID" => $match_json[ 'homeTeam' ][ 'id' ],
                    ),
                    array("ID","Name_UK")
                );
            
            $away=
                $this->TeamsObj()->Sql_Select_Hash
                (
                    array
                    (
                        "API_ID" => $match_json[ 'awayTeam' ][ 'id' ],
                    ),
                    array("ID","Name_UK")
                );

            if (empty($home))
            {
                $home=
                    $this->App_CLI_Team_JSON_Get
                    (
                        $competition,$season_json,$our_season,
                        $match_json[ 'homeTeam' ][ 'id' ]
                    );
            }
            
            if (empty($away))
            {
                $away=
                    $this->App_CLI_Team_JSON_Get
                    (
                        $competition,$season_json,$our_season,
                        $match_json[ 'awayTeam' ][ 'id' ]
                    );
            }

            if (empty($home) || empty($away))
            {
                return 0;
            }

            $our_match[ "Team1" ]=$home[ "ID" ];
            $our_match[ "Team2" ]=$away[ "ID" ];

            $this->Tournament_MatchesObj()->Tournament_Match_API_Update_Values
            (
                $this->Tournament_MatchesObj()->Tournament_Matches_API_Hash(),
                $this->Tournament(),
                $match_json,
                $our_match,
                $our_season //updated
            );
                
            print
                "\n".
                join
                (
                    "\t",
                    array
                    (
                        "",
                        "Match not found: ",
                        $match_json[ "id" ]." - adding",
                        $home[ "Name_UK" ]."-".$away[ "Name_UK" ],
                    )
                ).
                "";

            var_dump($match_json[ 'awayTeam' ][ 'id' ]==NULL);
            //exit();
            $this->Tournament_MatchesObj()->Sql_Insert_Item
            (
                $our_match
            );
            return 1;
        }
        

        $our_match=
            $this->Tournament_MatchesObj()->PostProcess
            (
                $our_match,
                $force=True
            );
        

        return 0;
    }
    
    //*
    //* 
    //*

    function App_CLI_Matches_URL($competition,$season)
    {
        return
            $this->MyApp_CLI_APIs_URL_Base().
            $competition[ "id" ].
            "/matches".
            "?season=".
            preg_replace('/-.*/',"",$season[ "startDate" ]).
            "";

    }

    //*
    //* 
    //*

    function App_CLI_Matches_File($competition,$season)
    {
        return
            "Competitions.".
            $this->MyApp_CLI_APIs_File_Base($competition).
            ".".
            "Matches.".
            preg_replace('/-.*/',"",$season[ "startDate" ]).
            ".json";
    }
}
