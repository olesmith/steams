<?php

trait MyMod_API_CLI_Process_Item_Update
{
    //*
    //* Update $api_item.
    //*

    function API_CLI_Process_Item_Update($api_item,&$item)
    {
        $updatedatas=array();
        foreach (array_keys($this->ItemData) as $data)
        {
            $value=
                $this->API_CLI_Process_Item_Update_Data
                (
                    $api_item,
                    $item,
                    $data
                );

            if
                (
                    !empty($value)
                    &&
                    (
                        empty($item[ $data ])
                        ||
                        $item[ $data ]!=$value
                    )
                )
            {
                $item[ $data ]=$value;
                array_push($updatedatas,$data);
            }
        }
        
        return $updatedatas;
    }
    
    //*
    //* Update $api_item $data.
    //*

    function API_CLI_Process_Item_Update_Data($api_item,&$item,$data)
    {
        $value="";
        if (!empty($this->ItemData[ $data ][ "Key" ]))
        {
            $keys=$this->ItemData[ $data ][ "Key" ];
            $rvalue=$api_item;
            foreach ($keys as $key)
            {
                if (isset($rvalue[ $key ]))
                {
                    $rvalue=$rvalue[ $key ];
                }
            }

            if (is_string($rvalue))
            {
                $value=
                    preg_replace
                    (
                        '/\'/',"&#39;",
                        $this->Text2Html($rvalue)
                    );

                if ($this->MyMod_Data_Field_Is_Module($data))
                {
                    $module_obj=
                        $this->MyMod_Data_Fields_Module_2Object($data);


                    $where=
                        array
                        (
                            $module_obj->SigaZ_Args_Key() => $rvalue,
                        );

                    $subitem=
                        $module_obj->Sql_Select_Hash
                        (
                            array
                            (
                                $module_obj->SigaZ_Args_Key() => $value,
                            ),
                            array("ID")
                        );

                    if (!empty($subitem) && !empty($subitem[ "ID" ]))
                    {
                        /* print */
                        /*     "\t\tResolved: ". */
                        /*     $data.", API ID: ". */
                        /*     $value." => ".$subitem[ "ID" ]. */
                        /*     " (". */
                        /*     $subitem[ "Name" ]. */
                        /*     ")\n"; */
                
                        $value=$subitem[ "ID" ];
                    }
                }
            }
        }

        return $value;
    }
}

?>