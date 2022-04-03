<?php

class Language_Messages_Handle_Arrays_Read extends Language_Messages_Handle_Arrays_SGroup
{
    //*
    //* Reads Array items.
    //*

    function Language_Messages_Handle_Array_Read($edit,$item)
    {
        $this->Messages=array();
        $this->Messages=
            $this->Sql_Select_Hashes
            (
                array
                (
                    "Message_Key"  => $item[ "Message_Key" ],
                    "Message_Type" => $this->Language_Array_Type,
                ),
                array(),
                "ID"
            );

        $rmessages=array();
        foreach (array_keys($this->Messages) as $id)
        {
            if (empty($this->Messages[ $id ][ "N" ])) { $this->Messages[ $id ][ "N" ]=0; }

            $key=$this->Messages[ $id ][ "N" ];
            while (!empty($rmessages[ $key ]))
            {
                $key.="_";
                var_dump("Array Message Invalid Key",$rmessages);
            }
            
            $rmessages[ $key ]=$key;            
            $this->Messages[ $id ][ "Key" ]=$key;            
        }
    }               
}
?>