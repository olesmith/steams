<?php


trait MyMod_Handle_Test_Cells
{
    //*
    //*
    //*

    function MyMod_Handle_Test_Cell($n,$item,$data)
    {
        $cell=
            array
            (
                $this->MyMod_Data_Field(0,$item,$data),
            );

        if ($this->MyMod_Data_Field_Is_Module($data))
        {
            array_push
            (
                $cell,
                $this->MyMod_Handle_Test_Data_Status_Cell($n,$item,$data)
            );
        }

        return $cell;
    } 
}

?>