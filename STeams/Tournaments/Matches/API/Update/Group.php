<?php

trait Tournament_Matches_API_Update_Group
{
    //*
    //* 
    //*

    function Tournament_Match_API_Update_Group($tournament,$season,$jmatch,&$match,&$updatedatas,&$updatevalues)
    {
        $jgroup=preg_replace('/Group\s+/i',"",$jmatch[ "group" ]);

        $our_group=
            $this->Tournament_GroupsObj()->Sql_Select_Hash
            (
                array
                (
                    "Tournament" => $tournament[ "ID" ],
                    "Season" => $season[ "ID" ],
                    "Name" => $jgroup,
                ),
                array("ID")
            );

        $data="Tournament_Group";
        $value=
            $this->MyHash_Key_Get_Save($match,$data,0);

        $res=False;
        if
            (
                !empty($our_group)
                &&
                !empty($our_group[ "ID" ])
                &&
                $value!=$our_group[ "ID" ]
            )
        {
            $match[ $data ]=$our_group[ "ID" ];
            $res=True;
            
            array_push($updatedatas,$data);
            array_push
            (
                $updatevalues,
                $data.": ".$our_group[ "ID" ]." => ".$match[ $data ]
            );            
        }
        
        return $res;
    }
}

?>