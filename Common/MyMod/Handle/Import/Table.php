<?php


trait MyMod_Handle_Import_Table
{
    //*
    //* Generates detected items table.
    //*

    function MyMod_Handle_Import_Table()
    {
        $items=
            $this->MyMod_Handle_Import_Detect_Items();

        $n=0;
        $table=array();
        foreach ($items as$item)
        {
            $n++;
            
            $item[ "No" ]=$n;
            array_push
            (
                $table,
                $this->MyMod_Handle_Import_Item_Row($item)
            );
        }

        return $table;
    }
}
?>