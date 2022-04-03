<?php

trait MyMod_Data_Fields_Enums_Title
{
    //*
    //* 
    //*

    function MyMod_Data_Field_Enum_Title($data,$titles,$value)
    {
        if (is_array($value)) { $value=array_shift($value); }
        
        $title="";
        if ($value>0)
        {
            $title='untitled';
            if (isset($titles[ $value ]))
            {
                $title=$titles[ $value ];
            }
        }
        else
        {
            $title=
                $this->MyLanguage_GetMessage("Select").
                $this->MyMod_Data_Title($data,True);
        }
        
        return $title;
    }
}

?>