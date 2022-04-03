<?php

trait Language_Messages_Datas_Update
{
    //*
    //* Runs the import: create/update if ItemData
    //* Name and Title keys for all Application modules.
    //* Files to SQL Table.

    function Language_Datas_Update()
    {
        $this->NItems=0;
        $this->NAdded=0;
        $this->Updated=0;
        
        $messages=array();        
        foreach ($this->ApplicationObj()->MyApp_Modules_Get() as $module)
        {
            $messages=array_merge
            (
                $messages,
                $this->Language_Datas_Update_Module($module)
            );
        }

        return
            array
            (
                $this->H(3,"Module Datas in Files"),
                $this->Htmls_Table
                (
                    "",
                    $messages
                )
            );
    }
    
    //*
    //* Updates one module all ItemData.
    //*

    function Language_Datas_Update_Module($module)
    {
        $messages=array("Module: ".$module);        

        $method=$module."Obj";
        $moduleobj=$this->$method();
        foreach ($this->$method()->ItemData() as $dataname => $hash)
        {
            if (empty($hash[ "File" ]))
            {
                $hash[ "File" ]=$module.".php";
            }
            elseif (is_array($hash[ "File" ]))
            {
                $hash[ "File" ]=array_pop($hash[ "File" ]);
            }
            
            $messages=array_merge
            (
                $messages,
                $this->Language_Data_Update_Module_Data($moduleobj,$dataname,$hash)
            );
        }
        
        return $messages;
    }
    
    //*
    //* Add/create one item data hash def.
    //*

    function Language_Data_Update_Module_Data($moduleobj,$dataname,$hash)
    {
        if (empty($hash[ "File" ]))
        {
            $hash[ "File" ]=$module.".php";
        }
        elseif (is_array($hash[ "File" ]))
        {
            $hash[ "File" ]=array_pop($hash[ "File" ]);
        }
        
        $messages=array();
        $messages=
            array_merge
            (
                $messages,
                $this->Language_Module_Item_Update_Rows
                (
                    $moduleobj->ModuleName,
                    $hash[ "File" ],
                    $dataname,
                    $hash,
                    $this->Language_Data_Type,
                    $force=False,$updateperms=True
                )
            );

        $messages=
            array_merge
            (
                $messages,
                $this->Language_Data_Extras_Update($moduleobj,$dataname,$hash)
            );

       return $messages;
    }
}
?>