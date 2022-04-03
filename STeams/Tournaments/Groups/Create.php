<?php

trait Tournament_Groups_Create
{
    //*
    //* 
    //*

    function Tournament_Groups_ByID($update_structure=False)
    {
        return
            $this->MyHash_HashesList_2ID
            (
                $this->Tournament_Groups_Get($update_structure)
            );
    }
    
    //*
    //* 
    //*

    function Tournament_Group_Numbers()
    {
        return
            $this->Sql_Select_Unique_Col_Values
            (
                "Number",
                $this->Tournament_Groups_Where()
            );
    }
    
    //*
    //* 
    //*

    function Tournament_Groups_Create()
    {
        $group_numbers=
            $this->Tournament_Group_Numbers();

        for ($n=1;$n<=$this->Tournament("NGroups");$n++)
        {
            if (!preg_grep('/^'.$n.'$/',$group_numbers))
            {
                $this->Tournament_GroupNo_Create($n);
            }
        }
    }
    
    //*
    //* 
    //*

    function Tournament_GroupNo_Create($group_number)
    {
        $where=
            $this->Tournament_Groups_Where
            (
                array
                (
                    "Number" => $group_number,
                )
            );
        
        $group=
            $this->Sql_Select_Hash
            (
                $where,
                array("ID")
            );

        $letters="abcdefghijklmnopqrstuvxyz";
        if (empty($group))
        {
            $group=
                array_merge
                (
                    $where,
                    array
                    (
                        "Name" => strtoupper(substr($letters,$group_number-1,1))
                    )
                );

            $this->Sql_Insert_Item($group);
        }
    }
    
    //*
    //* 
    //*

    function Tournament_Groups_Where($where=array())
    {
        return
            array_merge
            (
                array
                (
                    "Tournament" => $this->Tournament("ID"),
                    "Season"     => $this->Season("ID"),
                ),
                $where
            );
    }
}

?>