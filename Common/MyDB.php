<?php

include_once("DB/Fetch.php");
include_once("DB/Method.php");
include_once("DB/MySql.php");
include_once("DB/MySqli.php");
include_once("DB/PDO.php");
include_once("DB/Web.Services.php");
include_once("DB/Query.php");

trait MyDB
{
    use
        DB_Fetch,
        DB_Method,
        DB_MySql,
        DB_MySqli,
        DB_PDO,
        DB_Web_Services,
        DB_Query;

    //*
    //* function DB_Init, Parameter list: 
    //*
    //* Initializes mailing, if no.
    //*

    function DB_Init()
    {
        if ($this->DB && empty($this->DBHash[ "Link" ]))
        {
            $this->DBHash();
        }
        else { die("No DBHash defined"); }
    }

    //*
    //* function DBHash, Parameter list: $key=""
    //*
    //* DBHash accessor. Reads once only.
    //*

    function DBHash($key="")
    {
        if (empty($this->ApplicationObj()->DBHash))
        {
            //Read DB definitions
            $this->ApplicationObj()->DBHash=
                $this->ReadPHPArray
                (
                    $this->MyApp_Setup_Path().
                    "/".
                    $this->DBHashFile
                );

            //Then connect - or die
            $this->ApplicationObj()->DB_Connect($this->ApplicationObj()->DBHash);
        }

        if (!empty($key)) { return $this->ApplicationObj()->DBHash[ $key ]; }
        else              { return $this->ApplicationObj()->DBHash; }
    }
    //*
    //* function DB_Connect, Parameter list: 
    //*
    //* Opens the DB, using the parameters in DBHash.
    //*

    function  DB_Connect(&$dbhash)
    {
        $dbhash=$this->DB_Method_Call("Connect",$dbhash);
        $this->DB_Select($dbhash);

        if (method_exists($this,"PostOpenDB"))
        {
            $this->PostOpenDB();
        }
    }

    //*
    //* function DB_Select, Parameter list: 
    //*
    //* Opens the DB, using the parameters in DBHash.
    //*

    function DB_Select(&$dbhash)
    {
        if ($this->DBHash("ServType")=='webservice')
        {
            return True;
        }

        if (!$this->Sql_DB_Exists($dbhash))
        {
            //$this->Sql_DB_Create($dbhash);
        }

        if (!$this->Sql_DB_Exists($dbhash))
        {
            $msg=
                "DB ".$dbhash[ "DB" ]." nonexistent or inaccessible\n".
                "DBs: ".join(", ",$this->Sql_DBs_Get())."\n";
            
            die($msg);
        }

        $res=$this->DB_Method_Call("Select",$dbhash);
        if (!$res)
        {
            $this->DoDie
            (
                "DB does not exist and unable to create<BR>\n",
                $dbhash
            );
        }

        return $res;
    }


    //*
    //* function DB_Close, Parameter list: 
    //*
    //* Opens the DB, using the parameters in DBHash.
    //*

    function  DB_Close()
    {
        $res=$this->DB_Method_Call("Close",$this->DBHash);

        $this->DBHash[ "Link" ]=NULL;
        return $res;
    }

    //*
    //* function DB_FreeResult, Parameter list: $result
    //*
    //* Frees $result.
    //*

    function  DB_FreeResult($result)
    {
        return $this->DB_Method_Call("FreeResult",$result);
    }

    
    //*
    //* function DB_Link, Parameter list: 
    //*
    //* Returns actual DB connection.
    //*

    function  DB_Link()
    {
        return $this->DBHash("Link");
    }
    
    //*
    //* function Sql_Dialect, Parameter list: 
    //*
    //* Returns SQL dialect, ie: mysql, pgsql, etc.
    //* 
    //* 

    function DB_Dialect()
    {
        return strtolower($this->DBHash("ServType"));
    }
    
    //*
    //* function Sql_MySql, Parameter list: 
    //*
    //* Returns true if we are mysql.
    //* 
    //* 

    function DB_MySql()
    {
        $res=FALSE;
        if (preg_match('/^mysql$/',$this->DBHash("ServType"))) { $res=TRUE; }

        return $res;
    }
    
    //*
    //* function Sql_PostGres, Parameter list: 
    //*
    //* Returns true if we are postgres.
    //* 
    //* 

    function DB_PostGres()
    {
        $res=FALSE;
        if (preg_match('/^pgsql$/',$this->DBHash("ServType"))) { $res=TRUE; }

        return $res;
    }
    
    //*
    //* The operator name for comparison: 
    //*

    function DB_Regexp_Operator()
    {
        $res="undef";
        if ($this->DB_MySql())
        {
            $res="REGEXP";
        }
        elseif ($this->DB_PostGres())
        {
            $res="SIMILAR TO";
            $res="LIKE";
        }

        return $res;
    }
}
?>