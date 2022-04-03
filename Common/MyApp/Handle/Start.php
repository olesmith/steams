<?php

trait MyApp_Handle_Start
{
    //*
    //* function MyApp_Handle_Start, Parameter list: $echo=TRUE
    //*
    //* The Start Handler. Should display some basic info.
    //*

    function MyApp_Handle_Start($echo=TRUE)
    {
        if ($this->GetCGIVarValue("Action")=="Start")
        {
            $this->MakeCGI_Cookies_Reset();
        }

        $this->MyApp_Interface_Head();
        
        if (empty($this->LoginData))
        {
            $this->MyApp_Login_Form();
        }        
    }

}

?>