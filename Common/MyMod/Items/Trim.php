<?php


trait MyMod_Items_Trim
{
    //*
    //* Trims all items, according to $ids and $datas.
    //*

    function MyMod_Items_Trim($datas,$ids=array())
    {
        if (count($ids)==0) { $ids=array_keys($this->ItemHashes); }

        foreach ($ids as $id)
        {
            $this->MyMod_Item_Trim($datas,$id);
        }
    }
}

?>