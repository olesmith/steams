<?php

trait Language_Messages_Actions_Update
{
    //*
    //* function Language_Actions_Update, Parameter list: 
    //*
    //* 

    function Language_Actions_Update()
    {
        $modules=$this->ApplicationObj()->MyApp_Modules_Get();

        $this->NItems=0;
        $this->NAdded=0;
        $this->Updated=0;
        $modules=
            array_merge
            (
                array("Application"),
                $this->ApplicationObj()->MyApp_Modules_Get()
            );
        
        $messages=array();        
        foreach ($modules as $module)
        {
            $messages=array_merge
            (
                $messages,
                array("Module: ".$module),
                $this->Language_Actions_Module_Update($module)
            );
        }

        return
            array
            (
                $this->H(3,"Module Actions in Files"),
                $this->Htmls_Table
                (
                    "",
                    $messages
                )
            );
    }
    
    //*
    //* function Language_Actions_Module_Update, Parameter list: 
    //*
    //* 

    function Language_Actions_Module_Update($module)
    {
        $messages=array("Module: ".$module);        

        $method=$module."Obj";
        foreach ($this->$method()->Actions() as $actionname => $action)
        {
            if (empty($action[ "File" ]))
            {
                $action[ "File" ]=$module.".php";
            }
            elseif (is_array($action[ "File" ]))
            {
                $action[ "File" ]=array_pop($action[ "File" ]);
            }

            $messages=
                array_merge
                (
                    $messages,
                    $this->Language_Module_Item_Update_Rows
                    (
                        $module,
                        $action[ "File" ],
                        $actionname,
                        $action,
                        $this->Language_Action_Type,
                        $force=False,$updateperms=True
                    )
                );
        }
        
        return $messages;
    }
}
?>