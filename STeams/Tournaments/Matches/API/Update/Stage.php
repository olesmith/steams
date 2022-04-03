<?php

trait Tournament_Matches_API_Update_Stage
{
    //*
    //* 
    //*

    function Tournament_Match_API_Update_Stage($tournament,$season,$jmatch,&$match,&$updatedatas,&$updatevalues)
    {
        $res=False;

        $data="Stage";
        $new_stage=$jmatch[ "stage" ];
        
        $old_stage=
            $this->MyHash_Key_Get_Save($match,$data,1);

        $stage=1;
        
        if (preg_match('/(Regular)/i',$new_stage))
        {
            $stage=2;
        }
        elseif (preg_match('/(Group)/i',$new_stage))
        {
            $stage=2;
        }
        elseif (preg_match('/16/i',$new_stage))
        {
            $stage=6;
        }
        elseif (preg_match('/32/i',$new_stage))
        {
            $stage=7;
        }
        elseif (preg_match('/QUARTER/i',$new_stage))
        {
            $stage=5;
        }
        elseif (preg_match('/SEMI/i',$new_stage))
        {
            $stage=4;
        }
        elseif (preg_match('/FINAL/i',$new_stage))
        {
            $stage=3;
        }
        //else { var_dump("Unknown stage",$new_stage); }

        if ($stage!=$old_stage)
        {
            $match[ $data ]=$stage;
            $res=True;

            array_push($updatedatas,$data);
            array_push
            (
                $updatevalues,
                $data.": ".$old_stage." => ".$stage
            );
        }
        
        return $res;
    }
}

?>