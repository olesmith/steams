<?php

trait Tournaments_API_Matches
{
    //*
    //* 
    //*

    function Tournament_API_Make_Matches($tournament)
    {
        if ($tournament[ "API_Matches_Latency" ]<=0) { return False; }

        //not updated
        $res=False;
        if
            (
                empty($tournament[ "API_Matches_Last" ])
                ||
                time()-$tournament[ "API_Matches_Last" ]>
                $tournament[ "API_Matches_Latency" ]
            )
        {
            $this->Tournament_API_Matches_Retrieve($tournament);

            //updated
            $res=True;
        }

        //for testing!!
        //$this->Tournament_API_Matches_Update($tournament);
        
        return $res;
    }
    
    //*
    //* 
    //*

    function Tournament_API_Matches_Retrieve(&$tournament)
    {
        $result=
            $this->Tournament_API_Matches_cURL($tournament);

        $tournament[ "API_Matches_Last" ]=time();
        $updatedatas=array("API_Matches_Last");

        $res=False;
        if ($this->Tournament_API_Matches_Test($result))
        {
            $tournament[ "API_Matches_Result" ]=$result;
            $tournament[ "API_Matches_Status" ]=3;

            array_push
            (
                $updatedatas,
                "API_Matches_Result","API_Matches_Status"
            );

            $this->Tournament_API_Matches_Update($tournament);
            $res=True;
        }
        else
        {
            print "No matches received<BR>";
            $tournament[ "API_Matches_Status" ]=2;

            array_push($updatedatas,"API_Matches_Status");
            var_dump($result);
        }
        
        $this->Sql_Update_Item_Values_Set($updatedatas,$tournament);

        return $res;
    }
    
    //*
    //* 
    //*

    function Tournament_API_Matches_Test($result)
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

    function Tournament_API_Matches_Update(&$tournament)
    {        
        //$result=$tournament[ "API_Matches_Result" ];

        $this->MatchesObj()->Tournament_Matches_API_Update($tournament);        
    }
    
    //*
    //* 
    //*

    function Tournament_API_Matches_URL($tournament)
    {
        return
            join
            (
                "/",
                array
                (
                    $tournament[ "API_URL" ],
                    $tournament[ "API_ID" ],
                    $tournament[ "API_Matches_URL" ],
                )
            );
    }
    
    //*
    //* 
    //*

    function Tournament_API_Matches_cURL($tournament)
    {
        $result=
            $this->APIsObj()->APIs_Curl_Exec
            (
                "Matches",
                $this->Tournament_API_Matches_URL($tournament),
                $this->Tournament_API_Auth($tournament),
                array
                (
                    "Tournament" => $tournament[ "ID" ],
                    "Season"     => $tournament[ "Season" ],
                )
            );
        
        
        $tournament[ "API_Matches_Count" ]++;
        $this->Sql_Update_Item_Values_Set
        (
            array("API_Matches_Count"),
            $tournament
        );
        
        return $result;
    }
   
}

?>