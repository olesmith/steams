<?php

trait Tournaments_CLI_Match
{
    //*
    //* 
    //*

    function Tournament_CLI_Match_Update($tournament,$hash,$jmatch)
    {
        $jteam1_id=$jmatch[ "homeTeam" ][ "id" ];
        $jteam2_id=$jmatch[ "awayTeam" ][ "id" ];

        //var_dump($jmatch);
        $team1=
            $this->TeamsObj()->Sql_Select_Hash
            (
                array("API_ID" => $jteam1_id)
            );
        
        $team2=
            $this->TeamsObj()->Sql_Select_Hash
            (
                array("API_ID" => $jteam2_id)
            );

        $ok=True;
        if (empty($team1)) {var_dump("empty!!",$team1); $ok=False; }
                    
        if (empty($team2)) {var_dump("empty!!",$team2); $ok=False; }

        print $team1[ "Initials_PT" ]."-".$team2[ "Initials_PT" ].":";
        
        $match=array();
        if ($ok)
        {
            $match=
                $this->MatchesObj()->Sql_Select_Hash
                (
                    array
                    (
                        "Tournament" => $tournament[ "ID" ],
                        "Team1"      => $team1[ "ID" ],
                        "Team2"      => $team2[ "ID" ],
                    )
                );

            if (empty($match))
            {
                //Try to read symmetic match
                $match=
                    $this->MatchesObj()->Sql_Select_Hash
                    (
                        array
                        (
                            "Tournament" => $tournament[ "ID" ],
                            "Team1"      => $team2[ "ID" ],
                            "Team2"      => $team1[ "ID" ],
                        )
                    );
                
                if (!empty($match))
                {
                    $this->Tournament_CLI_Match_Swap
                    (
                        $tournament,$hash,$jmatch,
                        $match
                    );
                }

               
            }
            
            if (!empty($match))
            {
                $updatedatas=array();
                $updatevalues=array();
                foreach ($hash as $data => $keys)
                {
                    $value=$jmatch;
                    foreach ($keys as $key)
                    {
                        if (isset($value[ $key ]))
                        {
                            $value=$value[ $key ];
                        }
                    }

                    if (!is_array($value))
                    {
                        $old_value="-";
                        if (!empty($match[ $data ]))
                        {
                            $old_value=$match[ $data ];
                        }
                        
                        if
                            (
                                !isset($match[ $data ])
                                ||
                                $match[ $data ]!=$value
                            )
                        {
                            array_push($updatedatas,$data);
                            array_push($updatevalues,$old_value." => ".$value);
                            $match[ $data ]=$value;
                        }
                    }
                }

                $utcdate=$jmatch[ "utcDate" ];
                $comps=preg_split('/\s*T\s*/',$utcdate);
                if (count($comps)==2)
                {
                    $date=preg_replace('/\s*-\s*/',"",$comps[0]);
                    $hhmm=
                        preg_replace('/(\d\d):(\d\d).*/','\1\2',$comps[1]);

                    $data="Date";
                    if ($match[ $data ]!=$date)
                    {
                        array_push($updatedatas,$data);
                        array_push($updatevalues,$match[ $data ]." => ".$date);
                        $match[ $data ]=$date;
                    }
                    
                    $data="HHMM";
                    if ($match[ $data ]!=$hhmm)
                    {
                        array_push($updatedatas,$data);
                        array_push($updatevalues,$match[ $data ]." => ".$hhmm);
                        $match[ $data ]=$hhmm;
                    }
                }

                $group=$match[ "Tournament_Group" ];

                $match_day=$jmatch[ "matchday" ];

                $round=
                    $this->RoundsObj()->Sql_Select_Hash
                    (
                        array
                        (
                            "Tournament"       => $tournament[ "ID" ],
                            "Tournament_Group" => $group,
                            "Number" => $match_day,
                        )
                    );

                if (!empty($round))
                {
                    $data="Tournament_Round";
                    if ($match[ $data ]!=$round[ "ID" ])
                    {
                        array_push($updatedatas,$data);
                        array_push($updatevalues,$match[ $data ]." => ".$round[ "ID" ]);
                        $match[ $data ]=$round[ "ID" ];                        
                    }
                }

                $data="Status";
                
                $match_status=$jmatch[ "status" ];
                $status=$match[ $data ];
                if (preg_match('/SCHEDULED/i',$match_status))
                {
                    $status=1;
                }
                elseif (preg_match('/FINISHED/i',$match_status))
                {
                    $status=3;
                }
                else
                {
                    $status=2;
                }

                if ($match[ $data ]!=$status)
                {
                    array_push($updatedatas,$data);
                    array_push($updatevalues,$match[ $data ]." => ".$status);
                    $match[ $data ]=$status;   
                }

                if (count($updatedatas)>0)
                {
                    for ($n=0;$n<count($updatedatas);$n++)
                    {
                        print "\t".$updatedatas[ $n ].": ".$updatevalues[ $n ]."\n";
                    }

                    $match[ "Last_M" ]=time();
                    array_push($updatedatas,"Last_M");
                    echo
                        $this->MatchesObj()->Sql_Update_Item_Values_Set
                        (
                            $updatedatas,$match
                        )."\n";
                    print " Match found and updated\n";
                }
                else
                {
                    print " Match found, uptodate\n";
                }
                
            }
            else
            {
                print " Match **NOT** found\n";
            }
                    
        }
        else
        {
            print " Teams **NOT** found\n";
        }        
    }
    
    //*
    //* 
    //*

    function Tournament_CLI_Match_Swap($tournament,$hash,$jmatch,&$match)
    {
        print "Swapped match found, reversing Match Team IDs\n";
         
        if (!empty($match))
        {
            $team1_id=$match[ "Team1" ];
            $team2_id=$match[ "Team2" ];
            
            $this->MatchesObj()->Sql_Update_Item_Value_Set
            (
                $match[ "ID" ],
                "Team1",
                $match[ "Team2" ]
            );
                
            $this->MatchesObj()->Sql_Update_Item_Value_Set
            (
                $match[ "ID" ],
                "Team2",
                $match[ "Team1" ]
            );
                
            $match[ "Team1" ]=$team2_id;
            $match[ "Team2" ]=$team1_id;
        }
                
    }
}

?>