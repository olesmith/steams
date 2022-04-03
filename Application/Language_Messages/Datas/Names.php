<?php

trait Language_Messages_Datas_Names
{
    //*
    //* function Language_Data_Names, Parameter list: $moduleobj
    //*
    //* Data keys to attempt, retrieving data Names.
    //*

    function Language_Data_Names($moduleobj)
    {
        return
            array
            (
                $moduleobj->TitleKeyShortName,
                $moduleobj->TitleKeyName,
                $moduleobj->TitleKeyTitle,
            );
    }
    
    //*
    //* function Language_Data_Name_Get, Parameter list: $module,$key
    //*
    //* Retrieve (if necessary) and store message item from DB.
    //*

    function Language_Data_Names_Read($module_obj,$data)
    {
        $module_name=$module_obj->ModuleName;
        if (empty($this->Datas[ $module_name ]))
        {
            $this->Datas[ $module_name ]=array();
        }
        
        if (!array_key_exists($data,$this->Datas[ $module_name ]))
        {
            $this->Datas[ $module_name ][ $data ]=
                $this->Language_Module_Filter
                (
                    $module_obj,
                    $this->Language_Message_Item_Get
                    (
                        $this->Language_Data_Type,
                        $data,
                        $this->Language_Data_Read($module_obj),
                        "",
                        array("Module" => $module_name)
                    )
                );
        }
    }
    
    //*
    //* function Language_Data_Empty_Name_Get, Parameter list: $module,$data
    //*
    //* Retrieve the Item data 
    //*

    function Language_Data_Empty_Name_Get($moduleobj,$data)
    {
        if (empty($this->Datas[ $moduleobj->ModuleName ]))
        {
            $this->Datas[ $moduleobj->ModuleName ]=array();
        }

        $empty_data=$data."_Empty";
        if (!array_key_exists($empty_data,$this->Datas[ $moduleobj->ModuleName ]))
        {
            $this->Datas[ $moduleobj->ModuleName ][ $empty_data ]=
                $this->Language_Message_Item_Get
                (
                    $this->Language_Data_Type,
                    $empty_data,
                    $this->Language_Data_Read($moduleobj),
                    "",
                    array
                    (
                        "Module" => $moduleobj->ModuleName,
                    )
                );
        }

        $name_key="Name_".$this->ApplicationObj()->Language;
        
        return
            $this->Message_Debug_Pre.
            $this->Datas[ $moduleobj->ModuleName ][ $empty_data ][ $name_key ];
    }
    
    //*
    //* function Language_Data_Name_Get, Parameter list: $module,$data,$keys=array()
    //*
    //* Retrieve the Item data 
    //*

    function Language_Data_Name_Get($moduleobj,$data,$keys=array())
    {
        if (empty($keys)) { $keys=$this->Language_Data_Names($moduleobj); }
        
        $this->Language_Data_Names_Read($moduleobj,$data);
                
        $title="undef: ".$data;
        foreach ($keys as $key)
        {
            $rkey=$key."_".$this->ApplicationObj()->Language;
            if (!empty($this->Datas[ $moduleobj->ModuleName ][ $data ][ $rkey ]))
            {
                if ($this->Message_Debug_Pre_Should())
                {                    
                    $title=$this->Datas[ $moduleobj->ModuleName ][ $data ][ $rkey ];
                    
                    return
                        $this->Htmls_Text
                        (
                            array
                            (
                        
                                $this->Message_Debug_Pre
                                (
                                    $this->LanguagesObj()->Language_Data_Type,
                                    $data,
                                    array("Module" => $moduleobj->ModuleName)
                                ),
                                $title
                            )
                        );
                }
                
                return
                    $this->Message_Debug_Pre.
                    $this->Datas[ $moduleobj->ModuleName ][ $data ][ $rkey ];
            }
        }

        if (!empty($moduleobj->ItemData[ $data ]))
        {
            foreach ($keys as $key)
            {
                $title=$this->GetRealNameKey($moduleobj->ItemData[ $data ],$key);
                if (!empty($title)) { return $title; }
            }
        }
        
        return $title;
    }
}
?>