<?php

class DBGroupsLanguages extends DBGroupsForm
{

    //*
    //* Checks if $item may be edited. Admin may -
    //* and Person, if LoginData[ "ID" ]==$item[ "ID" ].
    //*

    function Languages_Init_ItemData()
    {
        $defs=
            $this->ReadPHPArray
            (
                $this->ApplicationObj()->MyApp_Setup_Path().
                "/GroupDatas/Languaged.php"
            );

        $this->Languaged_Datas=array_keys($defs);

        foreach ($this->Languaged_Datas as $data)
        {
            $ddata=$data."_PT";
            $this->Sql_Table_Column_Rename($data,$ddata);

            $msg=
                $this->LanguagesObj()->Sql_Select_Hash
                (
                    array
                    (
                        "Module"       => $this->ModuleName,
                        "Message_Type" => $this->LanguagesObj()->Language_Data_Type,
                        "Message_Key"  => $data,
                    )
                );

            if (!empty($msg) && !empty($msg[ "ID" ]))
            {
                $this->LanguagesObj()->Sql_Update_Item_Value_Set
                (
                    $msg[ "ID" ],
                    "Message_Key",
                    $ddata
                );
            }
        }
        
        foreach ($this->LanguagesObj()->Language_Keys() as $lang)
        {
            foreach ($defs as $data => $def)
            {
                $ldata=$data."_".$lang;
                
                $this->ItemData[ $ldata ]=$def;
            }
        }
    }
    
    //*
    //* Checks if $item may be edited. Admin may -
    //* and Person, if LoginData[ "ID" ]==$item[ "ID" ].
    //*

    function Language_Item_PostProcess(&$item,$updatedatas=array())
    {
        foreach (array("Text","Title","SValues") as $data)
        {
            $updatedatas=
                $this->MyMod_Item_Language_Data_Defaults
                (
                    $item,
                    "Text",
                    $updatedatas
                );
        }

        return $updatedatas;
    }
}

?>