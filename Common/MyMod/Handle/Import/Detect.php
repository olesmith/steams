<?php


trait MyMod_Handle_Import_Detect
{
    //*
    //* Detetect items in uploaded file or in CGI.
    //*

    function MyMod_Handle_Import_Detect_Items()
    {
        $items=array();
        if ($this->CGI_POSTint("Detect")==1)
        {
            $items=$this->MyMod_Handle_Import_Read_Items_From_File();
        }
        elseif ($this->CGI_POSTint("Save")==1)
        {
            $items=$this->MyMod_Handle_Import_Read_Items_From_CGI();
            $html=$this->MyMod_Handle_Import_Update_Items($items);
        }

        return $items;
    }
    
    //*
    //* Detetect status for $item.
    //*

    function MyMod_Handle_Import_Item_Status(&$item)
    {
        $item[ "Status" ]=True;
        $item[ "Status_Message" ]="";

        return $item;
    }
    //*
    //* Detetect status for $item.
    //*

    function MyMod_Handle_Import_Item_Post_Process(&$item)
    {
        return $item;
    }
    //*
    //* Detetect status for $item.
    //*

    function MyMod_Handle_Import_Item_New($item)
    {
        return $item;
    }
}
?>