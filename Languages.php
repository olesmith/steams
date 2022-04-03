<?php

include_once("Application/Language_Messages.php");

class Languages extends Language_Messages
{
    var $Message_Tables=array("Sivent2_Messages","SAdE_Messages");
    
    //*
    //* function MyMod_Setup_Profiles_File(), Parameter list: 
    //*
    //* Returns module SetupDataPath.
    //*

    function MyMod_Setup_Profiles_File()
    {
        return
            dirname
            (
                dirname
                (
                    $this->ApplicationObj()->MyApp_Setup_Path()
                )
            ).
            "/Application/System/Languages/Profiles.php";
    }
}
?>