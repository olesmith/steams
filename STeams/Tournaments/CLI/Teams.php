<?php

trait Tournaments_CLI_Teams
{
    //*
    //* 
    //*

    function Tournament_CLI_Teams_Update($tournament,$refresh=False)
    {
        $file=$this->Tournament_CLI_File($tournament,"Teams-");
        $json=$this->Tournament_CLI_Teams_JSON($tournament,$file,$refresh);
        $this->TeamsObj()->ItemData();
        $this->Sql_Table_Structure_Update();
        
        $teams_not_found=array();
        if (!empty($json[ "teams" ]))
        {
            $datas=$this->TeamsObj()->ItemData();

            $hash=array();
            foreach (array_keys($datas) as $data)
            {
                if (!empty($datas[ $data ][ "Key" ]))
                {
                    $hash[ $datas[ $data ][ "Key" ] ]=$data;
                }
            }

            foreach ($json[ "teams" ] as $jteam)
            {
                $this->Tournament_CLI_Team_Update
                (
                    $hash,
                    $tournament,
                    $jteam,
                    $teams_not_found
                );
            }
        }

        

        print count($teams_not_found)." Teams not found:\n";
        foreach ($teams_not_found as $jteam)
        {
            print
                "   Api_ID: ".$jteam[ "id" ].
                "\n".
                "   Name: ".$jteam[ "name" ].
                "\n\n";
        }

        $this->Tournament_CLI_Teams_Update_API_IDs
        (
            $tournament
        );

    }
    //*
    //* 
    //*

    function Tournament_CLI_Teams_JSON($tournament,$file,$refresh)
    {
        $result=False;

        if ($refresh || !file_exists($file))
        {
            $this->Tournament_CLI_Teams_Refresh($tournament);
        }
        elseif (file_exists($file))
        {
            $result=join("\n",$this->MyFile_Read($file));
            print "Teams read from ".$file."\n";
        }
        else
        {
            print "Unable to retrieve Teams from API\n";
            return;
        }
        
        return json_decode($result,True);
    }
    
    
   
    //*
    //* 
    //*

    function Tournament_CLI_Teams_Test($tournament,$result)
    {
        $res=False;
        $json=json_decode($result,TRUE);
        if (!empty($json[ "teams" ]))
        {
            $res=True;
        }

        return $res;
    }
    
    //*
    //* 
    //*

    function Tournament_CLI_Teams_Refresh($tournament)
    {
        $file=$this->Tournament_CLI_File($tournament,"Teams-");
        print "Fetching teams to file ".$file.":";

        
        $url=$this->URL_Base."/".$tournament[ "API_ID" ]."/teams";
        $result=
            $this->Tournament_CLI_cURL
            (
                $tournament,$url
            );

        //print $result;
        if ($this->Tournament_CLI_Teams_Test($tournament,$result))
        {
        
            $this->MyFile_Write($file,$result);
            system("/bin/chown -R www-data:www-data ".$this->Base);
            print " success\n";

            return $result;
        }
        
        print " failure\n";
        return $result;
    }
    
    //*
    //* 
    //*

    function Tournament_CLI_Teams_Update_API_IDs($tournament)
    {
        foreach
            (
                $this->Tournament_CLI_Teams_Update_Correct_IDs($tournament)
                as $api_id => $id
            )
         {
             $this->Tournament_CLI_Teams_Update_API_ID
             (
                 $tournament,
                 $api_id,$id
             );
         }
    }
    //*
    //* 
    //*

    function Tournament_CLI_Teams_Update_API_ID($tournament,$api_id,$id)
    {
        $team=
            $this->TeamsObj()->Sql_Select_Hash
            (
                array("ID" => $id)
            );

        if (empty($team))
        {
            print "Team ID=".$id." not found\n";
            return;
        }
        
        $data="API_ID";
        if ($team[ $data ]!=$api_id)
        {
            $team[ $data ]=$api_id;
            $this->TeamsObj()->Sql_Update_Item_Value_Set
            (
                $team[ "ID" ],"API_ID",$api_id
            );
        }
    }
    
    //*
    //* 
    //*

    function Tournament_CLI_Teams_Update_Correct_IDs($tournament)
    {
        $ids=
            array
            (
                1 => array
                (
                    760  => 17,//spain
                    770  => 13,//england
                    782  => 1,//denmark
                    788  => 4,//switz
                    790  => 10,//ukraine
                    8601 => 9,//holland
                    8873 => 24,//scotland
                ),
                2 => array
                (
                    1767 => 44,//gremio
                    1776 => 41,//sp
                    1778 => 39,//sport
                    1837 => 37,//ceara
                    1838 => 40,//america
                    3984 => 30,//fortaleza
                    4286 => 27,//bragantino
                    6684 => 38,//inter
                ),
            );
       
        return $ids[ $tournament[ "ID" ] ];
    }
}

?>