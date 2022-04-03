<?php

trait MyMod_Handle_Prints_Html
{
    //*
    //* 
    //*

    function MyMod_Handle_Prints_Html($type,$item=array())
    {
        return
            array
            (
                $this->Htmls_H
                (
                    2,
                    $this->MyActions_Entry_Title().
                    " ".
                    $this->MyMod_Item_Name_Get($item)
                ),
                $this->Htmls_Table
                (
                    "",
                    $this->MyMod_Handle_Prints_Table($type,$item)
                )
            );
    }
}

?>