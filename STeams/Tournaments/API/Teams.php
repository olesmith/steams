<?php

trait Tournaments_API_Teams
{
    //*
    //* 
    //*

    function Tournament_API_Make_Teams($tournament,$season)
    {
        if ($tournament[ "API_Teams_Latency" ]<=0) { return False; }

        //not updated
        $res=False;
        if
            (
                empty($tournament[ "API_Teams_Last" ])
                ||
                time()-$tournament[ "API_Teams_Last" ]>$tournament[ "API_Teams_Latency" ]
            )
        {
            $this->Tournament_API_Teams_Retrieve($tournament,$season);

            //updated
            $res=True;
        }

        //for testing!!
        //$this->Tournament_API_Teams_Update($tournament);
        
        return $res;
    }
    
    //*
    //* 
    //*

    function Tournament_API_Teams_Retrieve(&$tournament,$season)
    {
        $result=
            $this->Tournament_API_Teams_cURL($tournament);

        $tournament[ "API_Teams_Last" ]=time();
        $updatedatas=array("API_Teams_Last");
        
        if ($this->Tournament_API_Teams_Test($result))
        {
            $tournament[ "API_Teams_Result" ]=$result;
            $tournament[ "API_Teams_Status" ]=3;

            array_push($updatedatas,"API_Teams_Result","API_Teams_Status");

            $this->Tournament_API_Teams_Update($tournament);
        }
        else
        {
            $tournament[ "API_Teams_Status" ]=2;

            array_push($updatedatas,"API_Teams_Status");
        }
        
        $this->Sql_Update_Item_Values_Set($updatedatas,$tournament);

    }
    
    //*
    //* 
    //*

    function Tournament_API_Teams_Test($result)
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

    function Tournament_API_Teams_Update(&$tournament)
    {        
        $result=$tournament[ "API_Teams_Result" ];
        
        $this->Tournament_TeamsObj()->Tournament_Teams_API_Update($tournament);        
    }
    
    //*
    //* 
    //*

    function Tournament_API_Teams_URL($tournament)
    {
        return
            join
            (
                "/",
                array
                (
                    $tournament[ "API_URL" ],
                    $tournament[ "API_ID" ],
                    $tournament[ "API_Teams_URL" ],
                )
            );
    }
    
    //*
    //* 
    //*

    function Tournament_API_Teams_cURL($tournament)
    {
        $result=
            $this->APIsObj()->APIs_Curl_Exec
            (
                "Teams",
                $this->Tournament_API_Teams_URL($tournament),
                $this->Tournament_API_Auth($tournament),
                array
                (
                    "Tournament" => $tournament[ "ID" ],
                    "Season"     => $tournament[ "Season" ],
                )
            );
                
        $tournament[ "API_Teams_Count" ]++;
        $this->Sql_Update_Item_Values_Set(array("API_Teams_Count"),$tournament);
        
        return $result;
    }
   
}

?>