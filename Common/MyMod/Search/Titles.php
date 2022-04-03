<?php


trait MyMod_Search_Titles
{
    //*
    //* Search table title row.
    //*

    function MyMod_Search_Titles($fixedvalues,$omitvars,$details)
    {
        if (!$this->MyMod_Search_Option_Should("Empty_Titles",$omitvars))
        {
            return False;
        }
        
        return
            array
            (
                "","",
                $this->B
                (
                    $this->MyLanguage_GetMessage("Defined").
                    ":"
                ),
                $this->B
                (
                    $this->MyLanguage_GetMessage("Undefined").
                    ":"
                ),
                ""
            );
    }
}

?>