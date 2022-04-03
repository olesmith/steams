<?php


trait MyMod_Handle_Test_Status
{
   //*
    //*
    //*

    function MyMod_Handle_Test_Status($n,&$item)
    {
        $status=True;
        foreach ($this->MyMod_Data_Fields_Is_Module() as $data)
        {
            if ($this->MyMod_Handle_Test_Status_Data($n,$item,$data)<=0)
            {
                $status=False;
            }
        }

        if (!$status)
        {
            //$item=$this->PostProcess($item);
        }
        
        return $status;
    }

    
    //*
    //*
    //*

    function MyMod_Handle_Test_Status_Data($n,$item,$data)
    {
        if ($data=="ID") { return 1; }

        $status=0;
        if (!empty($item[ $data ]))
        {
            $status=1;
            
            $subitem=
                $this->MyMod_Data_Module_Object($data)->Sql_Select_Hash
                (
                    array
                    (
                        "ID" => $item[ $data ],
                    ),
                    array("ID")
                );

            if (empty($subitem))
            {
                $status=-1;
            }
        }
        
        return $status;
    }
    
}

?>