<?php


trait MyMod_Handle_Test_Data
{
    //*
    //*
    //*

    function MyMod_Handle_Test_Data_Status_Cell($n,$item,$data)
    {
        $status=$this->MyMod_Handle_Test_Status_Data($n,$item,$data);

        if ($status>0)
        {
            $status="OK";
        }
        elseif ($status==0)
        {
            $status="Empty";
        }
        else //<0
        {
            $status="Error: ".$item[ $data ];

            if (method_exists($this,"MyMod_Handle_Test_Data_Correct"))
            {
                $this->MyMod_Handle_Test_Data_Correct($n,$item,$data);
            }
        }
        
        return $status;
    }
}

?>