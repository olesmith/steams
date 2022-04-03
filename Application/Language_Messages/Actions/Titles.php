<?php

trait Language_Messages_Actions_Titles
{
    //*
    //* 
    //*

    function Language_Action_Title_Get($moduleobj,$key,$data="Title")
    {
        return $this->Language_Action_Name_Get($moduleobj,$key,$data);
    }
}
?>