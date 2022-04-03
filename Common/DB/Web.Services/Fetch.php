<?php


trait DB_Web_Services_Fetch
{
    //*
    //* function DB_Web_Services_Fetch_Num_Rows, Parameter list: $result
    //*
    //* Calls num_rows.
    //* 
    //* 

    function DB_Web_Services_Fetch_Num_Rows($result)
    {
        return -1;
    }
    
    //*
    //* function DB_Web_Services_Fetch_Num_Fields, Parameter list: $result
    //*
    //* Returns number of rows.
    //* 
    //* 

    function DB_Web_Services_Fetch_Num_Fields($result)
    {
        return -1;
    }
    
    //*
    //* function DB_Web_Services_Fetch_Array, Parameter list: $result
    //*
    //* Fetches array.
    //* 
    //* 

    function DB_Web_Services_Fetch_Array($result)
    {
        return "DB_Web_Services_Fetch_Array";
    }


    //*
    //* function DB_Web_Services_Fetch_Assoc, Parameter list: $result
    //*
    //* Fetches associative array.
    //* 
    //* 

    function DB_Web_Services_Fetch_Assoc($result)
    {
        return "DB_Web_Services_Fetch_Assoc";
    }


    //*
    //* function DB_Web_Services_Fetch_Field, Parameter list: $result,$i
    //*
    //* Fetches array
    //* 
    //* 

    function DB_Web_Services_Fetch_Field($result,$i)
    {
        return "DB_Web_Services_Fetch_Field";
    }


    //*
    //* function DB_Web_Services_Fetch_Assoc_list, Parameter list: $result,$byid=FALSE
    //*
    //* Fetches rows from $result - as assoc. arrays.
    //* 
    //* 

    function DB_Web_Services_Fetch_Assoc_list($result,$byid=FALSE,$lowercasekeys=FALSE)
    {
        $this->DB_Web_Services_ReConnect(10);
        return $result;
    }


    //*
    //* function DB_Web_Services_Fetch_Array_list, Parameter list: $result,$byid=FALSE
    //*
    //* Fetches rows from $result - as arrays.
    //* 
    //* 

    function DB_Web_Services_Fetch_Array_list($result)
    {
        return "DB_Web_Services_Fetch_Array_list";
    }

    
    //*
    //* function DB_Web_Services_Insert_LastID(), Parameter list: 
    //*
    //* Get last insert ID from DB.
    //* 

    function DB_Web_Services_Insert_LastID()
    {
        return "DB_Web_Services_Insert_LastID";
    }
    
    //*
    //* function DB_Web_Services_Update_NChanges(), Parameter list: 
    //*
    //* Get last insert ID from DB.
    //* 

    function DB_Web_Services_Update_NChanges()
    {
         return "DB_Web_Services_Update_NChanges";
    }

    
    //*
    //* function DB_Web_Services_Fetch_FirstEntry, Parameter list: $result
    //*
    //* Returns first entry in $result.
    //* 
    //* 

    function DB_Web_Services_Fetch_FirstEntry($result)
    {
        return "Fetch One";
    }
}

?>