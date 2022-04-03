<?php

trait MyMod_API_CLI_Process_Item_Is
{
    //* 
    //* 
    //*

    function API_CLI_Process_Item_Is(&$api_item)
    {
        $this->SigaA_Trim($api_item);

        $item=
            $this->Sql_Select_Hash
            (
                $this->API_CLI_Process_Item_Unique_Where($api_item)
            );

        $res=empty($item);
        
        $is_sigaz=False;
        if (!empty($item))
        {
            $is_sigaz=True;
            $api_item[ $this->__Item_Key__ ]=$item;
            $api_item[ "Status" ]="Exists in DB";     
        }
        else
        {
            $api_item[ "Status" ]="Not in DB";     
        }
        
        return $is_sigaz;
    }
}

?>