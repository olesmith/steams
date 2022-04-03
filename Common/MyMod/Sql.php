<?php

trait MyMod_Sql
{
    var $SqlWhere=array();
    var $SqlWhere_Search=array();
    
    //*
    //* Returns sql where clause associated with $data.
    //*

    function MyMod_SqlWhere($where=array())
    {
        //Correct stringed SqlWhere's: convert to hash.
        if (is_string($this->SqlWhere))
        {
            $this->SqlWhere=
                $this->SqlClause2Hash($this->SqlWhere);
        }
            
        return
            array_merge
            (
                $this->SqlWhere,
                $where
            );
    }    
}

?>