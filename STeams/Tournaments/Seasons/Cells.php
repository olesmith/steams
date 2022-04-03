<?php

trait Tournaments_Seasons_Cells
{
    //*
    //*
    //*

    function Tournament_Season_Cell_Public_URL($edit=0,$season=array(),$data="")
    {
        if (empty($season))
        {
            return "Public URL:";
        }      

        return
            $this->CGI_Script_Protocol().
            "://".
            $this->CGI_Server_Name().
            $this->CGI_Script_Path().
            "?".
            "Tournament=".$this->Season("Tournament").
            "&".
            "Season=".$this->Season("ID").
            //"&".
            //"ModuleName=Tournaments".
            "&".
            "Action=Start".
            "";
    }

    //*
    //*
    //*

    function Tournament_Season_Cell_Mobile_URL($edit=0,$season=array(),$data="")
    {
        if (empty($season))
        {
            return "Mobile URL:";
        }      
       

        return
            $this->Tournament_Season_Cell_Public_URL($edit,$season,$data).
            "&".
            "Mobile=1".
            "";
    }


    //*
    //* 
    //*

    function Tournament_Season_Cell_Period($edit=0,$season=array(),$data="")

    {
        if (empty($season)) { return $this->MyLanguage_GetMessage("Period"); }

        return
            array
            (
                $this->MyTime_Sort2Date($season[ "StartDate" ]),
                "-",
                $this->MyTime_Sort2Date($season[ "EndDate" ])
            );
    }
    
    //*
    //* 
    //*

    function Tournament_Season_Cell_Teams_N($edit=0,$season=array(),$data="")

    {
        if (empty($season)) { return $this->TeamsObj()->MyMod_ItemsName(); }

        return
            $this->Tournament_TeamsObj()->Sql_Select_NHashes
            (
                array
                (
                    "Season"     => $season[ "ID" ],
                    "Tournament" => $season[ "Tournament" ],
                )
            );
    }
    //*
    //* 
    //*

    function Tournament_Season_Cell_Matches_N($edit=0,$season=array(),$data="")

    {
        if (empty($season)) { return $this->MatchesObj()->MyMod_ItemsName(); }

        return
            $this->MatchesObj()->Sql_Select_NHashes
            (
                array
                (
                    "Season"     => $season[ "ID" ],
                    "Tournament" => $season[ "Tournament" ],
                )
            );
    }
    //*
    //* 
    //*

    function Tournament_Season_Cell_Groups_N($edit=0,$season=array(),$data="")

    {
        if (empty($season)) { return $this->GroupsObj()->MyMod_ItemsName(); }

        return
            $this->GroupsObj()->Sql_Select_NHashes
            (
                array
                (
                    "Season"     => $season[ "ID" ],
                    "Tournament" => $season[ "Tournament" ],
                )
            );
    }
    //*
    //* 
    //*

    function Tournament_Season_Cell_Rounds_N($edit=0,$season=array(),$data="")

    {
        if (empty($season)) { return $this->RoundsObj()->MyMod_ItemsName(); }

        return
            $this->RoundsObj()->Sql_Select_NHashes
            (
                array
                (
                    "Season"     => $season[ "ID" ],
                    "Tournament" => $season[ "Tournament" ],
                )
            );
    }
}

?>