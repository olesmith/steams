<?php

trait Pool_Bets_Round_Html
{
    //*
    //* 
    //*

    function Pool_Bets_Round_Html()
    {
        return
            array
            (
                $this->Htmls_Table
                (
                    array(),
                    $this->Pool_Bets_Round_Table
                    (
                        $this->Pool_Bets_Round_Read_Matches()
                    )
                )
            );
    }
}

?>