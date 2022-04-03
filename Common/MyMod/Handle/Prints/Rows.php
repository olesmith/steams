<?php

trait MyMod_Handle_Prints_Rows
{
    //*
    //* 
    //*

    function MyMod_Handle_Prints_Row($type,$docno,$doc)
    {
        return
            array
            (
                $this->B($docno),
                $this->MyMod_Handle_Prints_Cell
                (
                    $type,$docno,$doc
                )
            );
    }
}

?>