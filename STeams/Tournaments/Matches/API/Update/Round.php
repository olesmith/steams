<?php

trait Tournament_Matches_API_Update_Round
{
    //*
    //* 
    //*

    function Tournament_Match_API_Update_Round($tournament,$season,$jmatch,&$match,&$updatedatas,&$updatevalues)
    {
        if (empty($match[ "Tournament_Group" ])) { return False; }
        
        $match_day=$jmatch[ "matchday" ];

        $round=
            $this->RoundsObj()->Sql_Select_Hash
            (
                array
                (
                    "Tournament"       => $tournament[ "ID" ],
                    "Tournament_Group" => $match[ "Tournament_Group" ],
                    "Number"           => $match_day,
                )
            );

        $res=False;
        if (!empty($round))
        {
            $data="Tournament_Round";
            $value=
                $this->MyHash_Key_Get_Save($match,$data,0);

            if ($value!=$round[ "ID" ])
            {
                $match[ $data ]=$round[ "ID" ];  

                $res=True;
                      
                array_push($updatedatas,$data);
                array_push
                (
                    $updatevalues,
                    $data.": ".$round[ "ID" ]." => ".$match[ $data ]
                );
            }
        }

        return $res;
    }
}

?>