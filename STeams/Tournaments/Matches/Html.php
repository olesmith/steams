<?php

trait Tournament_Matches_Html
{
    //*
    //* 
    //*

    function Tournament_Matches_Html($edit,$tournament,$teams,$groups)
    {
        return
            array
            (
                $this->Htmls_H
                (
                    1,
                    array
                    (
                        $this->TournamentsObj()->MyMod_ItemName().":",
                        $tournament[ "Name" ],
                    )
                ),


                $this->Htmls_Table
                (
                    array(),
                    $this->Tournament_Matches_Groups_Tables
                    (
                        $edit,$tournament,
                        $this->MyHash_HashesList_2ID
                        (
                            $groups,
                            "ID"
                        ),
                        $teams,
                        $this->Tournament_Matches_Read($tournament)
                    )
                )
            );
    }
}

?>
