<?php


trait DB_Web_Services_Options
{ 
    var $Curl_Queries=array();
    
    //*
    //* 
    //* 

    function DB_Web_Services_Options_Connect_Base64()
    {
        return
            base64_encode
            (
                join
                (
                    ":",
                    array
                    (
                        $this->DBHash("Key"),
                        $this->DBHash("Secret"),
                    )
                )
            );
    }
    
    //*
    //* Options for curl select.
    //* 

    function DB_Web_Services_Options_Connect($echo=False)
    {
        if ($echo)
        {
            print
                $this->DBHash("Mode").": ".
                $this->DBHash("Key")." - ".
                $this->DBHash("Secret")."\n".
                'Authorization: Basic '.
                $this->DB_Web_Services_Options_Connect_Base64().
                "\n\n";
        }
        
        return
            array
            (
                CURLOPT_POST => 1,
                CURLOPT_HEADER => 0,
                CURLOPT_URL => $this->DBHash("Host").'/token',
                CURLOPT_FRESH_CONNECT => 1,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_FORBID_REUSE => 0,
                CURLOPT_TIMEOUT => 100,
                
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,

                CURLOPT_POSTFIELDS =>
                join
                (
                    "&",
                    array
                    (
                        "grant_type=password",
                        "username=".$this->DBHash("User"),
                        "password=".$this->DBHash("Password"),
                    )
                ),
                CURLOPT_VERBOSE => 0,
                CURLOPT_HTTPHEADER => array
                (
                    'Authorization: Basic '.
                    $this->DB_Web_Services_Options_Connect_Base64().
                    ''
                ),
            );
    }
    
     
    //*
    //* Options for curl select.
    //* 

    function DB_Web_Services_Options_Assoc_List($query=array(),$limit=-1,$page=1)
    {
        $link=$this->DBHash("Link");
        array_push
        (
            $this->Curl_Queries,
            "Page: ".$page,
            $this->DB_Web_Services_Curl_Url($query,$limit,$page)
        );
        
        return
            array
            (
                CURLOPT_POST => 0,
                //CURLOPT_POSTFIELDS => http_build_query($query),
                
                CURLOPT_HEADER => 0,
                CURLOPT_URL => $this->DB_Web_Services_Curl_Url($query,$limit,$page),
                
                CURLOPT_FRESH_CONNECT => 1,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_FORBID_REUSE => 0,
                CURLOPT_TIMEOUT => 100,
                
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_VERBOSE => 0,
                CURLOPT_HTTPHEADER => array
                (
                    "accept: application/json",
                    "Authorization: Bearer ".$link[ 'access_token' ]
                ),
            );
    }

}

?>