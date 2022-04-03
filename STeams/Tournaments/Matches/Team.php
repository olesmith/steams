<?php

trait Tournament_Matches_Team
{
    //*
    //* 
    //*

    function Tournament_Match_Team_Handle($item=array())
    {
        if (empty($item)) { $item=$this->ItemHash; }

        $action=$this->CGI_GET("Action");

        $team=1;
        if (preg_match('/2$/',$action)) { $team=2; }

        $team=$item[ "Team".$team ];

        $this->Tournament_TeamsObj()->ItemHash=
            $this->Tournament_TeamsObj()->Sql_Select_Hash
            (
                array("Team" => $team)
            );
       
        $this->Tournament_TeamsObj()->Handle
        (
            "Matches"
        );
    }
}

?>