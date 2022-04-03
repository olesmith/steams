<?php

include_once("Application/UserStates.php");

class User_States extends UserStates 
{
    var $__CGI_Keys__=
        array
        (
            //"ModuleName",//"Action",
            "Tournament",
            "Season","Pool",
        );
    
    var $__CGI_State__=array();
    
    //*
    //*
    //* Constructor.
    //*

    function User_States($args=array())
    {
        $this->Hash2Object($args);
        $this->Sort=array("Name");
        
        $this->AlwaysReadData=
            array("Login","Name");
        
        $this->MyMod_SGroup_Default="Basic";
    }
}

?>