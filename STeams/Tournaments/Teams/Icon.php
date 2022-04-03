<?php

trait Tournaments_Teams_Icon
{
    //*
    //* 
    //*

    function Team_Icon($team)
    {
        if (empty($team)) { return ""; }
        
        $namer="Name_".$this->MyLanguage_Get();
        $data="Icon";
        $api_data="Icon_URL";

        return
            $this->TeamsObj()->Team_Icon($team[ "Team" ]);
    }
}

?>