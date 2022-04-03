<?php


trait MyMod_Handle_Test_Rows
{
    //*
    //*
    //*

    function MyMod_Handle_Test_Row($n,$item)
    {
        $row=
            array
            (
                $this->B($n),
            );
        
        foreach ($this->MyMod_Handle_Test_Datas_Show() as $data)
        {            
            array_push
            (
                $row,
                $this->MyMod_Handle_Test_Cell($n,$item,$data)
            );
        }

        array_push
        (
            $row,
            $this->MyMod_Handle_Test_Status($n,$item)
        );
        

        return $row;
    }
    
}

?>