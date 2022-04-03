<?php

trait Tournament_Matches_History
{
    //*
    //* 
    //*

    function Tournament_Match_History_Handle($match=array())
    {
        if (empty($match)) { $match=$this->ItemHash; }
        

        $this->Htmls_Echo
        (
            array
            (
                $this->Tournament_Match_History_Html($match)
            )
        );
    }
    
    //*
    //* 
    //*

    function Tournament_Match_History_Html($match)
    {
        $seasons=
            $this->Tournament_SeasonsObj()->Sql_Select_Hashes
            (
                array
                (
                    "Tournament" => $match[ "Tournament" ],
                ),
                array("ID","Tournament","Year","Name"),
                "Year"
            );
        
        $seasons=array_reverse($seasons);
        
        $team_ids=
            array($match[ "Team1" ],$match[ "Team2" ]);

        $matches=array();
        
        foreach ($seasons as $season)
        {
            $this->TournamentsObj()->__Season__=$season;
            
            $matches=
                array_merge
                (
                    $matches,
                    $this->Sql_Select_Hashes
                    (
                        array
                        (
                            "Tournament" => $match[ "Tournament" ],
                            "Season"     => $season[ "ID" ],
                            "Team1"      => $team_ids,
                            "Team2"      => $team_ids,
                        ),
                        array(),
                        "Date"
                    )
                );
        }

        return
            array
            (
                $this->Htmls_H(6,$this->MyActions_Entry_Title()),
                count($matches),
                $this->MyMod_Items_Dynamic
                (
                    0,
                    $matches,
                    "History"
                )
            );
        
        /* $html=array();         */
        /* foreach ($seasons as $season) */
        /* { */
        /*     $this->TournamentsObj()->__Season__=$season; */
            
        /*     $matches= */
        /*         $this->Tournament_MatchesObj()->Sql_Select_Hashes */
        /*         ( */
        /*             array */
        /*             ( */
        /*                 "Tournament" => $match[ "Tournament" ], */
        /*                 "Season"     => $season[ "ID" ], */
        /*                 "Team1"      => $team_ids, */
        /*                 "Team2"      => $team_ids, */
        /*             ), */
        /*             array(), */
        /*             "Date" */
        /*         ); */

        /*     if (count($matches)>0) */
        /*     { */
        /*         $html= */
        /*             array_merge */
        /*             ( */
        /*                 $html, */
        /*                 array */
        /*                 ( */
        /*                     $this->Htmls_H(6,$season[ "Name" ]), */
        /*                     $this->Tournament_MatchesObj()->MyMod_Items_Dynamic */
        /*                     ( */
        /*                         0, */
        /*                         $matches, */
        /*                         "History" */
        /*                     ) */
        /*                 ) */
        /*             ); */
        /*     } */
        /* } */
        
        /* return $html; */
    }
}

?>
