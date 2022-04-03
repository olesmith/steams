<?php

class Language_Messages_Handle_Arrays_Rows extends Language_Messages_Handle_Arrays_Datas
{
    //*
    //* Creates $lang table rows for $ritems.
    //*

    function Language_Messages_Handle_Array_Language_Rows($edit,$common_edit,$item,$lang)
    {
        $display="";
        if ($this->Language_Messages_Handle_Array_Hide_Language_Should($lang))
        {
            $display="display: none;";
        }
        
        $rows=
            array
            (
                array
                (
                    $this->H(3,$lang),
                ),
                $this->Language_Messages_Handle_Array_Titles($display,$lang),
            );

        foreach ($this->Messages as $n => $message)
        {
            //$message=$this->Messages[ $n ];
            $row=
                array_merge
                (
                    array($message[ "Key" ]),
                    $this->Language_Messages_Handle_Array_Common_Cells
                    (
                        $common_edit,
                        $item,
                        $n,
                        $this->Messages[ $n ]
                    ),
                    $this->Language_Messages_Handle_Array_Language_Cells
                    (
                        $edit,
                        $item,
                        $this->Messages[ $n ],
                        $lang
                    )
                );
          
            array_push
            (
                $rows,
                $row
            );            
        }

        array_push
        (
            $rows,
            array
            (
                $this->Htmls_Form_Buttons_Make
                (
                    $edit,
                    $this->Buttons()
                )
            )
        );

        foreach (array_keys($rows) as $id)
        {
            if (isset($rows[ $id ][ "TitleRow" ]))
            {
                $rows[ $id ][ "Style" ]=$display;
            }
            else
            {
                $rows[ $id ]=
                    array
                    (
                        "Row" => $rows[ $id ],
                        "Class"=> $lang,
                        "Style" => $display,
                    );
            }
            
        }
        
        return $rows;
    }

}
?>