<?php


trait MyMod_Handle_Import_Update
{
    //*
    //* Updates detected $items.
    //*

    function MyMod_Handle_Import_Update_Items(&$items)
    {
        $html=array();
        foreach (array_keys($items) as $id)
        {
            array_push
            (
                $html,
                $this->MyMod_Handle_Import_Update_Item($items[ $id ])
            );
        }

        return $html;
    }

    
    function MyMod_Handle_Import_Update_Item(&$item)
    {
        $item=
            $this->MyMod_Handle_Import_Item_Status($item);

        if ($item[ "Status" ])
        {
            $item=
                $this->MyMod_Handle_Import_Item_Post_Process($item);
        }

        $check=
            $this->MyMod_Handle_Import_Item_Add_Cell_CGI_Value($item);

        
        $html=array();       
        if (intval($check)==1)
        {
            $ritem=
                $this->MyMod_Handle_Import_Item_New($item);

            $this->Sql_Insert_Item($ritem);

            $item[ "Status" ]=False;
            $item[ "Status_Message" ]="Added";
        }
        
        return $html;
    }
    
}
?>