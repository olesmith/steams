<?php


trait App_CLI_Rounds
{  
    //*
    //* 
    //*

    function App_CLI_Rounds($competition,$season_json,$our_season)
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
                    $this->App_CLI_Round_Match
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
                        $added." rounds added",
                    )
                );
        }
        else { print "\tNo matches"; }            
    }
    
    //*
    //* 
    //*

    function App_CLI_Round_Match($competition,$season_json,$our_season,$match_json)
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

        if (empty($our_match))
        {
            var_dump("Empty match, json",$match_json);
            exit();
        }

        $where=
            array
            (
                "Tournament" => $this->Tournament("ID"),
                "Season"     => $our_season[ "ID" ],
                "Number"     => $match_json[ 'matchday' ],
                //"Stage"      => $our_match[ 'Stage' ],
            );

        /* print */
        /*     $match_json[ 'matchday' ].": ". */
        /*     $match_json[ 'stage' ].": ". */
        /*     $our_match[ 'Stage' ]."\n"; */

        /* if ($match_json[ 'stage' ]=="LAST_16") */
        /* { */
        /*     // var_dump($match_json[ 'matchday' ]); */
        /* } */
        
        $round=
            $this->Tournament_RoundsObj()->Sql_Select_Hash
            (
                $where,
                array("ID")
            );

        //var_dump($round);
        if (empty($round))
        {
            $round=$where;
            $round[ "Tournament_Group" ]=0;
            /* if (!preg_match('/GROUP_STAGE/',$match_json[ 'stage' ])) */
            /* { */
            /*     $round[ "Tournament_Group" ]= */
            /*         $our_match[ "Tournament_Group" ]; */
            /* } */
            
            $this->Tournament_RoundsObj()->Sql_Insert_Item($round);
        }
        elseif
            (
                empty($our_match[ "Tournament_Round" ])
                ||
                $our_match[ "Tournament_Round" ]!=$round[ "ID" ]
            )
        {
            $our_match[ "Tournament_Round" ]=$round[ "ID" ];

            $this->Tournament_MatchesObj()->Sql_Update_Item_Value_Set
            (
                $our_match[ "ID" ],
                "Tournament_Round",
                $round[ "ID" ]
            );
        }


        if (!empty($round))
        {
            $round=
                $this->Tournament_RoundsObj()->Sql_Select_Hash
                (
                    array("ID" => $our_match[ "Tournament_Round" ]),
                    array("ID","Tournament_Group")
                );

            /* if ($our_match[ "Stage" ]>2) */
            /* { */
            /*     $this->Tournament_RoundsObj()->Sql_Update_Item_Value_Set */
            /*     ( */
            /*         $our_match[ "Tournament_Round" ], */
            /*         "Tournament_Group", */
            /*        " 0" */
            /*     ); */

            /* } */
            

            if (!empty($round) && $round[ "ID" ]!=$our_match[ "Tournament_Round" ])
            {
                $this->Tournament_MatchesObj()->Sql_Update_Item_Value_Set
                (
                    $our_match[ "ID" ],
                    "Tournament_Round",
                    $our_match[ "Tournament_Round" ]
                );
            }
        }
    }
}
