<?php

trait Tournament_Matches_API_Update_Date
{
    //*
    //* 
    //*

    function Tournament_Match_API_Update_Date($tournament,$season,$jmatch,&$match,&$updatedatas,&$updatevalues)
    {
        $res=False;
        
        $date_old=$this->MyHash_Key_Get_Save($match,"Date",0);
        $hhmm_old=$this->MyHash_Key_Get_Save($match,"HHMM",0);
        
        $utcdate=$jmatch[ "utcDate" ];
        $comps=preg_split('/\s*T\s*/',$utcdate);
        if (count($comps)==2)
        {
            $date=preg_replace('/\s*-\s*/',"",$comps[0]);

            $hhmm=
                preg_replace('/(\d\d):(\d\d).*/','\1\2',$comps[1]);

            $hhmm=intval($hhmm)+$tournament[ "UTC" ]*100;
            
            $data="Date";
            if
                (
                    empty($match[ $data ])
                    ||
                    $match[ $data ]!=$date
                )
            {
                array_push($updatedatas,$data);
                array_push
                (
                    $updatevalues,
                    $data.": ".$date_old." => ".$date
                );
                
                $match[ $data ]=$date;
            }
                    
            $data="HHMM";
            if
                (
                    empty($match[ $data ])
                    ||
                    $match[ $data ]!=$hhmm
                )
            {
                array_push($updatedatas,$data);
                array_push
                (
                    $updatevalues,
                    $data.": ".$hhmm_old." => ".$hhmm
                );
                
                $match[ $data ]=$hhmm;

                $res=True;
            }
        }

        return $res;
    }
}

?>