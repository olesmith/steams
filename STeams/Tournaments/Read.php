<?php

trait Tournaments_Read
{

    var $__Tournaments__=array();
    
    //*
    //* 
    //*

    function Tournaments_Read()
    {
        if (empty($this->__Tournaments__))
        {
            $this->__Tournaments__=
                $this->TournamentsObj()->Sql_Select_Hashes
                (
                    array(),
                    array("ID","Name","Season"),
                    "ID"
                );
        }
        
        return $this->__Tournaments__;
    }

//*
    //* 
    //*

    function Tournament_Read_Season($tournament)
    {
        $season_id=$this->CGI_GETint("Season");

        if
            (
                $this->Tournament_SeasonsObj()->Sql_Select_NHashes
                (
                    array
                    (
                        "Tournament" => $tournament[ "ID" ],
                        "ID"     => $season_id,
                    )
                )==0
            )
        {
            $season_id=0;
        }
        
        if (empty($season_id))
        {
            if (!empty($tournament[ "Season" ]))
            {
                $season_id=$tournament[ "Season" ];
            }
            else
            {
                $season_ids=
                    $this->Tournament_SeasonsObj()->Sql_Select_Unique_Col_Values
                    (
                        "ID",
                        array
                        (
                            "Tournament" => $tournament[ "ID" ],
                        ),
                        "StartDate"
                    );

                if (empty($season_ids))
                {
                    var_dump("No seasons found, Tournament",
                    $this->Tournament_SeasonsObj()->Sql_Select_Unique_Col_Values_Query
                    (
                        "ID",
                        array
                        (
                            "Tournament" => $tournament[ "ID" ],
                        ),
                        "StartDate"
                    ));
                }

                $season_id=array_pop($season_ids);
            }
        }
         

        
        $season=
            $this->Tournament_SeasonsObj()->Sql_Select_Hash
            (
                array
                (
                    "ID" => $season_id,
                ),
                array(),
                False
            );

        if (empty($season))
        {
            var_dump
            (
                "No season found, Tournament",
                $this->Tournament_SeasonsObj()->Sql_Select_Hash_Query
                (
                    array
                    (
                        "Tournament" => $tournament[ "ID" ],
                        "ID" => $season_id
                    ),
                    array(),
                    False
                )
            );
        }
        
        $this->ApplicationObj()->URL_CommonArgs=
            array
            (
                "Tournament" => $tournament[ "ID" ],
                "Season"     => $season[ "ID" ],
            );

        return $season;
    }
    
    //*
    //* 
    //*

    function Tournament_Default_Season($tournament)
    {
        return
            array
            (
                "Tournament" => $tournament[ "ID" ],
                "StartDate" => $tournament[ "StartDate" ],
                "EndDate" => $tournament[ "EndDate" ],
                "Year" => preg_replace('/[^\d]*/',"",$tournament[ "Name" ]),
                "Name" => preg_replace('/\s*[\d]*\s*/',"",$tournament[ "Name" ]),
            );        
    }
    
    //*
    //* 
    //*

    function Tournament_Read_Teams()
    {
        return
            $this->Tournament_TeamsObj()->
            Tournament_Teams_Get();
    }
    
    //*
    //* 
    //*

    function Tournament_Read_Groups()
    {
        return
            $this->Tournament_GroupsObj()->
            Tournament_Groups_Get();        
    }
}

?>