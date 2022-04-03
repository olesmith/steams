<?php

class Language_Messages_Handle_Arrays_Html extends Language_Messages_Handle_Arrays_Hide
{
    //*
    //* Generates the common table.
    //*

    function Language_Messages_Handle_Array_Html($edit,$item)
    {
        return
            array
            (
                $this->H(1,"Array Individual Data"),
                #$this->Language_Messages_Handle_Array_Hide_Buttons($edit,$item),
                $this->Htmls_Table
                (
                    "",
                    $this->Language_Messages_Handle_Array_Table($edit,$item),
                    array
                    (
                        "WIDTH" => '100%',
                    )
                ),
            );
    }
}
?>