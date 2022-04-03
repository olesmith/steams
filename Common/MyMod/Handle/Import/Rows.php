<?php


trait MyMod_Handle_Import_Rows
{
    //*
    //* Generates item row.
    //*

    function MyMod_Handle_Import_Item_Row(&$item)
    {
        $row=array($this->B($item[ "No" ]));

        foreach ($this->Import_Datas as $data)
        {
            $cell="-";
            $value="";
            if (!empty($item[ $data ]))
            {
                $cell=$value=$item[ $data ];
            }
            
            array_push
            (
                $row,
                $cell.
                $this->MakeHidden($item[ "No" ]."_".$data,$value)
            );
        }

        array_push
        (
            $row,
            $this->MyMod_Handle_Import_Item_Status_Cell($item),
            $this->MyMod_Handle_Import_Item_Add_Cell($item)
        );        

        return $row;
    }
}
?>