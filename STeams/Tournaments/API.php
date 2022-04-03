<?php

include_once("API/Teams.php");
include_once("API/Matches.php");

trait Tournaments_API
{
    use
        Tournaments_API_Teams,
        Tournaments_API_Matches;
    
    //*
    //* 
    //*

    function Tournament_API_Make($tournament,$season,$force=False)
    {

        if ($tournament[ "API_Latency" ]<=0) { return False; }

        if ($tournament[ "Season" ]!=$season[ "ID" ])
        {
            return False;
        }
        
        //not updated
        $res=False;
        if
            (
                $force
                ||
                empty($tournament[ "API_Last" ])
                ||
                time()-$tournament[ "API_Last" ]>$tournament[ "API_Latency" ]
            )
        {
            //Update imediately to prevent concurrent updates
            $this->Sql_Update_Item_Value_Set
            (
                $tournament[ "ID" ],
                "API_Last",
                time()
            );
            
            $this->Tournament_API_Retrieve($tournament,$season);

            //updated
            $res=True;
        }

        $this->Tournament_API_Make_Teams($tournament,$season);
        $this->Tournament_API_Make_Matches($tournament,$season);
        
        return $res;
    }
    
    //*
    //* 
    //*

    function Tournament_API_Retrieve(&$tournament,$season)
    {
        $result=
            $this->Tournament_API_cURL($tournament);

        $tournament[ "API_Last" ]=time();
        $updatedatas=array("API_Last");
        
        if ($this->Tournament_API_Test($result))
        {
            $tournament[ "API_Result" ]=$result;
            $tournament[ "API_Status" ]=3;

            array_push($updatedatas,"API_Result","API_Status");

            $this->Tournament_API_Update($tournament);
        }
        else
        {
            $tournament[ "API_Status" ]=2;

            array_push($updatedatas,"API_Status");
        }
        
        $this->Sql_Update_Item_Values_Set($updatedatas,$tournament);
    }
    
    //*
    //* 
    //*

    function Tournament_API_Test($result)
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

    function Tournament_API_Update(&$tournament)
    {        
        $json=$tournament[ "API_Result" ];
        $updatedatas=array();
        $updatevalues=array();
        
        $keys=
            array
            (
                "Name" => "name",
                "Title" => "name",
                "API_ID" => "id",
                "Logo_URL" => "emblemUrl"
            );
        
        foreach ($keys as $dest => $src)
        {
            $tournament[ $dest ]="";
            if (!empty($json[ $src ])) { $tournament[ $dest ]=$json[ $src ]; }
        }
        
        if (!empty($tournament[ "ID" ]) && count($updatedatas))
        {
            $text=array();
            for ($n=0;$n<count($updatedatas);$n++)
            {
                array_push
                (
                    $text,
                    "\t".$updatedatas[ $n ].": ".$updatevalues[ $n ]
                );
            }
            
            $tournament[ "API_Digest" ]=join("\n",$text);
            array_push($updatedatas,"API_Digest");

            $this->Sql_Update_Item_Values_Set($updatedatas,$tournament);
        }        
    }
    
    //*
    //* 
    //*

    function Tournament_API_Date_Convert($date)
    {
        return preg_replace('/-/',"",$date);
    }
    
    //*
    //* 
    //*

    function Tournament_API_URL($tournament)
    {
        return
            join
            (
                "/",
                array
                (
                    $tournament[ "API_URL" ],
                    $tournament[ "API_ID" ]
                )
            );
    }
    
    //*
    //* 
    //*

    function Tournament_API_Auth($tournament=array())
    {
        if (empty($tournament))
        {
            $tournament=$this->Tournament();
        }
        
        return
            array
            (
                "x-auth-token: ".$tournament[ "API_Auth" ],
            );
    }
    
    //*
    //* 
    //*

    function Tournament_API_cURL($tournament)
    {
        $result=
            $this->APIsObj()->APIs_Curl_Exec
            (
                "Tournaments",
                $this->Tournament_API_URL($tournament),
                $this->Tournament_API_Auth($tournament),
                array
                (
                    "Tournament" => $tournament[ "ID" ],
                    "Season"     => $tournament[ "Season" ],
                )
            );
                
        $tournament[ "API_Count" ]++;
        $this->Sql_Update_Item_Values_Set
        (
            array("API_Count"),
            $tournament
        );
        
        return $result;
    }
   
}

?>