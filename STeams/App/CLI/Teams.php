<?php


trait App_CLI_Teams
{
    //*
    //* 
    //*

    function App_CLI_Teams($competition,$season_json,$our_season)
    {
        $year=
            preg_replace('/-.*/',"",$season_json[ "startDate" ]);
        
        $name=
            $this->Tournament("Name").
            " ".
            preg_replace('/-.*/',"",$season_json[ "startDate" ]);
        
        $teams_result=
            $this->MyApp_CLI_APIs_Get
            (
                $this->App_CLI_Teams_URL($competition,$season_json),

                $this->App_CLI_Teams_File($competition,$season_json),

                array
                (
                    "season" => $year,
                )
            );

        $teams_json=json_decode($teams_result,True);
        if (!empty($teams_json[ "teams" ]))
        {
            $teams_json=$teams_json[ "teams" ];
            print
                join
                (
                    "\t",
                    array
                    (
                        "",
                        count($teams_json)." teams"
                    )
                );
            
            foreach ($teams_json as $team_json)
            {
                $this->App_CLI_Team
                (
                    $competition,
                    $season_json,$our_season,
                    $team_json
                );
            }
        }
    }

    //*
    //* 
    //*

    function App_CLI_Team($competition,$season_json,$our_season,$team_json)
    {
        $our_team=
            $this->TeamsObj()->Sql_Select_Hash
            (
                array("API_ID" => $team_json[ "id" ])
            );

        if (empty($our_team))
        {
            print "Team not found: ".$team_json[ "id" ]." - adding\n";

            $this->TeamsObj()->Team_API_Update($our_team,$team_json);

            $updatedatas=array();
            $this->MyApp_CLI_APIs_Foot_Ball_Team_Names_Take($our_team,$updatedatas);

            //var_dump($team[ 'id'],$our_team);
            $this->TeamsObj()->Sql_Insert_Item($our_team);
        }
        else
        {
            $where=
                array
                (
                    "Tournament" => $this->Tournament("ID"),
                    "Season"     => $our_season[ "ID" ],
                    "Team"       => $our_team[ "ID" ],
                );
            
            $tournament_team=
                $this->Tournament_TeamsObj()->Sql_Select_Hash
                (
                    $where
                );
            
            if (empty($tournament_team))
            {
                print "Tournament_Team not found: ".$our_team[ "ID" ]." - adding\n";

                $tournament_team=$where;

                print $this->Tournament_TeamsObj()->Sql_Insert_Item_Query
                (
                    $tournament_team
                ).
                "\n";
                
                $this->Tournament_TeamsObj()->Sql_Insert_Item
                (
                    $tournament_team
                );
            }
        }
    }

                
    //*
    //* 
    //*

    function MyApp_CLI_APIs_Foot_Ball_Team_Names_Take(&$item,&$updatedatas)
    {
        foreach (array("Name","Title","Initials") as $data)
        {
            foreach ($this->LanguagesObj()->Language_Keys() as $lang)
            {
                $rdata=$data."_".$lang;

                if
                    (
                        !empty($item[ $data ])
                        &&
                        empty($item[ $rdata ])
                    )
                {
                    $item[ $rdata  ]=$item[ $data  ];
                    array_push($updatedatas,$data);
                }
            }
        }
    }
    
    //*
    //* 
    //*

    function App_CLI_Teams_URL($competition,$season)
    {
        return
            $this->MyApp_CLI_APIs_URL_Base().
            $competition[ "id" ].
            "/teams".
            "?year=".
            preg_replace('/-.*/',"",$season[ "startDate" ]).
            "";

    }

    //*
    //* 
    //*

    function App_CLI_Teams_File($competition,$season)
    {
        return
            "Competitions.".
            $this->MyApp_CLI_APIs_File_Base($competition).
            ".".
            "Teams.".
            preg_replace('/-.*/',"",$season[ "startDate" ]).
            ".json";
    }


    //*
    //* 
    //*

    function App_CLI_Team_URL($json_id)
    {
        return
            $this->MyApp_CLI_APIs_URL().
            "teams/".$json_id;
    }

    //*
    //* 
    //*

    function App_CLI_Team_JSON_Get($competition,$season_json,$our_season,$json_id)
    {
        $our_team=
            $this->TeamsObj()->Sql_Select_Hash
            (
                array
                (
                    "API_ID" => $json_id,
                ),
                array("ID","Name_UK")
            );

        if (!empty($our_team))
        {
            return $our_team;
        }
        
        $result =
            $this->MyApp_CLI_APIs_cURL
            (
                $this->App_CLI_Team_URL($json_id)
            );

        $team_json=json_decode($result,True);

        $our_team=array();
        $this->TeamsObj()->Team_API_Update($our_team,$team_json);

        $this->TeamsObj()->Sql_Insert_Item($our_team);

        return $our_team;        
    }
}
