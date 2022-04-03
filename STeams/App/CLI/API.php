<?php


trait App_CLI_API
{
        /* $ids= */
        /*     array */
        /*     ( */
        /*         "2001",//Champions */
        /*         "2018",//euro */
        /*         "2013",//brasA */
        /*         "2016",//Championship, UK 2nd */
        /*         "2021",//Premier League UK */
        /*         "2015",//Ligue 1 FRA */
        /*         "2002",//Bundesliga GER */
        /*         "2019",//Serie A ITA */
        /*         "2003",//Eredivisie HOL */
        /*         "2017",//Primeira Liga POR */
        /*         "2152",//Copa Libertadores */
        /*         "2014",//Primera Division ESP */
        /*         "2000",//FIFA World Cup */
        /*     ); */

    
    //*
    //* Runs CLI commands.
    //*

    function App_CLI_API_Competitions($args)
    {
        print "API [T=tour_api_id [S=season_year]]\n\n";
        
        $result=
            $this->MyApp_CLI_APIs_Get
            (
                $this->MyApp_CLI_APIs_URL_Base(),
                "Competitions.json"
            );

        $competitions=json_decode($result,True);
        $competitions=$competitions[ "competitions" ];

        $competition_ids=array();
        foreach ($args as $arg)
        {
            if (preg_match('/T=(\d+)/',$arg,$match) && !empty($match[1]))
            {
                array_push($competition_ids,$match[1]);
            }
        }

        $n=0;
        foreach ($competitions as $competition)
        {
            $n++;
            if ($competition[ "plan" ]=="TIER_ONE")
            {
                print
                    join
                    (
                        "\t",
                        array
                        (
                            $n,
                            $competition["id"],
                            $competition["plan"],
                            $competition["name"]
                        )
                    ).
                    "\n";

                if
                    (
                        empty($competition_ids)
                        ||
                        preg_grep
                        (
                            '/'.$competition["id"].'/',
                            $competition_ids
                        )
                    )
                 {
                     $this->App_CLI_API_Competition($args,$competition);
                 }
            }
        }
    }


    //*
    //* 
    //*

    function App_CLI_API_Competition_Tables($args,$competition)
    {
        $created=False;
        foreach (array("Teams","Matches","Rounds","Groups") as $module)
        {
            $moduleobj="Tournament_".$module."Obj";
            $table=$this->$moduleobj()->SqlTableName();
            
            if (!$this->$moduleobj()->Sql_Table_Exists())
            {
                print "Creating table: ".$table."\n";
                
                $this->$moduleobj()->Sql_Table_Structure_Update();
                $created=True;
            }
        }

        if ($created)
        {
            print "Module tables created, exiting\n";
            exit();
        }
    }
    
    //*
    //* 
    //*

    function App_CLI_API_Competition($args,$competition)
    {
        array_shift($args);

        $this->TournamentsObj()->__Tournament__=
            $this->TournamentsObj()->Sql_Select_Hash
            (
                array
                (
                    "API_ID" => $competition[ "id" ],
                )
            );
        
        print
            $competition[ "name" ].": ".
            $competition[ "area" ][ "name" ].", ".
            $competition[ "id" ].", ".
            $competition[ "numberOfAvailableSeasons" ]." seasons\n";

        
        $result=
            $this->MyApp_CLI_APIs_Get
            (
                $this->App_CLI_Tournament_URL($competition),
                $this->App_CLI_Tournament_File($competition)
            );

        $competition=json_decode($result,True);
        $tournament=
            $this->TournamentsObj()->Sql_Select_Hash
            (
                array("API_ID" => $competition[ "id" ])
            );

        if (empty($tournament))
        {
            $tournament=
                array
                (
                    "API_Result" =>$competition,
                );
            
            $this->TournamentsObj()->Tournament_API_Update($tournament);
            
            print "Tournament ".$competition[ "id" ]." not found, inserting:\n";

            unset($tournament[ "API_Result" ]);
            print $this->TournamentsObj()->Sql_Insert_Item_Query($tournament);
            $this->TournamentsObj()->Sql_Insert_Item($tournament);

            $this->TournamentsObj()->__Tournament__=$tournament;
            foreach (array("Seasons","Matches","Teams","Rounds","Groups") as $module)
            {
                $moduleobj="Tournament_".$module."Obj";
                $this->$moduleobj()->Sql_Table_Structure_Exit=False;
                $this->$moduleobj()->Sql_Table_Structure_Update
                (
                    $datas=array(),$datadefs=array(),$maycreate=TRUE,$table="",
                    $exit_on_create=False
                );
                
            }
            exit();
        }

        $this->App_CLI_API_Competition_Tables($args,$competition);

        $today=$this->MyTime_Sort2Date();
        $year=preg_replace('/\d\d\d\d$/',"",$today);
        


        $current_season_json_id=$competition[ "currentSeason" ][ 'id' ];
        
        $current_season=
            $this->Tournament_SeasonsObj()->Sql_Select_Hash
            (
                array
                (
                    "Tournament" => $tournament[ "ID" ],
                    "API_ID" => $current_season_json_id,
                )
            );

        $seasons=$competition[ "seasons" ];

        $season_years=array();
        foreach ($args as $arg)
        {
            if (preg_match('/S=(\d+)/',$arg,$match) && !empty($match[1]))
            {
                array_push($season_years,$match[1]);
            }
        }

        if (is_array($competition[ "seasons" ]))
        {
            foreach ($seasons as $season)
            {
                $year=preg_replace('/-.*/',"",$season[ "startDate" ]);
                if
                    (
                        empty($season_years)
                        ||
                        preg_grep('/'.$year.'/',$season_years)
                    )
                {
                    $this->App_CLI_API_Competition_Season($competition,$season);
                }
            }
        }
    }
    

    //*
    //* 
    //*

    function App_CLI_Tournament_URL($competition)
    {
        return
            $this->MyApp_CLI_APIs_URL_Base().
            $competition[ "id" ];

    }

    //*
    //* 
    //*

    function App_CLI_Tournament_File($competition)
    {
        return
            join
            (
                ".",
                array
                (
                    "Competitions",
                    $this->MyApp_CLI_APIs_File_Base($competition),
                    "json"
                )
            );
    }


}


?>