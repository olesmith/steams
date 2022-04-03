<?php


trait MyApp_CGI
{
    //*
    //* function MyApp_CGI_Reload_Try, Parameter list: $args=array()
    //*
    //* Tries to send Location header - if not $this->HeadersSend,
    //* in which case it is too late.
    //*

    function MyApp_CGI_Reload_Try($args=array())
    {
        if (!$this->HeadersSend)
        {
            $this->CGI_Redirect($args);
        }
    }

}

?>