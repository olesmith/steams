<?php

class Language_Messages_Handle_Arrays_SGroup extends Language_Messages_Modules
{
    //*
    //* Generates the common table.
    //*

    function Language_Messages_Handle_Array_SGroup($edit,$item)
    {
        return
            array
            (
                $this->H(1,"Array Common Data"),
                $this->MyMod_Item_Table_Html
                (
                    $edit,
                    $item,
                    preg_grep
                    (
                        '/^N$/',
                        $this->Language_Messages_SGroup_Datas(),
                        PREG_GREP_INVERT
                    )
                ),
                $this->Htmls_Form_Buttons_Make
                (
                    $edit,
                    $this->Buttons()
                ),
            );
    }
}
?>