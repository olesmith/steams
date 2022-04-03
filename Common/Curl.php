<?php

trait Curl
{
    var $Curl_Obj=NULL;
    var $Curl_Bin="/usr/bin/curl";
    
    //*
    //* Prepare and send query.
    //* 
    //* 

    function Curl_Error($curl,$options)
    {
        print
            "cURL Error:\n".
            curl_error($curl).
            "\n";
        
    }
    
    //*
    //* Run full curl command.
    //* 

    function Curl_Do($query,$options,$ignoreerror=FALSE)
    {
       
        $this->Curl_Obj=curl_init();
        
        $this->Curl_Options_Set($options);
        if( ! $result = curl_exec($this->Curl_Obj))
        {
            echo curl_error($this->Curl_Obj);
        }
        
        curl_close($this->Curl_Obj);
        return $result;
    }
    
    
    function Curl_POST($url,$query,$headers="")
    {
        $this->Curl_Obj=curl_init();
        $options=
            array
            (
                CURLOPT_POST => 1,
                CURLOPT_HEADER => 0,
                CURLOPT_URL => $url,
                CURLOPT_FRESH_CONNECT => 1,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_FORBID_REUSE => 1,
                CURLOPT_TIMEOUT => 4,
                CURLOPT_POSTFIELDS => http_build_query($query),
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
            );

        if (is_array())
        {
            $options[ CURLOPT_HTTPHEADER ]=$headers;
        }
        
        $this->Curl_Options_Set($options);
        if( ! $result = curl_exec($this->Curl_Obj))
        {
            echo curl_error($this->Curl_Obj);
        }
        
        curl_close($this->Curl_Obj);

        return $result;
    }
    
    function Curl_Options_Set($options)
    {
        curl_setopt_array($this->Curl_Obj,$options);
    }
    
    function Curl_Exec($url,$options)
    {
        $curl=curl_init();
        curl_setopt_array
        (
            $curl,
            $options
        );

        $result=curl_exec($curl);

        curl_close($curl);

        return $result;
    }
    
    function Curl_Exec_Decode($url,$options)
    {
        return
            json_decode
            (
                $this->Curl_Exec($url,$options),
                true
            );
    }
    function Curl_DownLoad($url,$file)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        
        $result = curl_exec($ch);
        curl_close($ch);

        $this->MyFile_Write($file,$result);
        system("/bin/chown www-data:www-data ".$file);
    }
}
?>