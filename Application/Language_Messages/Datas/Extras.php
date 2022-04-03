<?php

trait Language_Messages_Datas_Extras
{
    
    //*
    //* Add extra keys for ItemData: SearchName etc.
    //*

    function Language_Data_Extras_Update($moduleobj,$dataname,$hash)
    {
        $defs=
            array
            (
                "SearchName" => $dataname."_Search",
                "EmptyName" => $dataname."_Empty",
                "Comment" => $dataname."_Comment",
                "EditComment" => $dataname."_EditComment",
                "LongName" => $dataname."_Long",
                
            );

        $messages=array();
        foreach ($defs as $var => $varname)
        {
            if (!empty($hash[ $var ]))
            {
                $messages=
                    array_merge
                    (
                        $messages,
                        $this->Language_Data_Extra_Update
                        (
                            $moduleobj,
                            $dataname,
                            $hash,
                            $var,
                            $varname
                        )
                    );
            }
        }

        return $messages;
    }
    
    //*
    //*
    //* Add extra keys for ItemData: SearchName etc.
    //*

    function Language_Data_Extra_Update($moduleobj,$dataname,$hash,$var,$varname)
    {
        $ritem=
            array
            (
                "Name" => $hash[ $var ],
                "File" => $hash[ "File" ],
            );
            
        foreach ($this->Language_Keys() as $language)
        {
            if (!empty($hash[ $var."_".$language ]))
            {
                    $ritem[ "Name_".$language ]=$hash[ $var."_".$language ];
            }
            else { $ritem[ "Name_".$language ]=$hash[ $var ]; }
        }

        return
            $this->Language_Module_Item_Update_Rows
            (
                $moduleobj->ModuleName,
                $hash[ "File" ],
                $varname,
                $ritem,
                $this->Language_Data_Type
            );
    }

}
?>