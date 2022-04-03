<?php


trait MyMod_Data_Fields_Module_Filter
{
    //*
    //* function MyMod_Data_Fields_Module_Filter, Parameter list: $data,$title=FALSE
    //*
    //* Returns slq object to apply - or null.
    //*

    function MyMod_Data_Fields_Module_Filter($data,$title=FALSE)
    {
        $key="SqlFilter";
        if ($title) { $key="SqlTitleFilter"; }

        $filter="";
        if (!empty($this->ItemData[ $data ][ $key ]))
        {
            $filter=$this->ItemData[ $data ][ $key ];
        }
        else
        {
            $filter=
                $this->SubModulesVars
                (
                    $this->MyMod_Data_Field_Is_Module($data),
                    $key
                );
        }

        return $filter;
    }
}

?>
