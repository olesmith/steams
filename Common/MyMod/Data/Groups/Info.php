<?php

trait MyMod_Data_Groups_Info
{
   //*
    //* function MyMod_Data_Groups_Info, Parameter list: $singular=FALSE
    //*
    //* Handles module object sys info.
    //*

    function MyMod_Data_Groups_Info_Form($edit,$singular=FALSE)
    {
        $title="Module Info: ItemDataGroups";
        $attr="ItemDataGroups";
        $type=$this->LanguagesObj()->Language_Group_Type;
        
        if ($singular)
        {
            $title="Module Info: ItemDataSGroups";
            $attr="ItemDataSGroups";
            $type=$this->LanguagesObj()->Language_SGroup_Type;
        }
        
        return
            $this->MyMod_Handle_Info_Form
            (
                $edit,
                $attr,
                $title,
                $this->$attr,
                $type
            );
    }
}

?>