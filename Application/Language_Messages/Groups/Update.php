<?php

trait Language_Messages_Groups_Update
{
    //*
    //* function Language_Groups_Update, Parameter list: 
    //*
    //* 

    function Language_Groups_Update()
    {
        $this->ItemData();
        $this->ItemDataGroups();
        $this->Actions();
        
        $pmessages=array();        
        $smessages=array();        
        foreach ($this->ApplicationObj()->MyApp_Modules_Get() as $module)
        {
            $msgs=$this->Language_Groups_Module_Update($module);
            
            $pmessages=array_merge
            (
                $pmessages,
                $msgs[0]
            );
            $smessages=array_merge
            (
                $smessages,
                $msgs[0]
            );
        }

        array_unshift
        (
            $pmessages,
            array
            (
                "Items:",$this->NItems,
                "Added:",$this->NAdded,
                "Updated:",$this->Updated,
            )
        );

        return
            array
            (
                $this->H(3,"Module Groups in Files"),
                $this->Htmls_Table
                (
                    "",
                    $pmessages
                ),
                $this->H(3,"Module SGroups in Files"),
                $this->Htmls_Table
                (
                    "",
                    $smessages
                ),
            );
    }
    
    //*
    //* function Language_Groups_Update, Parameter list: 
    //*
    //* 

    function Language_Groups_Module_Update($module)
    {
        $method=$module."Obj";

        $this->$method()->ItemData();
        $this->$method()->ItemDataGroups();

        $pmessages=array("Module: ".$module);        
        foreach ($this->$method()->ItemDataGroups as $groupname => $hash)
        {
            $pmessages=
                array_merge
                (
                    $pmessages,
                    $this->Language_Group_Update
                    (
                        $module,
                        $groupname,
                        $this->Language_Group_Type,
                        $hash
                    )
                );
        }
        
        $smessages=array("Module: ".$module);        
        foreach ($this->$method()->ItemDataSGroups as $groupname => $hash)
        {
            $smessages=
                array_merge
                (
                    $smessages,
                    $this->Language_Group_Update
                    (
                        $module,
                        $groupname,
                        $this->Language_SGroup_Type,
                        $hash
                    )
                );
        }
        
        return array($pmessages,$smessages);
    }
    
    //*
    //* function Language_Group_Module_Update, Parameter list: 
    //*
    //* 

    function Language_Group_Update($module,$groupname,$type,$hash)
    {
        if (empty($hash[ "File" ]))
        {
            $hash[ "File" ]=$module.".php";
        }
        elseif (is_array($hash[ "File" ]))
        {
            $hash[ "File" ]=array_pop($hash[ "File" ]);
        }
            
        return
            $this->Language_Module_Item_Update_Rows
            (
                $module,
                $hash[ "File" ],
                $groupname,
                $hash,
                $type,
                $force=False,$updateperms=True
            );
    }
}
?>