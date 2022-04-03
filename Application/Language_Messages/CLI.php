<?php

class Language_Messages_CLI extends ModulesCommon
{
    //*
    //* Runs CLI commands for Messages table: remove ancient actions and create default
    //* actions, item data and groups.
    //*

    function Language_Messages_CLI($args)
    {
        $subaction="All";
        if (count($subaction)>=3)
        {
            $subaction=$args[3];
        }
        var_dump($args,$subaction);
        exit();

        if (preg_match('/^(All|Actions)$/i',$subaction))
        {
            $this->Language_Messages_CLI_Actions_Delete_Some($args);        
            $this->Language_Messages_CLI_Actions_Defaults_Insert($args);
        }
        

        if (preg_match('/^(All|Data)$/i',$subaction))
        {
            $this->Language_Messages_CLI_ItemData_Defaults_Insert($args);
        }

        if (preg_match('/^(All|Groups)$/i',$subaction))
        {        
            $this->Language_Messages_CLI_ItemGroups_Defaults_Insert($args);
        }
    }
    
    //*
    //* Runs CLI commands for Messages table: remove ancient actions and create default
    //* actions, item data and groups.
    //*

    function Language_Messages_CLI_ItemData_Defaults_Insert($args)
    {
        $this->Language_Messages_CLI_Defs_Defaults_Insert
        (
            "Data.Defaults.php",
            "_ItemData_",
            $this->Language_Data_Type
        );
    }
    
    
    //*
    //* Runs CLI commands for Messages table: remove ancient actions and create default
    //* actions, item data and groups.
    //*

    function Language_Messages_CLI_ItemGroups_Defaults_Insert($args)
    {
        $this->Language_Messages_CLI_Defs_Defaults_Insert
        (
            "Groups.Defaults.php",
            "_Groups_",
            $this->Language_Group_Type
        );
        $this->Language_Messages_CLI_Defs_Defaults_Insert
        (
            "SGroups.Defaults.php",
            "_SGroups_",
            $this->Language_SGroup_Type
        );
    }
    
    //*
    //* Runs CLI commands for Messages table: remove ancient actions and create default
    //* actions, item data and groups.
    //*

    function Language_Messages_CLI_Actions_Defaults_Insert($args)
    {
        $this->Language_Messages_CLI_Defs_Defaults_Insert
        (
            "Actions.Defaults.php",
            "_Actions_",
            $this->Language_Action_Type
        );
    }
    
    //*
    //* Runs CLI commands for Messages table: remove ancient actions and create default
    //* actions, item data and groups.
    //*

    function Language_Messages_CLI_Defs_Defaults_Insert($file,$module_,$type)
    {
        $defs=
            $this->ReadPHPArray
            (
                $this->ApplicationObj()->MyApp_Setup_Root().
                "/Common/System/".$file
            );

        foreach ($defs as $key => $def)
        {
            $where=
                array
                (
                    "Module" => $module_,
                    "Message_Key" => $key,
                    "Message_Type" => $type,
                );

            if ($this->Sql_Select_NHashes($where)==0)
            {
                print "Inserting default $module_: $key\n";

                $newitem=
                    array_merge
                    (
                        $this->Language_Messages_CLI_Def_2_Message($def),
                        $where
                    );
                
                $this->Sql_Insert_Item($newitem);
            }
        }
    }
    
    //*
    //* 
    //*

    function Language_Messages_CLI_Def_2_Message($def)
    {
        foreach (array("PT","UK","ES") as $lang)
        {
            $lkey="MTime_".$lang;
            $newmessage[ $lkey ]=time();
        }
        
        foreach (array("Name","Title") as $key)
        {
            $newmessage[ $key."_PT" ]=$def[ $key ];
            foreach (array("UK","ES") as $lang)
            {
                        $lkey=$key."_".$lang;
                        $newmessage[ $lkey ]=$def[ $lkey ];
            }
        }
                
        foreach (array("ShortName") as $key)
        {
            if (!empty($actiondef[ $key ]))
            {
                $newmessage[ $key."_PT" ]=$def[ $key ];
                foreach (array("UK","ES") as $lang)
                {
                    $lkey=$key."_".$lang;
                    $newmessage[ $lkey ]=$def[ $lkey ];
                }
            }
        }

        foreach (array("Public","Person","Admin") as $key)
        {
            $newmessage[ $key ]=$def[ $key ];
        }
                
        foreach (array("AccessMethod") as $key)
        {
            $newmessage[ $key ]="";
            if (!empty($actiondef[ $key ]))
            {
                $newmessage[ $key ]=$def[ $key ];
            }
        }

        return $newmessage;
    }
    
    //*
    //* Runs CLI commands for Messages table: remove ancient actions and create default
    //* actions, item data and groups.
    //*

    function Language_Messages_CLI_Actions_Delete_Some($args)
    {
        $actions=
            array
            (
                "ComposedAdd",
                "Latex",
                "LatexList",
                "Print",
                "PrintList",
                "Process",
                "Profiles",
            );
        
        foreach ($actions as $action)
        {
            $message_ids=
                $this->Sql_Select_Unique_Col_Values
                (
                    "ID",
                    array
                    (
                        "Message_Type" => $this->Language_Action_Type,
                        "Message_Key"  => $action,
                        "__Module__" => "Module!='_Actions_'",
                    )
                );
            $this->Sql_Delete_Items
            (
                array
                (
                    "ID" => $message_ids,
                )
            );
            print $action." ".count($message_ids).": deleted\n";
        }
    }
}

?>