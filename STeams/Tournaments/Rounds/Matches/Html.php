<?php

trait Tournaments_Rounds_Matches_Html
{
    //*
    //* 
    //*

    function Tournament_Round_Matches_Html($edit,$tournament,$round)
    {
        return
            $this->Htmls_Table
            (
                array(),
                $this->Tournament_Round_Matches_Tables
                (
                    $edit,$tournament,$round
                )
            );
    }
}

?>