<?php

include_once("Update/Values.php");
include_once("Update/Date.php");
include_once("Update/Round.php");
include_once("Update/Group.php");
include_once("Update/Status.php");
include_once("Update/Result.php");
include_once("Update/Stage.php");
include_once("Update/Duration.php");

trait Tournament_Matches_API_Update
{
    var $API_Debug=False;

    use
        Tournament_Matches_API_Update_Values,
        Tournament_Matches_API_Update_Date,
        Tournament_Matches_API_Update_Round,
        Tournament_Matches_API_Update_Group,
        Tournament_Matches_API_Update_Status,
        Tournament_Matches_API_Update_Result,
        Tournament_Matches_API_Update_Stage,
        Tournament_Matches_API_Update_Duration;
        
    
    //*
    //* 
    //*

    function Tournament_Matches_API_Update(&$tournament,$force=False)
    {
        $res=True;
        if
            (
                $force
                ||
                $this->TournamentsObj()->Tournament_API_Matches_Test
                (
                    $tournament[ "API_Matches_Result" ]
                )
            )
        {
            $hash=$this->Tournament_Matches_API_Hash();
            
            $json=json_decode($tournament[ "API_Matches_Result" ],True);
            
            $this->LogsObj()->LogEntry
            (
                $this->ModuleName.
                ", API Update: ".
                $tournament[ "Name" ]
            );

            $season=
                $this->Sql_Select_Hash
            (
                array("ID" => $tournament[ "Season" ]),
                array(),
                False,
                "Tournament_Seasons"
            );
            

            if (!empty($json[ "matches" ]))
            {
                $nupdated=0;
                foreach ($json[ "matches" ] as $jmatch)
                {
                    if
                        (
                            $this->Tournament_Match_API_Update
                            (
                                $hash,
                                $tournament,$season,
                                $jmatch
                            )
                        )
                    {
                        $nupdated++;
                    }  
                }

                print
                    $this->TimeStamp().
                    " ".
                    $this->Tournament("Name").
                    " Season ".
                    $this->Season("Year").
                    ": ".
                    count($json[ "matches" ]).
                    " matches retrieved, ".
                    $nupdated." updated. ".
                    "Previous update: ".
                    $this->TimeStamp($tournament[ "API_Matches_Last" ]).
                    $this->BR();
            }
            else
            {
                var_dump("No 'matches' in JSON",$json);
            }
        }
        
        return $res;
    }
        
    //*
    //* 
    //*

    function Tournament_Match_API_Update($hash,$tournament,$season,$jmatch)
    {
        /* $season_api=$jmatch[ "season" ][ "id" ]; */
            
        /* $season= */
        /*     $this->Sql_Select_Hash */
        /*     ( */
        /*         array("API_ID" => $season_api), */
        /*         array("ID"), */
        /*         False, */
        /*         "Tournament_Seasons" */
        /*     ); */

        $match=
            $this->Tournament_Match_API_Locate($tournament,$season,$jmatch);

        $res=False;
        if (!empty($match))
        {
            if (intval($match[ "API_Update" ])==1)
            {
                $res=
                    $this->Tournament_Match_API_Update_Values
                    (
                        $hash,$tournament,
                        $jmatch,
                        $match,
                        $season
                    );
            }
            //else { var_dump("Match ".$match[ "ID" ]." exempted"); }
        }
        else
        {
            $match=array();

            $team_1_api=$jmatch[ "homeTeam" ][ "id" ];
            $team_2_api=$jmatch[ "awayTeam" ][ "id" ];
            
            $team1=
                $this->TeamsObj()->Sql_Select_Hash
                (
                    array("API_ID" => $team_1_api),
                    array("ID")
                );
            
            $team2=
                $this->TeamsObj()->Sql_Select_Hash
                (
                    array("API_ID" => $team_2_api),
                    array("ID")
                ); 
            
            if
                (
                    !empty($team1)
                    &&
                    !empty($team2)
                    &&
                    !empty($season)
                )
            {
                $match=
                    array
                    (
                        "Tournament" => $tournament[ "ID" ],
                        "Season"     => $season[ "ID" ],
                        "Team1"      => $team1[ "ID" ],
                        "Team2"      => $team2[ "ID" ],
                        "API_ID"     => $jmatch[ "id" ],
                    );
                
                $this->Tournament_Match_API_Update_Values
                (
                    $hash,$tournament,$jmatch,$match,$season
                );

                
                if (!empty($match))
                {                    
                    $this->Sql_Insert_Item($match);
                    $res=True;
                }
            }
            else
            {
                //var_dump("No such teams",$jmatch);
            }
            //var_dump($match);

        }

        return $res;
    }
    
    //*
    //* 
    //*

    function Tournament_Match_API_Update_Values($hash,$tournament,$jmatch,&$match,$season)
    {
        $updatedatas=array();
        $updatevalues=array();
        
        $this->Tournament_Match_API_Update_Status
        (
            $tournament,$season,
            $jmatch,$match,
            $updatedatas,$updatevalues
        );

        $this->Tournament_Match_API_Update_Values_With_Hash
        (
            $tournament,$season,
            $jmatch,$match,$updatedatas,$updatevalues,
            $hash
        );

        $this->Tournament_Match_API_Update_Date
        (
            $tournament,$season,
            $jmatch,$match,
            $updatedatas,$updatevalues
        );
        
        $this->Tournament_Match_API_Update_Group
        (
            $tournament,$season,
            $jmatch,$match,
            $updatedatas,$updatevalues
        );
        
        $match_day=$jmatch[ "matchday" ];

        $this->Tournament_Match_API_Update_Round
        (
            $tournament,$season,
            $jmatch,$match,
            $updatedatas,$updatevalues
        );
        
        $this->Tournament_Match_API_Update_Stage
        (
            $tournament,$season,
            $jmatch,$match,
            $updatedatas,$updatevalues
        );
        

        
        $this->Tournament_Match_API_Update_Duration
        (
            $tournament,$jmatch,$match,
            $updatedatas,$updatevalues
        );
        
        if (count($updatedatas)>0)
        {
            $this->Tournament_Match_API_Update_Result
            (
                $tournament,$season,$jmatch,$match,
                $updatedatas,$updatevalues
            );    
        }


        
        $res=False;
        if
            (
                !empty($match[ "ID" ])
                &&
                count($updatedatas)>0
            )
        {
            $text=array();
            for ($n=0;$n<count($updatedatas);$n++)
            {
                if ($updatedatas[ $n ]=="API_Result") { continue; }
                
                array_push
                (
                    $text,
                    "\t".$updatedatas[ $n ].": ".$updatevalues[ $n ]
                );
            }

            $match[ "API_Digest" ]=join("\n",$text);
            array_push($updatedatas,"API_Digest");
            
            $match[ "API_Last" ]=time();
            array_push($updatedatas,"API_Last");

            if ($this->CGI_GET("Action")=="API")
            {
                print
                    "Match ".
                    $match[ "ID" ]." (".$match[ "API_ID" ]."), ".
                    $match[ "Name" ]." ".$match[ "Date" ]." ".$match[ "HHMM" ].
                    " Updated:".
                    $this->BR().
                    join($this->BR()."\n",$text).
                    $this->BR().
                    "";
                    
            }

            $this->Sql_Update_Item_Values_Set
            (
                $updatedatas,$match
            );


            $this->PostProcess($match,True);
            
            $res=True;
        }
        

        //print "Match ".$match[ "ID" ]." updated, ".$match[ "API_ID" ].": ".$res."<BR>";
        return $res;
    }
}

?>