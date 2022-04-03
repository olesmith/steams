<?php

trait MyMod_Handle_Add_Datas
{
    //*
    //* List of datas to include in add form.
    //*

    function MyMod_Handle_Add_Datas()
    {
        $rdatas=$this->MyMod_Data_Allowed_Get(0);
        $datas=array();
        foreach ($rdatas as $data)
        {
            if ($this->MyMod_Handle_Add_Data_Should($data))
            {
                array_push($datas,$data);
            }
        }
        
        if
            (
                is_array($this->AddDatas)
                &&
                count($this->AddDatas)>0
            )
        {
            $datas=array_merge($datas,$this->AddDatas);
        }

        return $datas;
    }
    //*
    //* List of datas to include in add form.
    //*

    function MyMod_Handle_Add_Data_Should($data)
    {
        $res=False;
        if (!empty($this->ItemData[ $data ][ "Add" ]))
        {
            $res=True;
        }
        
        if (!empty($this->ItemData[ $data ][ "NoAdd" ]))
        {
            $res=False;
        }

        if (!empty($this->ItemData[ $data ][ "Compulsory" ]))
        {
            $res=True;
        }
        
            
        return $res;
    }
}

?>