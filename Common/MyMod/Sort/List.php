<?php


trait MyMod_Sort_List
{
    function MyMod_Sort_List($list,$sorts=array(),$reverse=FALSE)
    {
        if (empty($sorts))
        {
            $sorts=$this->Sort;
        }

        if (!is_array($sorts) || empty($sorts))
        {
            $sorts=preg_split('/\s*,\s*/',$sorts);
        }

        array_push($sorts,"ID"); //ID make sort fields alqways unique!

        return $this->Sort_List($list,$sorts,$reverse);
    }

    
    //*
    //* Sorts $items, with $fkey (ex: Friend) defined, by $nkey (ex: TextName).
    //*

    function MyMod_Sort_List_ByKey_Name($items,$moduleobj,$rkey,$nkey)
    {
        //Extract the IDs
        $ritemids=
            $this->MyHash_HashesList_Values
            (
                $items,
                $rkey
            );

        //Read ID and $nkey
        $ritems=$moduleobj->Sql_Select_Hashes_ByID
        (
            array
            (
                "ID" => $ritemids,
            ),
            array("ID",$nkey,)
        );

        //Update $nkey's in $items
        foreach (array_keys($items) as $pid)
        {
            $items[ $pid ][ $nkey ]="";
            if (!empty($items[ $pid ][ $rkey ]))
            {
                $ritemid=$items[ $pid ][ $rkey ];
                if (!empty($ritems[ $ritemid ]))
                {
                    //Ensure unicity
                    $items[ $pid ][ $nkey ]=
                        $ritems[ $ritemid ][ $nkey ]."_".$ritemid;
                }
            }
        }

        //Return sorted $items
        return $this->MyMod_Sort_List($items,$nkey);
    }
}

?>