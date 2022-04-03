<?php

trait Tournament_Groups_Matches_Form
{
    //*
    //*
    //*

    function Tournament_Group_Matches_Form($group)
    {
        $edit=1;
        $this->Htmls_Echo
        (
            $this->Htmls_Form
            (
                1,
                "Match_Table_".
                $this->Tournament("ID").
                "_".
                $group[ "ID" ],

                "",

                //$contents=
                $this->Tournament_Group_Matches_Html($edit,$group),
                //$args=
                array
                (
                    "Hiddens" => array("Save" => 1),
                    "Buttons" => $this->Buttons(),
                )
            )
        );
    }
}

?>