<?php

trait Tournaments_Teams_API
{
    //*
    //* 
    //*

    function Tournament_Teams_API_Update(&$tournament,$force=False)
    {
        $res=True;

        $nupdated=0;
        if
            (
                $force
                ||
                $this->TournamentsObj()->Tournament_API_Teams_Test
                (
                    $tournament[ "API_Teams_Result" ]
                )
            )
        {
            $hash=$this->Tournament_Teams_API_Hash();
            $json=json_decode($tournament[ "API_Teams_Result" ],True);
            
            foreach ($json[ "teams" ] as $jteam)
            {
                $nupdated+=
                    $this->Tournament_Team_API_Update
                    (
                        $hash,
                        $tournament,
                        $jteam
                    );
            }
        }

        if ($nupdated>0)
        {
            print
                $this->TimeStamp().
                ": ".
                count($json[ "teams" ]).
                " teams retrieved, ".
                $nupdated." updated. ".
                "Previous update: ".
                $this->TimeStamp($tournament[ "API_Teams_Last" ]).
                $this->BR();
        }
        
        return $nupdated;
    }
        
    //*
    //* 
    //*

    function Tournament_Team_API_Update($hash,$tournament,$jteam)
    {
        $team=
            $this->Tournament_Team_API_Locate
            (
                $tournament,$jteam
            );

        if (!empty($team))
        {
            $updatedatas=
                $this->Tournament_Team_API_Update_Values
                (
                    $hash,$tournament,
                    $jteam,$team
                );

            if (count($updatedatas)>0)
            {
                $team[ "API_Last" ]=time();
                array_push($updatedatas,"API_Last");

                $json=json_encode($jteam,JSON_PRETTY_PRINT);

                $data="API_Result";
                $value=
                    $this->MyHash_Key_Get_Save($team,$data);

                $res=False;
                if ($value!=$json)
                {
                    $team[ $data ]=preg_replace('/\'/',"&#39;",$json);
                    $res=True;

                    array_push($updatedatas,$data);
                }
                
                $this->TeamsObj()->Sql_Update_Item_Values_Set
                (
                    $updatedatas,
                    $team
                );

                return 1;
            }
            
        }

        return 0;
    }
    
    //*
    //* 
    //*

    function Tournament_Team_API_Locate($tournament,$jteam)
    {
        $team=
            $this->TeamsObj()->Sql_Select_Hash
            (
                array("API_ID" => $jteam[ "id" ])
            );
        
        if (!empty($team))
        {
            $team[ "Hash" ]=
                $this->Sql_Select_Hash
                (
                    array("Team" => $team[ "ID" ])
                );
        }
            

        return $team;
    }
    
    //*
    //* 
    //*

    function Tournament_Teams_API_Hash()
    {
        if (empty($this->TeamsObj()))
        {
            return array();
        }
        
        $hash=array();
        foreach (array_keys($this->TeamsObj()->ItemData()) as $data)
        {
            if (!empty($this->TeamsObj()->ItemData[ $data ][ "Key" ]))
            {
                $hash[
                    $this->TeamsObj()->ItemData[ $data ][ "Key" ]
                ]=$data;
            }
        }

        return $hash;
    }  
    //*
    //* 
    //*

    function Tournament_Team_API_Update_Values($hash,$tournament,$jteam,&$team)
    {
        $updatedatas=array();
        foreach ($hash as $src_key => $dest_key)
        {
            if
                (
                    $this->Tournament_Team_API_Update_Value
                    (
                        $src_key,$dest_key,
                        $tournament,$jteam,
                        $team
                    )
                )
            {
                array_push($updatedatas,$dest_key);
            }
        }

        return $updatedatas;
    }

    //*
    //* 
    //*

    function Tournament_Team_API_Update_Value($src_key,$dest_key,$tournament,$jteam,&$team)
    {
        $old_value="-";
        if (!empty($team[ $dest_key ]))
        {
            $old_value=$team[ $dest_key ];
        }

        $new_value=htmlentities($jteam[ $src_key ]);
        $updated=False;
        if
            (
                empty($old_value)
                ||
                $old_value!=$new_value
            )
        {
            if (!empty($new_value))
            {
                $updated=True;
                $team[ $dest_key ]=$new_value;
            }
        }


        return $updated;
    }

}

?>