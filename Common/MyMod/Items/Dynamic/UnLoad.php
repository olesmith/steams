<?php

trait MyMod_Items_Dynamic_UnLoad
{
    //*
    //* Method to call on each item, in order to check and include
    //* automatic loading on $items.
    //* If defined, call on each $item.
    //*

    function MyMod_Items_Dynamic_UnLoads_JS($action,$items,$group)
    {
        $ids=$this->MyMod_Items_Dynamic_UnLoads($action,$items,$group);
       
    }
    
    //*
    //* Method to call on each item, in order to check and include
    //* automatic loading on $items.
    //* If defined, call on each $item.
    //*

    function MyMod_Items_Dynamic_UnLoads($action,$items,$group)
    {
        return
            $this->JS_Hide_Elements_By_ID
            (
                $this->MyMod_Item_Dynamic_Destination_Cell_Action_IDs
                (
                    $action,$items,$group
                )
            );
    }
}

?>