<?php

trait Language_Messages_Groups_Titles
{
    //*
    //* function Language_Group_Titles, Parameter list: $module,$key
    //*
    //* 

    function Language_Group_Titles($moduleobj)
    {
        return
            array_reverse
            (
                $this->Language_Group_Names($moduleobj)
            );
            
    }
    
    //*
    //* function Language_Group_Title_Get, Parameter list: $module,$key,$singular,$datas=array()
    //*
    //* 
    //*

    function Language_Group_Title_Get($moduleobj,$key,$singular,$datas=array())
    {
        if (empty($datas))
        {
            $datas=$this->Language_Group_Titles($moduleobj);
        }
        
        return $this->Language_Group_Name_Get($moduleobj,$key,$singular,$datas);
    }
}
?>