<?php

trait MyActions_Info
{
   //*
    //* function MyMod_Actions_Info, Parameter list: 
    //*
    //* Handles module object sys info.
    //*

    function MyMod_Actions_Info_Form($edit)
    {
        return
            $this->MyMod_Handle_Info_Form
            (
                $edit,
                "Actions",
                "Module Info: Actions",
                $this->Actions(),
                $this->LanguagesObj()->Language_Action_Type
            );
    }
}

?>