<?php

trait MyMod_Data_Fields_Enums_Options
{
    //*
    //*
    //*

    function MyMod_Data_Field_Enum_Options($data,$tabindex,$item)
    {
        $options=
            array
            (
                "ID" => join
                (
                    "_",
                    $this->MyMod_Data_Field_Enum_Classes($data,$item)
                ),
            );
        
        if (!empty($tabindex) ) { $options[ "TABINDEX" ]=$tabindex; }
        
        return $options;
    }

    
    //*
    //*
    //*

    function MyMod_Data_Field_Enum_Classes($data,$item)
    {
        $ids=
            array
            (
                $this->ModuleName,
                $data,                
            );
        
        if (!empty($item[ "ID" ]) )
        {
            array_push($ids,$item[ "ID" ]);
        }
        
        return $ids;
    }
}

?>