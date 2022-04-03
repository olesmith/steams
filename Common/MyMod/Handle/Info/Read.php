<?php


trait MyMod_Handle_Info_Read
{
    //*
    //* Reads message from DB.
    //*

    function MyMod_Handle_Info_Message_Read($edit,$key,$type)
    {
        $message=
            $this->LanguagesObj()->Sql_Select_Hash
            (
                array
                (
                    "Message_Type" => $type,
                    "Message_Key" => $key,
                    "Module" => $this->ModuleName,                    
                )
            );
        
        $message=$this->LanguagesObj()->PostProcess($message,$force=True);

        $this->MyMod_Handle_Info_Update_Message($message,$edit);
              
        return $message;
    }
}

?>