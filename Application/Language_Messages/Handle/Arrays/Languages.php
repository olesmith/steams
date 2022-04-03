<?php

class Language_Messages_Handle_Arrays_Languages extends Language_Messages_Handle_Arrays_Titles
{
    //*
    //*
    //*

    function Language_Messages_Handle_Array_Languages_Cells($edit,$item,$message)
    {
        $cells=array();
        foreach ($this->Language_Keys() as $lang)
        {
            $cells=
                array_merge
                (
                    $cells,
                    $this->Language_Messages_Handle_Array_Language_Cells($edit,$item,$message,$lang)
                );
        }

        return $cells;
    }
    
     //*
    //*
    //*

    function Language_Messages_Handle_Array_Language_Cells($edit,$item,$message,$lang)
    {
        $cells=array();
        foreach ($this->KeyDatas as $data)
        {
            $rdata=$data."_".$lang;
            array_push
            (
                $cells,
                $this->Language_Messages_Handle_Array_Language_Cell
                (
                    $edit,
                    $item,
                    $message,
                    $lang,
                    $data
                )
            );
        }

        return $cells;
    }
     //*
    //*
    //*

    function Language_Messages_Handle_Array_Language_Cell($edit,$item,$message,$lang,$data)
    {
        $rdata=$data."_".$lang;

        
        $cell=
            array
            (
                "Cell" => $this->MyMod_Item_Data_Cell
                (
                    $edit,
                    $message,
                    $rdata,
                    True,
                    $message[ "ID" ]."_".$rdata
                ),
                "Class" => array($data)
            );
        
        if
            (
                $this->Language_Messages_Handle_Array_Hide_Data_Should($data)
            )
        {
            $cell[ "Style" ]="display: none;";
        }

        return $cell;
    }
}
?>