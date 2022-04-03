<?php

trait Language_Messages_Add
{
    //*
    //* Swiftly add message to db
    //*

    function Language_Message_Add($key,$message,$module,$type=1,$item=array())
    {
        $where=
            array
            (
                "Message_Type" => $type,
                "Message_Key"  => $key,
            );
    
        $ritem=
            $this->Sql_Select_Hash
            (
                $where,
                array("ID")
            );

        var_dump("Msg: ".$key.":",$message);
        if (!empty($ritem))
        {
            var_dump("Already exists");
        }
        else
        {
            $item=
                array_merge
                (
                    $item,
                    $where,
                    array
                    (
                        "Module" => $module,
                    )
                );

            foreach ($this->Language_Keys() as $lkey)
            {
                foreach (array("Name","Title") as $data)
                {
                    $item[ $data."_".$lkey ]=$message;

                }
            }
            
            $this->Sql_Insert_Item($item);
            
            
            var_dump("Inserted, ID: ",$item);
        }
    }
}