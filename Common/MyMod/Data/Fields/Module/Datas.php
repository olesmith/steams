<?php


trait MyMod_Data_Fields_Module_Datas
{
    //*
    //* Returns data to read for subitem $data.
    //*

    function MyMod_Data_Fields_Module_Datas($data)
    {
        $datas=$this->ItemData($data,"SqlDerivedData");
        
        if (empty($datas))
        {
            $datas=
                $this->SubModulesVars
                (
                    $this->MyMod_Data_Field_Is_Module($data),
                    "SqlDerivedData"
                );
        }

        if (!is_array($datas))
        {
            if (is_string($datas))
            {
                $datas=$this->MyMod_Data_2Module($data)->$datas($data);
            }
            else
            {
                var_dump("MyMod_Data_Fields_Module_Datas: SqlDerivedData is not list",$data,$datas);
                exit();
            }
        }

        //Make sure IDs will be read
        if (!preg_grep('/^ID$/',$datas)) { array_unshift($datas,"ID"); }

        return $datas;
    }
}

?>
