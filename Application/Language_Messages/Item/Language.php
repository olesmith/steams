<?php

class Language_Messages_Item_Language extends Language_Messages_Permissions
{
    //*
    //* Languages to read: current $language and $this->ApplicationObj()->Language_Default.
    //* 

    function Language_Message_Item_Languages($language="")
    {
        if (empty($language)) { $language=$this->ApplicationObj()->Language; }
        
        $languages=array($language);
        if ($language!=$this->ApplicationObj()->Language_Default)
        {
            array_push($languages,$this->ApplicationObj()->Language_Default);
        }

        return $languages;
    }
    //*
    //* 
    //*

    function Language_Message_Item_Language_Datas()
    {
        $datas=array();
        foreach (array_keys($this->LanguageKeyDatas) as $lang)
        {
            $datas=
                array_merge
                (
                    $datas,
                    $this->LanguageKeyDatas[ $lang ]
                );
        }

        return $datas;
    }

    
    //*
    //* 
    //*

    function Language_Message_Item_Languages_Rows($edit,$n,$item,$nrowsindent=6,$leading1="",$leading2="",$force=False,$includehead=True)
    {
        if
            (
                !$force
                &&
                $this->MyMod_Data_Group_Messages_Should()
            )
        {
            return array();
        }

        $rows=array();
        if ($includehead)
        {
            array_push
            (
                $rows,
                $this->Htmls_Table_Head_Row
                (
                    array_merge
                    (
                        array
                        (
                            $this->Htmls_Table_Multi_Cell("",$nrowsindent),
                            "",
                            $this->B("Language".":"),
                        ),
                        $this->KeyDatas
                    )
                )
            );
        }
        
        foreach ($this->Language_Keys() as $lang)
        {
            array_push
            (
                $rows,
                $this->Language_Message_Item_Language_Row
                (
                    $edit,$n,$item,$lang,$nrowsindent,$leading1
                )
            );

            $leading1=$leading2;
            $leading2="";
        }

        return $rows;
    }
    
    //* function Language_Message_Item_Language_Row, Parameter list:
    //*
    //* Reads message item.
    //*

    function Language_Message_Item_Language_Row($edit,$n,$item,$lang,$nrowsindent=6,$leading="")
    {
        $row=
            array
            (
                $this->Htmls_Table_Multi_Cell("",$nrowsindent),
                $leading,
                $this->B($lang.":"),
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
                        $this->LanguageKeyDatas[ $lang ],
                        True,
                        $item[ "ID" ]."_"
                    ),
                    array("")
                );
        }

        array_push($row,"");

        return $row;
    }
}
?>