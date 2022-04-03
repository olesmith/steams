<?php

trait Language_Messages_Datas_Read
{
    //*
    //* Data keys to read from DB, ex: Name, Title, ShortName
    //*

    function Language_Data_Read($moduleobj=null)
    {
        if (empty($moduleobj)) { $moduleobj=$this; }
        
        return
            array
            (
                $moduleobj->TitleKeyShortName,
                $moduleobj->TitleKeyName,
                $moduleobj->TitleKeyTitle,
            );
    }    
}
?>