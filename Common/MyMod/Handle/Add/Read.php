<?php

trait MyMod_Handle_Add_Read
{
    //* 
    //* Simply return array $this->AddFixedValues.
    //* Meant to be overridden.
    //*

    function MyMod_Handle_Add_Fixed()
    {
        return $this->AddFixedValues;
    }
    
    //* 
    //* Complete add item read. Defaults, fixed values and from POST, then get.
    //*

    function MyMod_Handle_Add_Read()
    {
        $item=$this->AddDefaults;
        
        $item=
            $this->MyMod_Item_POST_Read($item);
        
        foreach (array_keys($this->ItemData) as $data)
        {
            $get=$this->CGI_GET($data);
            if (!empty($get))
            {
                $item[ $data ]=$get;
            }
        }

        $item=
            array_merge
            (
                $item,
                $this->MyMod_Handle_Add_Fixed()
            );

        return $item;
    }
}

?>