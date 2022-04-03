<?php

trait Pool_Bets_Round_Form
{
    //*
    //* 
    //*

    function Pool_Bets_Round_Form()
    {
        return
            array
            (
                $this->Htmls_Form
                (
                    $this->Pool_Bets_Round_Edit(),
                    "Bets_Round_".$this->Round("ID").time(),
                    "",

                    //$contents=
                    array
                    (
                        $this->Pool_Bets_Round_Html(),
                    ),

                    //$args=
                    array
                    (
                        "Hiddens" => array
                        (
                            "Save" => 1,
                        ),
                        "Buttons" => $this->Buttons(),
                    )
                )
            );
    }
}

?>