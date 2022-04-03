<?php

trait Pool_Bets_Cells
{
    //*
    //* 
    //*

    function Pool_Bet_Input_Options($data,$item,$options=array())
    {
        return
            array_merge
            (
                $options,
                array
                (
                    "ONCLICK" => array
                    (
                        $this->JS_Input_Cyclic_Increasing(15),
                    ),
                    "STYLE" => array
                    (
                        'padding' =>  "1px",
                        'margin' =>  "1px",
                        "width" => "20px",
                        "border-radius" => '0px',
                        "color" => 'green',
                    ),
                )
            );
    }
}

?>