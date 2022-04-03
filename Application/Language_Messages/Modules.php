<?php

class Language_Messages_Modules extends Language_Messages_Groups
{
    var $Modules=array();
    
    //*
    //* function Language_Modules_Update, Parameter list: 
    //*
    //* 

    function Language_Modules_Update()
    {
        $this->NItems=0;
        $this->NAdded=0;
        $this->NUpdated=0;
        $messages=array();

        array_push($messages,$this->H(3,"Languages"));        
        foreach ($this->ApplicationObj()->Languages as $lang => $langhash)
        {
            $messages=
                array_merge
                (
                    $messages,
                    $this->Language_Module_Item_Update_Rows
                    (
                        "Languages",
                        "Languages.php",
                        $lang,
                        $langhash,
                        $this->Language_Message_Type
                    )
                );
        }
        
        array_push($messages,$this->H(3,"Modules"));
        foreach ($this->ApplicationObj()->SubModulesVars as $module => $hash)
        {
            $messages=array_merge
            (
                $messages,
                $this->Language_Module_Update($module,$hash)
            );
        }

        return
            array
            (
                $this->H(3,"Modules"),
                $this->Htmls_Table
                (
                    "",
                    $messages
                )
            );
    }
    
    //*
    //* function Language_Module_Update, Parameter list: 
    //*
    //* 

    function Language_Module_Update($module,$hash=array(),$force=False)
    {
        if (empty($hash))
        {
            $hash=$this->ApplicationObj()->SubModulesVars[ $module ];
        }
        
        $hash[ "File" ]="System/Modules.php";

        $messages=array();
        foreach (array("ItemName","ItemsName") as $data)
        {
            if (empty($hash[ $data ])) { continue; }
            
            $rhash=
                array
                (
                    "File" => $hash[ "File" ],
                    "Name" => $hash[ $data ]
                );
            
            foreach ($this->Language_Keys() as $lkey)
            {
                $rdata="Name"."_".$lkey;
                $rkey=$data."_".$lkey;
                
                $value=$hash[ $data ];
                if (!empty($hash[ $rkey ]))
                {
                    $value=$hash[ $rkey ];
                }
                $rhash[ $rdata ]=$value;
            }

            $messages=
                array_merge
                (
                    $messages,
                    $this->Language_Module_Item_Update_Rows
                    (
                        $module,
                        $rhash[ "File" ],
                        $data,
                        $rhash,
                        $this->Language_Module_Type,
                        $force
                    )
                );            
        }

        return $messages;
    }
   
    //*
    //* function Language_Module_Name_Singular, Parameter list: 
    //*
    //* 

    function Language_Module_ItemHash($moduleobj,$key="ItemName",$lang="",$msg_key="Name")
    {
        if (empty($this->Modules[ $moduleobj->ModuleName ]))
        {
            $this->Modules[ $moduleobj->ModuleName ]=array();
        }
        
        if (empty($this->Modules[ $moduleobj->ModuleName ][ $key ]))
        {
            $this->Modules[ $moduleobj->ModuleName ][ $key ]=
                $this->Language_Message_Get
                (
                    $this->Language_Module_Type,
                    $key,
                    array($msg_key),
                    $lang,
                    array("Module" => $moduleobj->ModuleName)
                );

            if ($this->Modules[ $moduleobj->ModuleName ][ $key ]==$key)
            {
                $this->MyLanguage_GetMessage_Locate_Try
                (
                    $this->Language_Module_Type,
                    $key,
                    array
                    (
                        "Module" => $moduleobj->ModuleName
                    )
                );
            }
        }

        return $this->Modules[ $moduleobj->ModuleName ];
    }
    
    //*
    //* function Language_Module_Name_Singular, Parameter list: 
    //*
    //* 

    function Language_Module_ItemName($moduleobj,$key="ItemName",$lang="",$msg_key="Name")
    {
        $mhash=
            $this->Language_Module_ItemHash($moduleobj,$key,$lang,$msg_key);
        
        return $this->Message_Debug_Pre.$mhash[ $key ];
    }
        
    //*
    //* function Language_Module_Name_Plural, Parameter list:
    //*
    //* Generates (returns) full submenu entry, incl. title.
    //*

    function Language_Module_ItemsName($moduleobj,$key="ItemsName",$lang="")
    {
        return $this->Language_Module_ItemName($moduleobj,$key,$lang);
    }
    
    //*
    //* function Language_Module_Filter, Parameter list: $moduleobj,$text
    //*
    //* 

    function Language_Module_Filter($moduleobj,$text)
    {
        return
            preg_replace
            (
                '/#ItemName(_\S\S)?/',
                $this->Language_Module_ItemName($moduleobj),
                preg_replace
                (
                    '/#ItemsName(_\S\S)?/',
                    $this->Language_Module_ItemsName($moduleobj),
                    $text
                )
            );
    }
}
?>