<?php

trait Tournaments_Update
{
    //*
    //* 
    //*

    function Tournament_Update_Structure($tournament)
    {
        if (!empty($tournament)) { $this->__Tournament__=$tournament; }

        $this->Tournament();

        $this->Tournament_Update_Groups();
        $this->Tournament_Update_Teams();
    }
    
    //*
    //* 
    //*

    function Tournament_Update_Teams()
    {
        $this->Tournament_TeamsObj()->Sql_Table_Structure_Update();
    }
    
    //*
    //* 
    //*

    function Tournament_Update_Groups()
    {
        $this->Tournament_GroupsObj()->Sql_Table_Structure_Update();
    }
}

?>