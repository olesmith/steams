<?php

trait MyMod_Handle_Info_CGI
{
    //*
    //* Initializes: if POST Module is set, reloads as that module.
    //*

    function MyMod_Handle_Info_CGI_Type_Value()
    {
        $type=$this->CGI_GET("Type");
        //if (empty($type)) $type="Actions";

        return $type;
    }
    
    //*
    //* 
    //*

    function MyMod_Handle_Info_CGI_Language_Edit_Key($groupno)
    {
        return "Edit_Language_".$groupno;
    }
    
    //*
    //* 
    //*

    function MyMod_Handle_Info_CGI_Language_Edit_Value($groupno)
    {
        return
            $this->CGI_POSTint
            (
                $this->MyMod_Handle_Info_CGI_Language_Edit_Key($groupno)
            );
    }
    
    
    //*
    //* 
    //*

    function MyMod_Handle_Info_CGI_Language_Display_Should($groupno,$message)
    {
        foreach ($this->LanguagesObj()->Language_Keys() as $lang)
        {
            foreach (array("Name","Title") as $data)
            {
                if (empty($message[ $data."_".$lang ]))
                {
                    return True;
                }
            }
        }
        
        return
            $this->CGI_POSTint
            (
                $this->MyMod_Handle_Info_CGI_Language_Edit_Key($groupno)
            );
    }
}

?>