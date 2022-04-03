<?php

trait Tournament_Matches_API_Update_Duration
{
    //*
    //* 
    //*

    function Tournament_Match_API_Update_Duration($tournament,$jmatch,&$match,&$updatedatas,&$updatevalues)
    {
        $data="Duration";
        $old_duration=
            $this->MyHash_Key_Get_Save($match,$data,1);
        
        //future
        $duration=1;

        $api_value=$jmatch[ "score" ][ "duration" ];
        if (preg_match('/(Regular)/i',$api_value))
        {
            $duration=2;
        }
        elseif (preg_match('/(Extra)/i',$api_value))
        {
            $duration=3;
        }
        elseif (preg_match('/(Penalt)/i',$api_value))
        {
            $duration=4;
        }
        
        $res=False;
        if ($old_duration!=$duration)
        {
            $match[ $data ]=$duration;
            $res=True;
            
            array_push($updatedatas,$data);
            array_push
            (
                $updatevalues,
                $data.": ".$old_duration." => ".$match[ $data ]
            );
        }

        return $res;
    }
}

?>