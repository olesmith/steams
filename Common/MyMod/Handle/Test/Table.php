<?php


trait MyMod_Handle_Test_Table
{
    //*
    //*
    //*

    function MyMod_Handle_Test_Table()
    {
        $ids=
            $this->Sql_Select_Unique_Col_Values
            (
                "ID",
                array(),
                "ID"
            );

        $table=array();
        $n=0;
        foreach ($ids as $id)
        {
            $item=
                $this->Sql_Select_Hash
                (
                    array("ID" => $id),
                    $this->MyMod_Handle_Test_Datas_Read()
                );

            $status=$this->MyMod_Handle_Test_Status($n,$item);

            if (!$status)
            {
                $n++;
            
                array_push
                (
                    $table,
                    $this->MyMod_Handle_Test_Row($n,$item)
                );
            }
        }

        return $table;
    }
 }

?>