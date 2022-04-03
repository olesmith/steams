<?php

include_once("CLI/Team.php");
include_once("CLI/Teams.php");
include_once("CLI/Match.php");
include_once("CLI/Matches.php");

trait Tournaments_CLI
{
    use
        Tournaments_CLI_Team,
        Tournaments_CLI_Teams,
        Tournaments_CLI_Match,
        Tournaments_CLI_Matches;
    
    var $URL_Base="http://api.football-data.org/v2/competitions";
    var $Base="/usr/local/STeams/API/";
    
    //*
    //* 
    //*

    function Tournaments_CLI($args)
    {
        $tournaments=
            $this->Sql_Select_Hashes();

        foreach ($tournaments as $tournament)
        {
            $tour="Tournament ".$tournament[ "ID" ]." ".$tournament[ "Name" ]."\n";
            if (preg_grep('/^'.$tournament[ "ID" ].'$/',$args))
            {
                print "Processing ".$tour;
                $this->Tournament_CLI($args,$tournament);
            }
            else
            {
                print "Omitting ".$tour;
            }
        }
    }
    //* 
    //*

    function Tournament_CLI($args,$tournament)
    {
        if (!is_array($tournament))
        {
            $tournament=
                $this->Sql_Select_Hash
                (
                    array("ID" => $tournament)
                );
        }

        

        $this->TournamentsObj()->__Tournament__=$tournament;

        if (preg_grep('/^Tournament$/',$args))
        {
            print "Processing Tournament Data\n";
            $this->Tournament_CLI_Update($tournament);
        }
        else
        {
            print "Omitting Tournament Data\n";
        }
        
        $refresh=False;
        if (preg_grep('/^Teams/',$args))
        {
            print "Processing Teams Data\n";
            $this->Tournament_CLI_Teams_Update($tournament,$refresh);
        }
        else
        {
            print "Omitting Teams Data\n";
        }
        

        $refresh=False;
        if (preg_grep('/^Matches/',$args))
        {
            print "Processing Matches Data\n";
            $this->Tournament_CLI_Matches_Update($tournament,$refresh);
        }
        else
        {
            print "Omitting Matches Data\n";
        }
        
    }

    //*
    //* 
    //*

    function Tournament_CLI_Update($tournament,$refresh=False)
    {
        $file=$this->Tournament_CLI_File($tournament);
        
        $json=$this->Tournament_CLI_JSON($tournament,$file,$refresh);
       
        $updatedatas=array();
        $updatevalues=array();
        if (!empty($json[ "currentSeason" ]))
        {
            $base="currentSeason";
            $keys=
                array
                (
                    "startDate" => "StartDate",
                    "endDate" => "EndDate",
                );

            foreach ($keys as $src_key => $dest_key)
            {
                $date=
                    $this->Tournament_CLI_Date_Convert
                    (
                        $json[ $base ][ $src_key ]
                    );
            
                if ($tournament[ $dest_key ]!=$date)
                {
                    array_push($updatedatas,$dest_key);
                    array_push($updatevalues,$tournament[ $dest_key ]." -> ".$date);
                    $tournament[ $dest_key ]=$date;
                }
            }
        }

        if (count($updatedatas))
        {
            for ($n=0;$n<count($updatedatas);$n++)
            {
                print "\t".$updatedatas[ $n ].": ".$updatevalues[ $n ]."\n";
            }
            
            var_dump($updatedatas,$updatevalues);
            $this->Sql_Update_Item_Values_Set($updatedatas,$tournament);
        }
        //$this->JSON_Text($json);
        
    }
    
    //*
    //* 
    //*

    function Tournament_CLI_JSON($tournament,$file,$refresh)
    {
        $result=False;
        if ($refresh || !file_exists($file))
        {
            $this->Tournament_CLI_Refresh($tournament);
        }
        elseif (file_exists($file))
        {
            $result=join("\n",$this->MyFile_Read($file));
        }
        else
        {
            print "Unable to retrieve from API\n";
            return;
        }
        
        return json_decode($result,True);
    }
    
    //*
    //* 
    //*

    function Tournament_CLI_File($tournament,$part="")
    {
        return $this->Base."/".$part.$tournament[ "ID" ].".json";
    }
    
    //*
    //* 
    //*

    function Tournament_CLI_Date_Convert($date)
    {
        return preg_replace('/-/',"",$date);
    }
    
     //*
    //* 
    //*

    function Tournament_CLI_cURL($tournament,$url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,True);
        curl_setopt($ch, CURLOPT_POST,False);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt
        (
            $ch,
            CURLOPT_HTTPHEADER,
            $this->Tournament_API_Auth($tournament)
        );

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
    
    //*
    //* 
    //*

    function Tournament_CLI_Test($tournament,$result)
    {
        $res=False;
        $json=json_decode($result,TRUE);
        if (!empty($json[ "id" ]))
        {
            $res=True;
        }

        return $res;
    }
    
    //*
    //* 
    //*

    function Tournament_CLI_Refresh($tournament)
    {
        $file=$this->Tournament_CLI_File($tournament);
        print "Fetching ".$file.":";

        
        $url=$this->URL_Base."/".$tournament[ "API_ID" ];

        $result=
            $this->Tournament_CLI_cURL
            (
                $tournament,$url
            );

        if ($this->Tournament_CLI_Test($tournament,$result))
        {
            $this->MyFile_Write($file,$result);
            system("/bin/chown -R www-data:www-data ".$this->Base);
            print " success\n";
            
            return True;
        }
        
        print " done\n";

        return False;
    }
}

?>