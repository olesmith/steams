<?php

class Language_Messages_Item_Data extends Language_Messages_Item_Language
{
    //*
    //* 
    //*

    function Language_Message_Item_Datas_Rows($edit,$n,$item,$title="Data:",$force=False)
    {
        if (!$force && $this->MyMod_Data_Group_Messages_Should())
        {
            return array();
        }
        
        $rows=
            array
            (
                $this->Htmls_Table_Head_Row
                (
                    array_merge
                    (
                        array
                        (
                             $this->B($title),
                        ),
                        $this->Language_Keys()
                    )
                )
            );
        
        foreach ($this->KeyDatas as $data)
        {
            array_push
            (
                $rows,
                $this->Language_Message_Item_Data_Row
                (
                    $edit,$n,$item,$data
                )
            );
        }


        array_push
        (
            $rows,
            $this->Language_Message_Item_Data_Row
            (
                $edit,$n,$item,"MTime"
            )
        );
        
        return $rows;
    }
    
    //*
    //* $key: Name, Title or ShortName
    //*

    function Language_Message_Item_Data_Row($edit,$n,$item,$data)
    {
        $row=
            array
            (
                $this->B($data.":"),
            );

        if (!empty($item[ "ID" ]))
        {

            $row=
                array_merge
                (
                    $row,
                    $this->MyMod_Items_Table_Row
                    (
                        $edit,
                        $n,
                        $item,
                        $this->LanguageDataKeys[ $data ],
                        True,
                        $item[ "ID" ]."_"
                    ),
                    array("")
                );
        }

        return $row;
     }
}
?>