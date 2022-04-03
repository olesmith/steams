<?php

trait Tournament_Matches_API_Update_Status
{
    //*
    //* 
    //*

    function Tournament_Match_API_Update_Status($tournament,$season,$jmatch,&$match,&$updatedatas,&$updatevalues)
    {
        $data="Status";
                
        $old_status=
            $this->MyHash_Key_Get_Save($match,$data);
        
        $match_status=$jmatch[ "status" ];
        if (preg_match('/SCHEDULED/i',$match_status))
        {
            $status=1;
        }
        elseif (preg_match('/FINISHED/i',$match_status))
        {
            $status=3;
        }
        else
        {
            $status=2;
        }

        $res=False;
        if ($old_status!=$status)
        {
            $match[ $data ]=$status;   
            $res=True;

            array_push($updatedatas,$data);
            array_push
            (
                $updatevalues,
                $data.": ".$old_status." => ".$match[ $data ]
            );

        }

        return $res;
    }
}

?>