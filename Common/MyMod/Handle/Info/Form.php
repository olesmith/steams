<?php

trait MyMod_Handle_Info_Form
{
    //*
    //* Handles module object sys info.
    //*

    function MyMod_Handle_Info_Form($edit,$id,$title,$fhash,$type)
    {
        $group="Basic";
        if ($type==$this->LanguagesObj()->Language_Data_Type)
        {
            $group="Datas";
        }
        if ($type==$this->LanguagesObj()->Language_Group_Type)
        {
            $group="Groups";
        }
        elseif ($type==$this->LanguagesObj()->Language_SGroup_Type)
        {
            $group="Groups";
        }
        elseif ($type==$this->LanguagesObj()->Language_Action_Type)
        {
            $group="Actions";
        }
        
        return
            array
            (
                $this->Htmls_H
                (
                    1,
                    $this->ModuleName.
                    ", Module: ".
                    $group
                ),
                $this->LanguagesObj()->MyMod_Items_Dynamic_IDs
                (
                    0,
                    $this->LanguagesObj()->Sql_Select_Unique_Col_Values
                    (
                        "ID",
                        array
                        (
                            "Module"       => $this->ModuleName,
                            "Message_Type" => $type,
                        )
                    ),
                    $group
                ),
                $this->MyMod_Handle_Infos_Test($edit,$id,$title,$fhash,$type)
            );
    }

    //*
    //* Handles module object sys info.
    //*

    function MyMod_Handle_Info_Form_Hide_Show_Button($groupno)
    {
        return
            $this->Htmls_Hide_Button_ByClass
            (
                "Messages_Hide",
                "Language_".$groupno,
                $this->MyMod_Handle_Info_Message_Hide_Should($groupno)
            );
    }
    //*
    //* Handles module object sys info.
    //*

    function MyMod_Handle_Infos_Test($edit,$id,$title,$fhash,$type)
    {
        $table=array();
        $n=1;
        foreach ($fhash as $key => $hash)
        {
            $found=False;
            foreach ($this->LanguagesObj()->ItemHashes as $rid => $rhash)
            {
                if
                    (
                        $rhash[ "Message_Key" ]==$key
                    )
                {
                    $found=True;
                }
            }

            if (!$found)
            {
                $table=
                    array_merge
                    (
                        $table,
                        $this->MyMod_Handle_Info_Rows
                        (
                            $edit,
                            $ngroup=1,
                            $n++,
                            $key,$fhash,$type
                        )
                    );
            }
        }

        if (empty($table))
        {
            return $this->H(2,"FHash same number of Messages: OK!");
        }
        
        return
            array
            (
                $this->H(2,"In FHash, but no in Messages:"),
                $this->Htmls_Table
                (
                    "",
                    $table
                )
            );
    }
}

?>