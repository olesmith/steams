<?php

trait Tournament_Matches_API_Update_Result
{
    //*
    //* 
    //*

    function Tournament_Match_API_Update_Result($tournament,$season,$jmatch,&$match,&$updatedatas,&$updatevalues)
    {
        $json=json_encode($jmatch,JSON_PRETTY_PRINT);

        $data="API_Result";
        $value=
            $this->MyHash_Key_Get_Save($match,$data);

        $res=False;
        if ($value!=$json)
        {
            $match[ $data ]=preg_replace('/\'/',"&#39;",$json);
            $res=True;

            array_push($updatedatas,$data);
            //var_dump($updatevalues);
            array_push
            (
                $updatevalues,
                $data.": ".$value." => ".$match[ $data ]
            );            

        }

        return $res;
    }
}

?>