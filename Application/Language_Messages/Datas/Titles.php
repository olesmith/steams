<?php

trait Language_Messages_Datas_Titles
{
    //*
    //* Data keys to attempt, retrieving data Titles.
    //* 

    function Language_Data_Titles($moduleobj)
    {
        return array_reverse($this->Language_Data_Names($moduleobj));
            array
            (
                $moduleobj->TitleKeyShortName,
                $moduleobj->TitleKeyName,
                $moduleobj->TitleKeyTitle,
            );
    }
    
    //*
    //* 
    //*

    function Language_Data_Title_Get($moduleobj,$data,$keys=array())
    {
        if (empty($keys)) { $keys=$this->Language_Data_Titles($moduleobj); }
        
        return $this->Language_Data_Name_Get($moduleobj,$data,$keys);
    }
}
?>