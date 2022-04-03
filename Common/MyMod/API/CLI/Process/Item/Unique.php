<?php

trait MyMod_API_CLI_Process_Item_Unique
{
    //*
    //* Unique sql where, locating $api_item.
    //*

    function API_CLI_Process_Item_Unique_Where($api_item)
    {
        $sigaa_datas=
            array_merge
            (
                array($this->SigaA_Args_Key()),
                $this->SigaA_Args_Unique()
            );
        
        $where=array();
        foreach ($sigaa_datas as $sigaa_data)
        {
            $sigaz_data=$this->SigaA_Args_A2Z($sigaa_data);

            $sigaa_value=$api_item[ $sigaa_data ];
            $sigaz_value=$sigaa_value;
            if ($this->MyMod_Data_Field_Is_Module($sigaz_data))
            {
                //is sigaa_id, we must try to resolve sigaz_id.
                $module=$this->MyMod_Data_2Module($sigaz_data);

                $sigaz_value=
                    $module->Sql_Select_Hash_Value
                    (
                        $sigaa_value,
                        "ID",
                        "Sigaa_ID"
                    );
            }
            
            $where[ $sigaz_data ]=$sigaz_value;
        }

        return $where;
    }    
}

?>