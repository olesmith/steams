<?php

trait MyApp_Logging
{
    //*
    //* Initializes loggin, if on.
    //* If Log_Path is not defined or empty in index.php,
    //* initilize Logs module DB table.
    //*

    function MyApp_Logging_Init()
    {
        if ($this->Logging)
        {
            if
                (
                    !property_exists($this,"Log_Path")
                    ||
                    empty($this->Log_Path)
                )
            {                
                $this->MyMod_SubModule_Load("Logs",TRUE,TRUE);
            }

            $module=$this->CGI_GET("ModuleName");
            if (empty($module))
            {
                $this->LogsObject()->LogEntry($this->AppName);
            }
        }
    }

}

?>