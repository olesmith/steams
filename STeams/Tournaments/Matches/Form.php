<?php

trait Tournament_Matches_Form
{
    //*
    //* 
    //*

    function Tournament_Matches_Form($edit,$tournament,$teams,$groups)
    {
        return
            $this->Htmls_Form
            (
                $edit,
                "Matches_".$tournament[ "ID" ],
                "",

                //$contents=
                $this->Tournament_Matches_Html
                (
                    $edit,$tournament,
                    $teams,
                    $groups
                ),

                //$args=
                array
                (
                    "Buttons" => $this->Buttons(),
                    "Hiddens" => array
                    (
                        "Update" => 1,
                    )
                )
            );
    }
}

?>
