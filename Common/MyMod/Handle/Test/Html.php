<?php


trait MyMod_Handle_Test_Html
{
    //*
    //*
    //*

    function MyMod_Handle_Test_Html()
    {
        return
            $this->Htmls_Table
            (
                $this->MyMod_Handle_Test_Titles(),
                $this-> MyMod_Handle_Test_Table()
            );
    }
}

?>