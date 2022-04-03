<?php

trait MyApp_Login_Html
{
    //*
    //* Creates login html table.
    //*

    function MyApp_Login_Html($msg)
    {
        return
            array_merge
            (
                array
                (
                    $this->H
                    (
                        2,
                        $this->GetMessage($this->LoginMessages,"Login")
                    ),
                    $this->H(3,$msg),
                ),
                $this->Htmls_Table
                (
                    array(),
                    $this->MyApp_Login_Table()
                )
            );
    }
}

?>