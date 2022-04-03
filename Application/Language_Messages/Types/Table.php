<?php

class Language_Messages_Types_Table extends Language_Messages_Types_Rows
{    
    //*
    //* function Language_Message_Types_Table, Parameter list: 
    //*
    //* 

    function Language_Message_Types_Table()
    {
        $table=array();
        foreach ($this->Language_Messages_Types_Get() as $type => $hash)
        {
            $table=
                array_merge
                (
                    $table,
                    $this->Language_Message_Type_Rows($type,$hash)
                );
        }
        
        array_push
        (
            $table,
            $this->Language_Message_Type_Row_File(),
            $this->Language_Message_Type_Row_Totals(),
            $this->Language_Message_Type_Row_All(),
            $this->Language_Message_Type_Row_CheckBoxes()
        );
        
        return $table;
    }
    
}
?>