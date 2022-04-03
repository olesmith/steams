<?php

trait Tournaments_CLI_Team
{
    //*
    //* 
    //*

    function Tournament_CLI_Team_Update( $hash,$tournament,$jteam,&$teams_not_found)
    {        
        $initials=$jteam[ "tla" ];

        print
            "Team ".
            $initials." -  ".$jteam[ "name" ].
            ": ".$jteam[ "id" ];

        $team=
            $this->Tournament_CLI_Team_Update_Locate
            (
                $jteam
            );

        if (empty($team))
        {
               array_push($teams_not_found,$jteam);
        }
        else
        {
            print " found\n";
            
            //Store for update comparison
            $old_team=$team;
            
            $updatedatas=array();


            $this->Tournament_CLI_Team_Update_Values
            (
                $hash,
                $tournament,
                $jteam,$team,
                $updatedatas
            );
            
            
            $this->Tournament_CLI_Team_Update_SVG
            (
                $tournament,$jteam,
                $team,
                $updatedatas
            );
                    
            if (count($updatedatas)>0)
            {
                $this->Tournament_CLI_Team_Update_Show
                (
                    $old_team,$team,
                    $updatedatas
                );
                
                $team[ "Last_M" ]=time();
                array_push($updatedatas,"Last_M");
                
                echo
                    $this->TeamsObj()->Sql_Update_Item_Values_Set
                    (
                        $updatedatas,$team
                    ).
                    "\n";
            }
        }
    }
    
    //*
    //* 
    //*

    function Tournament_CLI_Team_Update_Locate($jteam)
    {
        $initials=$jteam[ "tla" ];

        print
            "Team ".
            $initials." -  ".$jteam[ "name" ].
            ": ".$jteam[ "id" ];

        $team=array();
        if (!empty($initials))
        {
            $team=
                $this->TeamsObj()->Sql_Select_Hash
                (
                    array("Initials_UK" => $initials)
                );
        }

        //Try to read team via stored id.
        if (empty($team))
        {
            if (!empty($jteam[ "id" ]))
            {
                $team=
                    $this->TeamsObj()->Sql_Select_Hash
                    (
                        array("API_ID" => $jteam[ "id" ])
                    );
            }

            if (empty($team))
            {
                print " **NOT** found\n";
            }
        }

        return $team;
    }
    
    //*
    //* 
    //*

    function Tournament_CLI_Team_Update_Show($old_team,$team,$updatedatas)
    {
        for ($n=0;$n<count($updatedatas);$n++)
        {
            $data=$updatedatas[ $n ];
            echo
                "\t".$data.": ".
                $old_team[ $data ].
                " => ".                        
                $team[ $data ].
                "\n";
        }
    }
    
    //*
    //* 
    //*

    function Tournament_CLI_Team_Update_Values($hash,$tournament,$jteam,&$team,&$updatedatas)
    {
        foreach ($hash as $src_key => $dest_key)
        {
            $this->Tournament_CLI_Team_Update_Value
            (
                $src_key,$dest_key,
                $tournament,$jteam,
                $team,
                $updatedatas
            );
        }
    }

    //*
    //* 
    //*

    function Tournament_CLI_Team_Update_Value($src_key,$dest_key,$tournament,$jteam,&$team,&$updatedatas)
    {
        $old_value="-";
        if (!empty($team[ $dest_key ]))
        {
            $old_value=$team[ $dest_key ];
        }

        $new_value=htmlentities($jteam[ $src_key ]);
        if
            (
                empty($old_value)
                ||
                $old_value!=$new_value
            )
        {
            if (!empty($new_value))
            {
                array_push($updatedatas,$dest_key);
                $team[ $dest_key ]=$new_value;
            }
        }
    }

    //*
    //* 
    //*

    function Tournament_CLI_Team_Update_SVG($tournament,$jteam,&$team,&$updatedatas)
    {
        $url=$jteam[ "crestUrl" ];

        $rfile=
            $this->TeamsObj()->MyMod_Data_Upload_Path().
            "/".
            "SVG_".$team[ "ID" ].".svg";
        $file=
            "/usr/local/STeams/".$rfile;

        print "SVG: ".$file."\n".$team[ "SVG" ];
        
        if (file_exists($file))
        {
            print " exists\n";
            
            if ($team[ "SVG" ]!=$rfile)
            {
                print $team[ "SVG" ]." => ".$rfile."\n";
                $team[ "SVG" ]=$rfile;
                array_push($updatedatas,"SVG");
            }

            $origname=basename($rfile);
            if ($team[ "SVG_OrigName" ]!=$origname)
            {
                print $team[ "SVG_OrigName" ]." => ".$origname."\n";
                $team[ "SVG_OrigName" ]=$origname;
                array_push($updatedatas,"SVG_OrigName");
            }
        }
        else
        {
            print " trying to download\n";
            $this->Curl_DownLoad($url,$file);

            if
                (
                    empty($team[ "SVG" ])
                    ||
                    $team[ "SVG" ]!=$file
                )
            {
                $team[ "SVG" ]=$rfile;
                $team[ "SVG_OrigName" ]=basename($rfile);
                array_push($updatedatas,"SVG","SVG_OrigName");
            }
        }

        return $updatedatas;
    }
}

?>