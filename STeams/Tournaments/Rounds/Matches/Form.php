<?php

trait Tournaments_Rounds_Matches_Form
{
    //*
    //* 
    //*

    function Tournament_Round_Matches_Form($edit,$tournament,$round)
    {
        return
            $this->Htmls_Form
            (
                1,
                "M_".
                $tournament[ "ID" ].
                "_R_".
                $round[ "ID" ],
                "",
                //$contents=
                array
                (
                    $this->Tournament_Round_Matches_Html
                    (
                        $edit,$tournament,$round
                    )
                ),
                //$args=
                array
                (
                    "Hiddens" => array
                    (
                        "Save" => 1,
                    ),
                    "Buttons" =>
                    (
                        $this->Buttons()
                    ),
                )
            );
    }
    
}

?>