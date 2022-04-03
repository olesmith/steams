<?php


trait MyMod_Search_Table_Fields
{
    //*
    //* Generates two row search fields matrix.
    //*

    function MyMod_Search_Table_Fields_Table($fixedvalues,$omitvars,$details=False)
    {
        $titles=array();
        if (!$this->MyMod_Search_Option_Should("Empty_Titles",$omitvars))
        {
            $titles=$this->MyMod_Search_Titles($fixedvalues,$omitvars,$details);
        }
        
        if ($details)
        {
            $titles=
                array
                (
                    "Row" => $titles,
                    "Class" => "Search_Details",
                    "Style" => "display: none;",
                );
        }
        
        $table=array($titles);

        foreach ($this->MyMod_Search_Datas_Get($details) as $data)
        {
            $table=
                array_merge
                (
                    $table,
                    $this->MyMod_Search_Rows_Generate
                    (
                        $data,$fixedvalues,$omitvars,$details
                    )
                );
        }

        if ($details)
        {
            array_push
            (
                $table,
                array
                (
                    "Row" => array("SQL Query:",$this->LastWhereClause),
                    "Class" => "Search_Details",
                    "Style" => "display: none;",
                )
            );
        }

        return $table;
    }
}

?>