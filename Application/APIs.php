<?php

include_once("APIs/Cells.php");

class Application_APIs extends Common
{
    use
        Application_API_Cells;
    
    //*
    //* Overrides SqlTableName, prepending period id.
    //* Calls ApplicationObj->SqlPeriodTableName.
    //*

    function SqlTableName($table="")
    {
        if (empty($table)) { $table="APIs"; }
        
        return $table;
    }

    
    //*
    //* Pre process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PreProcessItemData()
    {
        $this->Sort="CTime DESC";
        
        array_unshift
        (
            $this->ItemDataPaths,
            $this->ApplicationObj()->MyApp_Setup_Root().
            "/Application/System/APIs"
        );        
    }

    //*
    //* Runs right after module has finished initializing.
    //*

    function PostInit()
    {
    }

    
    //*
    //* 
    //*

    function APIs_Curl_Exec($type,$url,$auth,$api,$echo=False)
    {
        $ch = curl_init();
        
        if ($echo) { print "$type,Trying: ".$url.": "; }

        curl_setopt
        (
            $ch,
            CURLOPT_URL,
            $url
        );

        curl_setopt($ch, CURLOPT_RETURNTRANSFER,True);
        curl_setopt($ch, CURLOPT_POST,False);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        
        curl_setopt
        (
            $ch,
            CURLOPT_HTTPHEADER,
            $auth
        );

        $result = curl_exec($ch);
        curl_close($ch);
        if ($echo)
        {
            print
                "$type, Trying ".$url.": ".
                strlen($result)." bytes<BR>\n";
        }
        
        $api=
            array_merge
            (
                $api,
                array
                (
                    "Type"    => $type,
                    "Name"    => $type,
                    "URL"     => $url,
                    "Result"  => $result,
                    "Bytes"   => strlen($result),
                )
            );

        $this->Sql_Insert_Item($api);

        
        return $result;
    }

    
}

?>