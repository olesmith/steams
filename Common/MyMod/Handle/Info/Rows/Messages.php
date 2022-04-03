<?php

trait MyMod_Handle_Info_Rows_Messages
{
    //*
    //* Calls LanguageObj to generate table Language.
    //* Needed for hide/show.
    //*

    function MyMod_Handle_Info_Rows_Message_Table($edit,$groupno,$key,$message)
    {
        return
            $this->Htmls_Table
            (
                "",
                $this->MyMod_Handle_Info_Rows_Message($edit,$groupno,$key,$message)//,
                //$this->MyMod_Handle_Info_Rows_Message_Table_Options($edit,$key,$message)
            );
    }
    
    //*
    //* Calls LanguageObj to generate rows and marks with class: Language.
    //* Needed for hide/show.
    //*

    function MyMod_Handle_Info_Rows_Message($edit,$groupno,$key,$message)
    {
        $rows=
            $this->LanguagesObj()->Language_Message_Item_Languages_Rows
            (
                $edit,
                $n=0,
                $message,
                $nrowsindent=0,
                $leading1="",
                $leading2="",
                $force=True
            );

        array_push
        (
            $rows,
            array
            (
                $this->Buttons
                (
                    $submit="",
                    $reset="",
                    $options=
                    array
                    (
                        "NAME" => "Edit_Language_".$groupno,
                        "VALUE" => 1,
                    )
                )
            )
        );
                    
        return $rows;
    }
  }

?>