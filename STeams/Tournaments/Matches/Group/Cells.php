<?php

trait Tournament_Matches_Group_Cells
{
    //*
    //* 
    //*

    function Tournament_Matches_Group_Cells($team1_n,$team2_n,$edit,$tournament,$group,$teams,$match)
    {
        return
            $this->Tournament_Match_Cell($edit,$match);
    }
}

?>
