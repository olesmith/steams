<?php

trait MyMod_Handle_Add_Redirect
{
    //*
    //* Redirects to edit item after add.
    //*

    function MyMod_Handle_Add_Redirect()
    {
        $args=$this->CGI_Query2Hash();
        if ($args[ "RAW" ]>=1)
        {
            $this->MyMod_Handle_Edit();

            exit();
        }
        
        /* var_dump("Redirect",$args); */
        /* exit(); */
        $args=$this->CGI_Query2Hash();
        $args=$this->CGI_Hidden2Hash($args);

        $action=$this->MyActions_Detect();

        $this->CGI_CommonArgs_Add($args);
        $args[ "Action" ]=$this->MyActions_Detect();
        if ($args[ "Action" ]=="Add")
        {
            $args[ "Action" ]=$this->MyMod_Add_Reload_Action;
        }

        $args[ "ID" ]=$this->ItemHash[ "ID" ];
        if (!empty($this->IDGETVar))
        {
            $args[ $this->IDGETVar ]=$this->ItemHash[ "ID" ];
        }

        //Now added, reload as edit, preventing multiple adds on user pressing F5.
        $this->CGI_Redirect($args);
        exit();
    }
}

?>