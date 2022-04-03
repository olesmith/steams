<?php

trait Tournaments_CLI_Matches
{
    //*
    //* 
    //*

    function Tournament_CLI_Matches_Update($tournament,$refresh=False)
    {
        $this->MatchesObj()->ItemData();
        $this->Sql_Table_Structure_Update();

        if ($this->Sql_Table_Structure_Updated)
        {
            print "SQL Table Structure Updated, please rerun\n";
        }
        
        $json=
            $this->Tournament_CLI_Matches_JSON
            (
                $tournament,
                $this->Tournament_CLI_File($tournament,"Matches-"),
                $refresh
            );

        if (!empty($json[ "matches" ]))
        {
            $datas=$this->MatchesObj()->ItemData();

            $hash=array();
            foreach (array_keys($this->MatchesObj()->ItemData) as $data)
            {
                if (!empty($this->MatchesObj()->ItemData[ $data ][ "Key" ]))
                {
                    $hash[ $data ]=$this->MatchesObj()->ItemData[ $data ][ "Key" ];
                }
            }

            $lmatch=array();
            foreach ($json[ "matches" ] as $jmatch)
            {
                $this->Tournament_CLI_Match_Update($tournament,$hash,$jmatch);
                //var_dump($jmatch);

                $lmatch=$jmatch;
            }

            print $this->JSON_Text($lmatch);
        }
    }

    //*
    //* 
    //*

    function Tournament_CLI_Matches_JSON($tournament,$file,$refresh)
    {
        $result=False;

        if ($refresh || !file_exists($file))
        {
            print "Matches updated to ".$file."\n";
            $result=$this->Tournament_CLI_Matches_Refresh($tournament);
        }
        elseif (file_exists($file))
        {
            $result=join("\n",$this->MyFile_Read($file));
            print "Matches read from ".$file."\n";
        }
        else
        {
            print "Unable to retrieve Matches from API\n";
            return;
        }
        
        return json_decode($result,True);
    }
    
    
    //*
    //* 
    //*

    function Tournament_CLI_Matches_Test($tournament,$result)
    {
        $res=False;
        $json=json_decode($result,TRUE);
        if (!empty($json[ "matches" ]))
        {
            $res=True;
        }

        return $res;
    }
    
    //*
    //* 
    //*

    function Tournament_CLI_Matches_Refresh($tournament)
    {
        $file=$this->Tournament_CLI_File($tournament,"Matches-");
        print "Fetching teams to file ".$file.":";

        
        $url=$this->URL_Base."/".$tournament[ "API_ID" ]."/matches";
        $result=
            $this->Tournament_CLI_cURL
            (
                $tournament,$url
            );

        //print $result;
        if ($this->Tournament_CLI_Matches_Test($tournament,$result))
        {
        
            $this->MyFile_Write($file,$result);
            system("/bin/chown -R www-data:www-data ".$this->Base);
            print " success\n";

            return $result;
        }
        
        print " failure\n";
        return $result;
    }
}

?>