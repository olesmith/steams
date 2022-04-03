<?php

trait Tournament_Groups_Matches_Cells
{
        //*
    //* 
    //*

    function Tournament_Matches_Group_Cells($edit,$match,$team1,$team2)
    {
        return
            $this->Tournament_MatchesObj()->Tournament_Match_Cell
            (
                $edit,$match,
                $team1,$team2
            );
    }

}

?>