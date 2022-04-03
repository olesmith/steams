<?php

trait Language_Messages_Actions_Names
{
    //*
    //* function Language_Action_Names_Read, Parameter list: $module,$key
    //*
    //* 

    function Language_Action_Names_Read($moduleobj,$key)
    {
        if (empty($this->Actions_Messages[ $moduleobj->ModuleName ]))
        {
            $this->Actions_Messages[ $moduleobj->ModuleName ]=array();
        }
        
        if
            (
                !array_key_exists
                (
                    $key,
                    $this->Actions_Messages[ $moduleobj->ModuleName ]
                )
            )
        {

            $this->Actions_Messages[ $moduleobj->ModuleName ][ $key ]=
                $this->Language_Module_Filter
                (
                    $moduleobj,
                    $this->Language_Message_Item_Get
                    (
                        $this->Language_Action_Type,
                        $key,
                        array("Name","Title"),
                        "",
                        array
                        (
                            "Module" => array
                            (
                                $moduleobj->ModuleName,
                                "Application",
                            )
                        )
                    )
                );
        }
    }
    
    //*
    //* function Language_Action_Name_Get, Parameter list: $module,$key
    //*
    //* 

    function Language_Action_Name_Get($moduleobj,$key,$data="Name")
    {
        $datas=array("Name","Title");
        $this->Language_Action_Names_Read($moduleobj,$key);

        if
            (
                empty
                (
                    $this->Actions_Messages[ $moduleobj->ModuleName ][ $key ]
                    [ $data."_".$this->ApplicationObj()->Language ]
                )
            )
        {
            if (!empty($moduleobj->Actions[ $key  ]))
            {
                foreach ($datas as $data)
                {
                    $name=$this->GetRealNameKey($moduleobj->Actions[ $key ],$data);
                    if (!empty($name)) { return $name; }
                }
            }

            return "undef: ".$key." - module: ".$moduleobj->ModuleName;
        }
        
        return $this->Message_Debug_Pre.
            $this->Actions_Messages[ $moduleobj->ModuleName ][ $key ]
            [ $data."_".$this->ApplicationObj()->Language ];
    }
    
}
?>