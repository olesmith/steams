<?php

include_once("Common/Curl.php");

include_once("Web.Services/Connect.php");
include_once("Web.Services/Paging.php");
include_once("Web.Services/Options.php");
include_once("Web.Services/Fetch.php");
include_once("Web.Services/Keys.php");
include_once("Web.Services/Query.php");
include_once("Web.Services/Curl.php");
include_once("Web.Services/Where.php");

trait DB_Web_Services
{
    var $DB_Web_Services_Reachable=False;
    
    use
        Curl,
        DB_Web_Services_Connect,
        DB_Web_Services_Fetch,
        DB_Web_Services_Paging,
        DB_Web_Services_Keys,
        DB_Web_Services_Options,
        DB_Web_Services_Query,
        DB_Web_Services_Curl,
        DB_Web_Services_Where;
    
    //*
    //* Closes to db
    //* 
    //* 

    function DB_Web_Services_Close($dbhash)
    {
        $dbhash[ "Link" ]=NULL;
        unset($dbhash[ "Link" ]);
    }

    //*
    //* function DB_Web_Services_Select, Parameter list: $dbhash
    //*
    //* Selects DB: do nothing, simply return true.
    //* 
    //* 

    function DB_Web_Services_Select($dbhash)
    {
        return True;
    }

    /* //\* */
    /* //\* function DB_Web_Services_Exec, Parameter list: $query,$ignoreerror=FALSE */
    /* //\* */
    /* //\* Executes mysql_select_db, returns no of changes. */
    /* //\*  */
    /* //\*  */

    /* function DB_Web_Services_Exec($query,$ignoreerror=FALSE) */
    /* { */
        
    /*     return $result;  */
    /* } */
    
    //*
    //* 
    //* 

    function DB_Web_Services_Session_Token()
    {
        $link=$this->DBHash("Link");
        
        return $link[ 'access_token' ];
    }
   
    //*
    //* Frees $result.
    //* 

    function DB_Web_Services_FreeResult($result)
    {
        return $result=NULL;
    }

}

?>