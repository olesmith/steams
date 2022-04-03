<?php

trait Tournament_Groups_Get
{
    //*
    //* 
    //*

    function Tournament_Groups_Get($update_structure=False)
    {
        if ($update_structure)
        {
            $this->Sql_Table_Structure_Update();
        }
        
        if (empty($this->__Groups__))
        {
            $where=$this->Tournament_Groups_Where();
            
            $this->__Groups__=
                $this->Sql_Select_Hashes
                (
                    $where,
                    array(),
                    "Name,Number,ID"
                );

            //Still empty, create.
            if (count($this->__Groups__)<$this->Tournament("NGroups"))
            {
                $this->Tournament_Groups_Create();
                $this->__Groups__=
                    $this->Sql_Select_Hashes
                    (
                        $where,
                        array(),
                        "Number,ID"
                    );
            }
        }

        return $this->__Groups__;
    }
}

?>