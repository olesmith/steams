<?php

trait MyMod_Data_Info
{
    //*
    //* function MyMod_Data_Info, Parameter list: 
    //*
    //* Handles module object sys info.
    //*

    function MyMod_Data_Info_Form($edit)
    {
        return
            $this->MyMod_Handle_Info_Form
            (
                $edit,
                "ItemData",
                "Module Info: ItemData",
                $this->ItemData(),
                $this->LanguagesObj()->Language_Data_Type
            );
    }   
}

?>