<?php

trait MyMod_API_CLI_Process_Item_Create
{
    //*
    //* Update $api_item.
    //*

    function API_CLI_Process_Item_Create($api_item)
    {
        $item=array();
        $this->API_CLI_Process_Item_Update($api_item,$item);

        $this->Sql_Insert_Item($item);

        return $item;
    }
 }

?>