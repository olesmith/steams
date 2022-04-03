<?php


trait App_CLI_Groups
{  
    //*
    //* 
    //*

    function App_CLI_Groups($competition,$season_json,$our_season)
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
                $this->App_CLI_Matches_File($competition,$season_json)
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
                    $this->App_CLI_Group_Match
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

    function App_CLI_Group_Match($competition,$season_json,$our_season,$match_json)
    {
        if
            (
                $match_json[ 'homeTeam' ][ 'id' ]==NULL
                ||
                $match_json[ 'awayTeam' ][ 'id' ]==NULL
            )
        {
            return 0;
        }

        $our_match=
            $this->Tournament_MatchesObj()->Sql_Select_Hash
            (
                array
                (
                    "API_ID" => $match_json[ "id" ],
                )
            );

        $is_regular=False;
        $group_name=$match_json[ "group" ];
        if (preg_match('/REGULAR_SEASON/',$match_json[ "stage" ]))
        {
            $group_name="A";
            $is_regular=True;
        }
        
        $where=
            array
            (
                "Tournament" => $this->Tournament("ID"),
                "Season"     => $our_season[ "ID" ],
                "Name"       => $group_name,
            );
        
        $group=
            $this->Tournament_GroupsObj()->Sql_Select_Hash
            (
                $where,
                array("ID")
            );

        $key="Tournament_Group";

        if (empty($group))
        {
            if ($is_regular || !empty($group_name))
            {
                $group=$where;
                $this->Tournament_GroupsObj()->Sql_Insert_Item($group);
            }
        }

        //var_dump($is_regular,$match_json[ "stage" ]);
        if (empty($group_name))
        {
            $our_match[ "Tournament_Group" ]=0;
            $this->Tournament_MatchesObj()->Sql_Update_Item_Value_Set
            (
                $our_match[ "ID" ],
                "Tournament_Group",
                " 0"
            );
        }
        elseif (empty($our_match[ "Tournament_Group" ]) && !empty($group))
        {
            $our_match[ "Tournament_Group" ]=$group[ "ID" ];
            $this->Tournament_MatchesObj()->Sql_Update_Item_Value_Set
            (
                $our_match[ "ID" ],
                "Tournament_Group",
                $group[ "ID" ]
            );
        }

        //??
        if (!empty($our_match[ $key ]))
        {
            foreach (array("Team1","Team2") as $data)
            {
                $tournament_team=
                    $this->Tournament_TeamsObj()->Sql_Select_Hash
                    (
                        array
                        (
                            "Tournament" => $this->Tournament("ID"),
                            "Season"     => $our_season[ "ID" ],
                            "Team" => $our_match[ $data ],
                        ),
                        array("ID","Team",$key)
                    );

                if
                    (
                        !empty($tournament_team)
                        &&
                        (
                            empty($tournament_team[ $key ])
                            ||
                            (
                                $is_regular
                                &&
                                $tournament_team[ $key ]!=$our_match[ $key ]
                            )
                        )
                    )
                {
                    $tournament_team[ $key ]=$our_match[ $key ];
                    
                    $this->Tournament_TeamsObj()->Sql_Update_Item_Value_Set
                    (
                        $tournament_team[ "ID" ],
                        $key,
                        $our_match[ $key ]
                    );
                }
            }

         }
    }
}
