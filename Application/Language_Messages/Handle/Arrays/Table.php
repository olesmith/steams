<?php

class Language_Messages_Handle_Arrays_Table extends Language_Messages_Handle_Arrays_Languages
{
    //*
    //* 
    //*

    function Language_Messages_Handle_Array_Table($edit,$item)
    {
        $table=
            array
            (
                array
                (
                    $this->Language_Messages_Handle_Array_Hide_Buttons($edit,$item)
                )
            );

        $common_edit=$edit;
        foreach ($this->Language_Keys() as $lang)
        {
            $table=
                array_merge
                (
                    $table,
                    $this->Language_Messages_Handle_Array_Language_Rows
                    (
                        $edit,
                        $common_edit,
                        $item,
                        $lang
                    )
                );
            $common_edit=0;

        }

        return $table;
    }
    
    //*
    //*
    //*

    function Language_Messages_Handle_Array_Common_Cells($edit,$item,$n,$message)
    {
        return
            $this->MyMod_Items_Table_Row
            (
                $edit,
                $n,
                $message,
                $this->Language_Messages_Handle_Array_Datas(),
                $plural=TRUE,
                $pre=$message[ "ID" ]."_"
            );
    }
}
?>