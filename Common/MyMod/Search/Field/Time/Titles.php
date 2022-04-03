<?php


trait MyMod_Search_Field_Time_Titles
{
    //*
    //* Creates titles row.
    //*

    function MyMod_Search_Field_Time_Titles()
    {
        $titles=
            array_merge
            (
                array("","",),
                $this->MyMod_Search_Field_Time_Components_Titles()
            );
        
        return $titles;
    }
        
}

?>