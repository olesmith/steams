<?php


trait MyMod_Handle_Info_Row
{
    //*
    //* Handles module object sys info.
    //*

    function MyMod_Handle_Info_Row($edit,$n,$key,$fhash,$type,$message)
    {
        return
            array_merge
            (
                array
                (
                    $this->B($n),
                    $this->B
                    (
                        $key.":",
                        array("ID" => $key)
                    ),
                ),
                $this->MyMod_Handle_Info_Row_Actions($key,$fhash,$type,$message),
                $this->MyMod_Handle_Info_Row_Profiles($edit,$n,$key,$fhash,$message),
                $this->MyMod_Handle_Info_Row_Message_Datas($edit,$type,$message),
                $this->MyMod_Handle_Info_Row_File_Datas($edit,$key,$message)
            );
    }
        

    //*
    //* Handles module object sys info.
    //*

    function MyMod_Handle_Info_Row_Actions($key,$fhash,$type,$message)
    {
        $cells=array();
        foreach (array("Edit","Copy","Delete") as $action)
        {
            array_push
            (
                $cells,
                $this->MyMod_Handle_Message_Edit_Action
                (
                    array
                    (
                        "Message_Type" => $type,
                        "Message_Key" => $key,
                    ),
                    $action,
                    $fhash[ $key ]
                )
            );
        }

        return array($cells);
    }
    
    //*
    //* Handles module object sys info.
    //*

    function MyMod_Handle_Info_Row_Message_Datas($edit,$type,$message)
    {
        $tabindex=20;

        $cells=array();
        foreach ($this->MyMod_Handle_Info_Message_Datas($type) as $data)
        {
            array_push
            (
                $cells,
                $this->LanguagesObj()->MyMod_Data_Field
                (
                    $edit,
                    $message,
                    $data,
                    $plural=True,
                    $tabindex++
                )
            );
        }

        return $cells;
    }
    //*
    //* Handles module object sys info.
    //*

    function MyMod_Handle_Info_Row_File_Datas($edit,$key,$message)
    {
        $tabindex=20;

        $cells=array();
        foreach
            (
                $this->MyMod_Handle_Info_File_Datas
                (
                    $this->LanguagesObj()->Language_Data_Type
                )
                as $rkey
            )
        {
            $cell="-";
            if (!empty($fhash[ $key ][ $rkey ]))
            {
                $cell=$fhash[ $key ][ $rkey ];
            }
            
            array_push($cells,$cell);
        }
        return $cells;
    }
}

?>