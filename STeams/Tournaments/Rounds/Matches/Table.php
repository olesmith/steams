<?php

trait Tournaments_Rounds_Matches_Table
{

    //*
    //* 
    //*

    function Tournament_Round_Matches_Table($edit,$tournament,$round,$group_id)
    {
        $matches=
            $this->Tournament_Round_Matches_Read
            (
                $tournament,$round,$group_id
            );

        if ($edit==1 && $this->CGI_POSTint("Save")==1)
        {
            $this->Tournament_Round_Matches_Update
            (
                $edit,$tournament,$round,$group_id,
                $matches
            );
        }
        
        $this->Tournament_Round_Matches_Disableds
        (
            $tournament,$round,$group_id,
            $matches
        );


        $table=array();
        $n=0;
        foreach ($matches as $match)
        {
            $n++;
            $table=
                array_merge
                (
                    $table,
                    $this->Tournament_Round_Match_Rows
                    (
                        $edit,$n,
                        $tournament,$round,
                        $group_id,
                        $match
                    )
                );
        }
        
        return $table;
    }
}

?>