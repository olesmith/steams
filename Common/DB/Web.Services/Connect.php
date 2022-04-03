<?php

trait DB_Web_Services_Connect
{
    var $Tokens=array();
    
    //*
    //* Connects trying to generate token.
    //* 
    //* 

    function DB_Web_Services_ReConnect($ttl)
    {
        if (empty($this->_DB_Hash_[ "Link" ])) { return; }
        
        $time_elapsed=time()-$this->_DB_Hash_[ "Link" ][ "Generated" ];

        if ($time_elapsed>$ttl)
        {
            //print $this->_DB_Hash_[ "Link" ][ 'access_token' ]." --> ";
            $this->_DB_Hash_=$this->DB_Web_Services_Connect
            (
                 $this->_DB_Hash_
            );
            //print $this->_DB_Hash_[ "Link" ][ 'access_token' ]."\n";

            //exit();
        }
        /* else */
        /* { */
        /*     print "Reconnect ignored $time_elapsed\n"; */
        /* } */
        
    }
    
    //*
    //* Connects trying to generate token.
    //* 
    //* 

    function DB_Web_Services_Connect(&$dbhash)
    {
        //$link=curl_init();;
        $dbhash[ "Link" ]="cURL";

        //print "Connect";
        $result=$this->Curl_Do
        (
            "",
            $this->DB_Web_Services_Options_Connect()
        );

        $dbhash[ "Link" ]=json_decode($result,TRUE);
        $dbhash[ "Link" ][ 'Generated' ]=time();
        
        if (!empty($dbhash[ "Link" ][ 'access_token' ]))
        {
            //Add to status messages
            $this->ApplicationObj()->MyApp_Interface_Message_Add
            (
                $dbhash[ "Link" ][ 'access_token' ]
            );

            $this->DB_Web_Services_Reachable=True;
        }
        else
        {
            var_dump("Warning! Unable to connect to Web Services");
            $dbhash[ "Link" ]=NULL;
            
            $this->DB_Web_Services_Reachable=False;
        }

        return $dbhash;
    }
}

?>