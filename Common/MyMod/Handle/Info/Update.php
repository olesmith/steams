<?php


trait MyMod_Handle_Info_Update
{
    //*
    //* 
    //*

    function MyMod_Handle_Info_Update_Message(&$message,$edit=0)
    {
        if ($edit==1 && $this->CGI_POSTint("Save")==1)
        {
            $message=
                $this->LanguagesObj()->MyMod_Item_Update_CGI
                (
                    $message,
                    array_merge
                    (
                        $this->MyMod_Handle_Info_Profile_Datas(),
                        $this->LanguagesObj()->Language_Message_Item_Language_Datas()
                    ),
                    $prepost=$message[ "ID" ]."_"
                );
        }
    }

    
 }

?>