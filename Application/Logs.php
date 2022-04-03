<?php



class ApplicationLogs extends AppUsers
{
    //*
    //* function LogsObject, Parameter list: $updatestructure
    //*
    //* Logs object accessor.
    //*

    function LogsObject($updatestructure=FALSE)
    {
        return $this->LogsObj($updatestructure);
    }

    //*
    //* function LogsObj, Parameter list: $updatestructure
    //*
    //* Logs object accessor.
    //*

    function LogsObj($updatestructure=FALSE)
    {
        return $this->MyMod_SubModule_Load("Logs",$updatestructure);
    }
    
    //*
    //* function LogMessage, Parameter list: $action,$msgs="",$level=5
    //*
    //* Logs $msgs using $this->LogsObj().
    //*

    function LogMessage($action,$msgs="",$level=5)
    {
        $logobj=$this->LogsObject(TRUE);
        if (!empty($logobj))
        {
            $logobj->LogEntry($msgs,$level);
        }

        return;
    }
}

?>