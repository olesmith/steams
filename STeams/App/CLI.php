<?php

include_once("Common/MyApp/CLI.php");
include_once("Common/JSON.php");

include_once("CLI/API.php");
include_once("CLI/Season.php");
include_once("CLI/Teams.php");
include_once("CLI/Matches.php");
include_once("CLI/Groups.php");
include_once("CLI/Rounds.php");
include_once("CLI/Friends.php");
include_once("CLI/Bets.php");

trait App_CLI
{
    use
        MyApp_CLI,JSON,
        App_CLI_API,
        App_CLI_Season,
        App_CLI_Teams,
        App_CLI_Matches,
        App_CLI_Groups,
        App_CLI_Rounds,
        App_CLI_Friends,
        App_CLI_Bets;

    var $__API_Fetch__=True;
    
    //*
    //* Runs CLI commands.
    //*

    function MyApp_CLI_Process($args)
    {
        print "MyApp_CLI_Process\n\n";

        $args=$_SERVER[ "argv" ];
        if (preg_grep('/API/',$args))
        {
            $this->App_CLI_API_Competitions($args);
        }
        
        if (preg_grep('/Read/',$args))
        {
            $this->MyApp_CLI_APIs_Foot_Ball_Competitions_Read($args);
        }

        array_shift($args);
        if (preg_grep('/Post/',$args))
        {
            array_shift($args);
            $this->MyApp_CLI_Post($args);
        }
        
    }

    //*
    //* Runs CLI commands.
    //*

    function MyApp_CLI_Print($args,$trailer="\n")
    {
        if (is_array($args)) { $args=join("\t",$args); }
        
        print $args.$trailer;
    }
    
    //*
    //* Runs CLI commands.
    //*

    function MyApp_CLI_Post($args)
    {
        $tournament_id=$args[0];
        $season_id=$args[1];
        
        $pool_id=1;
        $this->STeams_Tournament_Set($tournament_id);
        $this->STeams_Season_Set($season_id);
        $this->STeams_Pool_Set($pool_id);

        $this->MyApp_CLI_Print
        (
            $this->MyApp_CLI_Friends_Correct($tournament_id,$season_id,$pool_id)
        );
        
        $this->MyApp_CLI_Print
        (
            $this->MyApp_CLI_Bets_Correct($tournament_id,$season_id,$pool_id)
        );


        

        $pool_friends_data=
            array("ID","Tournament","Season","Pool","Friend","Goals1","Goals1","Points");

        $this->MyApp_CLI_Friends_Bets_Test
        (
            $tournament_id,$season_id,$pool_id,
            $pool_friends_data
        );

        
        $this->MyApp_CLI_Bets_Matches_POST($args,$tournament_id,$season_id);

        system("/bin/chown -R www-data:www-data ".$this->Log_Path);
    }

















    //*
    //* Run CLI command.
    //*

    function MyApp_CLI_APIs_cURL($url,$post=array())
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        if(!empty($post))
        {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }
            
        curl_setopt
        (
            $ch,
            CURLOPT_HTTPHEADER,
            array
            (
                "x-auth-token:  1386031a9b3a4f82b2530d13b17e9323",
            )
        );

          
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
    
    //*
    //* Path to files.
    //*

    function MyApp_CLI_APIs_Path()
    {
        return "/usr/local/STeams/API/";
    }
    
    //*
    //* Base name for data files.
    //*

    function MyApp_CLI_APIs_File_Base($competition)
    {
        return preg_replace('/\s+/',"_",$competition["name"]);
    }
    
    //*
    //* Path to files.
    //*

    function MyApp_CLI_APIs_URL()
    {
        return "http://api.football-data.org/v2/";
    }
    
    //*
    //* Path to files.
    //*

    function MyApp_CLI_APIs_URL_Base()
    {
        return
            $this->MyApp_CLI_APIs_URL().
            "competitions/";
    }
    
    //*
    //* Runs CLI and saves json result to file.
    //*

    function MyApp_CLI_APIs_Get($url,$file,$post=array(),$time_delta=0)
    {
        $file=
            $this->MyApp_CLI_APIs_Path().
            "/".$file;

        $force=False;

        if ($time_delta>0)
        {
            if (time()-filemtime($file)>$time_delta)
            {
                $force=True;
                //print "\n\n\n****Force download***\n\n\\n";
            }
        }
        
        $result="";
        if (!file_exists($file) || $force)
        {
            if ($this->__API_Fetch__)
            {
                print
                    "\nDownload\n".
                    join
                    (
                        "\t",
                        array
                        (
                            "",
                            $url,
                            "-->",
                            $file.": ",
                        )
                    );
        

                $result =$this->MyApp_CLI_APIs_cURL($url,$post);
                $json=json_decode($result,True);

                if (empty($json[ 'errorCode' ]))
                {
                    $result=json_encode($json,JSON_PRETTY_PRINT);
                    
                    $this->MyFile_Write($file,$result);
                    print "downloaded\n";

                }
                else
                {
                    if ($json[ 'errorCode' ]==403)
                    {
                        $this->MyFile_Write($file,"");                        
                    }
                    
                    print "Error Code: ".$json[ 'errorCode' ].": ".$json[ 'message' ]."\n";
                }
                
                sleep(10);
            }
            else
            {
                print "Fectching disabled\n";
            }
        }
        else
        {
            $result=join("\n",$this->MyFile_Read($file,$result));
        }

        return $result;
    }

    //*
    //* 
    //*

    function MyApp_CLI_APIs_Foot_Ball_Competitions_Read($args)
    {
        $result=
            $this->MyApp_CLI_APIs_Get
            (
                $this->MyApp_CLI_APIs_URL_Base(),
                "Competitions.json"
            );

        $competitions=json_decode($result,True);
        $competitions=$competitions[ "competitions" ];

        foreach ($competitions as $competition)
        {
            if ($competition[ "plan" ]=="TIER_ONE")
            {
                $this->MyApp_CLI_APIs_Foot_Ball_Competition_Read($competition);                
            }
        }
    }

    //*
    //* 
    //*

    function MyApp_CLI_APIs_Foot_Ball_Competition_Read($competition)
    {
        print
            $competition["id"]."\t".
            $competition["area"]["name"]."\t".
            $competition["name"]."\n";

        $file=
            "Competitions.".
            $this->MyApp_CLI_APIs_File_Base($competition).
            ".json";
        
        $result=
            $this->MyApp_CLI_APIs_Get
            (
                $this->MyApp_CLI_APIs_URL_Base().
                $competition[ "id" ],
                $file
            );
        $competition=json_decode($result,True);

        
        if (!empty($competition[ "seasons" ]))
        {
            foreach ($competition[ "seasons" ] as $season)
            {
                $this->MyApp_CLI_APIs_Foot_Ball_Competition_Read_Season($competition,$season);
            }
        }
    }
    
    //*
    //* 
    //*

    function MyApp_CLI_APIs_Foot_Ball_Competition_Read_Season($competition,$season)
    {
        print
            "\t".
            $season[ "id" ].": ".
            $season[ "startDate" ]." -> ".
            $season[ "endDate" ].
            "\n";

        $this->MyApp_CLI_APIs_Foot_Ball_Competition_Read_Season_Teams($competition,$season);
        $this->MyApp_CLI_APIs_Foot_Ball_Competition_Read_Season_Matches($competition,$season);
    }

    
    //*
    //* 
    //*

    function MyApp_CLI_APIs_Foot_Ball_Competition_Read_Season_Teams($competition,$season)
    {
        $year=
            preg_replace('/-.*/',"",$season[ "startDate" ]);
        
        $file=
            "Competitions.".
            $this->MyApp_CLI_APIs_File_Base($competition).
            ".".
            "Teams.".
            $year.
            ".json";
        
        $result=
            $this->MyApp_CLI_APIs_Get
            (
                $this->App_CLI_Teams_URL($competition,$season_json),
                
                $this->App_CLI_Teams_File($competition,$season_json),
                
                array
                (
                    "season" => $year,
                )
            );

        return json_decode($result,True);
    }

    
    //*
    //* 
    //*

    function MyApp_CLI_APIs_Foot_Ball_Competition_Read_Season_Matches($competition,$season)
    {
        $year=
            preg_replace('/-.*/',"",$season[ "startDate" ]);
        
        $file=
            "Competitions.".
            $this->MyApp_CLI_APIs_File_Base($competition).
            ".".
            "Matches.".
            $year.
            ".json";
        
        $result=
            $this->MyApp_CLI_APIs_Get
            (
                $this->MyApp_CLI_APIs_URL_Base().
                $competition[ "id" ].
                "/matches?season=".$year,
                $file
            );

        $matches=json_decode($result,True);               
    }


    
    //*
    //* 
    //*

    function MyApp_CLI_APIs_Foot_Ball_Group($base,$competition,$season_json,$our_season,$match_json)
    {
        if (empty($match_json[ "group" ])) { return; }

    }    
}


?>