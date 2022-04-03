<?php

trait MyMod_Data_Fields_Enums_Value
{
    //*
    //* 
    //*

    function MyMod_Data_Field_Enum_Value($data,$value,$ignoredefault)
    {
        if
            (
                empty($value)
                &&
                isset($item[ $data ])
            )
        {
            $value=$item[ $data ];
        }

        if
            (
                empty($value)
                &&
                !$ignoredefault
                &&
                $this->ItemData[ $data ][ "Default" ]
            )
        {
            $value=
                $this->ItemData[ $data ][ "Default" ];
        }
        
        return $value;
    }
}

?>