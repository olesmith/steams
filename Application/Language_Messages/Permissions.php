<?php

class Language_Messages_Permissions extends Language_Messages_Module
{
    //*
    //* Handles edit of one message permissions
    //* 

    function Language_Message_Permissions()
    {
        $edit=1;

        $items=array($this->ItemHash);
        
        $items=$this->MyMod_Items_Update($items);
        
        $this->Htmls_Echo
        (
            array
            (
                $this->Htmls_Form
                (
                    $edit,
                    "Edit_Permission_".$this->ItemHash[ "ID" ],
                    $action="",
                    $this->MyMod_Items_Group_Table_Html
                    (
                        1,
                        $items,
                        "",
                        "Permissions"
                    ),
                    array
                    (
                        "Buttons" => $this->Buttons()
                    )
                )
            )
        );
        
    }
    
    //*
    //* 

    function Permissions_Preset($type,$msgkey,$module,$permvalue)
    {
        $profile=$this->Profile();
        $logintype=$this->LoginType();
        $key=$type."_".$msgkey."_".$module;
        
        $this->__Permissions_Read__($type,$msgkey,array(),$module);

        foreach (array($profile,$logintype) as $pkey)
        {
            $this->Permissions[ $key ][ $pkey ]=
                $this->Min
                (
                    $permvalue,
                    $this->Permissions[ $key ][ $pkey ]
                );
        }
    }
    
    //*
    //* function Permissions_File_2_Item, Parameter list: 
    //*
    //* 

    function Permissions_File_2_Item($hash,&$dbitem,$module="",$key="")
    {
        if (empty($dbitem[ "ID" ])){ return; }
       
        $profiles=$this->ApplicationObj()->ValidProfiles;
        array_push($profiles,"Person");

        $this->Sql_Select_Hash_Datas_Read($dbitem,$profiles);

        $rdbitem=$dbitem;
         
        $updatedatas=array();
        foreach ($profiles as $profile)
        {
            $perm=0;
            if (!empty($hash[ $profile ]))
            {
                $value=0;
                if (isset($hash[ "Public" ]))
                {
                    $value=$hash[ "Public" ];
                }
                
                if (isset($hash[ $profile ]))
                {
                    $value=$hash[ $profile ];
                }
                
                if
                    (
                        !isset($dbitem[ $profile ])
                        ||
                        $dbitem[ $profile ]!=$value
                    )
                {
                    $dbitem[ $profile ]=$value;
                    array_push($updatedatas,$profile);
                }
            }
        }

        if (count($updatedatas)>0 && !empty($dbitem[ "ID" ]))
        {
            $name=$dbitem[ "Message_Key" ];
            if (!empty($dbitem[ "Name_PT" ]))
            {
                $name=$dbitem[ "Name_PT" ];
            }
            elseif (!empty($dbitem[ "Name" ]))
            {
                $name=$dbitem[ "Name" ];
            }
            
            var_dump
                (
                    "Updating permissions, key: ".$name.": ".
                    join(", ",$updatedatas),
                    $this->MyHash_Dump($rdbitem,$updatedatas),
                    $hash
                );
            #var_dump($hash);
            $this->Sql_Update_Item_Values_Set($updatedatas,$dbitem);
        }
    }

    var $__Permissions__=array();
    
    //*
    //* function __Permissions_Read__, Parameter list: 
    //*
    //* 

    function __Permissions_Read__($type,$msgkey,$msghash,$module="")
    {
        $key=$type."_".$msgkey."_".$module;
        
        if
            (
                !isset($this->Permissions[ $key ])
                ||
                !isset($this->Permissions[ $key ][ $this->Profile() ])
                ||
                !isset($this->Permissions[ $key ][ $this->LoginType() ])
            )
        {
            $where=
                array
                (
                    "Message_Type" => $type,
                    "Message_Key" => $msgkey,
                    "Module" => $module,
                );
            
            $this->Permissions[ $key ]=
                $this->Sql_Select_Hash
                (
                    $where,
                    array
                    (
                        "ID",
                        "Message_Type",
                        "Message_Key",
                        $this->LoginType(),
                        $this->Profile(),
                        "Person",
                        "Module",
                    )
                );

            if (empty($this->Permissions[ $key ]))
            {
                $this->Permission_Restore_From_Other
                (
                    $type,$msgkey,$where
                );
            }
            
            $this->MyMod_Permissions_Hash_Take
            (
                $this->Permissions[ $key ],
                $msghash
            );
        }
        
        return $this->Permissions[ $key ];
    }
        
    //*
    //* function Permissions_Has, Parameter list: 
    //*
    //* 

    function Permissions_Get($type,$msgkey,$msghash,$module="")
    {
        return
            $this->__Permissions_Read__
            (
                $type,$msgkey,$msghash,$module
            );
    }
    
    //*
    //* function Permissions_Has, Parameter list: 
    //*
    //* 

    function Permission_Restore_From_Other($type,$msgkey,$where)
    {
        foreach ($this->Message_Tables as $table)
        {
            $msg=
                $this->Sql_Select_Hash
                (
                    $where,
                    array(),
                    False,
                    $table);

            if (empty($msg)) { continue; }
            
            unset($msg[ "ID" ]);
            var_dump
            (
                "Permissions Found in ".$table,
                
                $type,$msgkey,$where,
                $this->Sql_Insert_Item($msg),
                "Restored!"
            );
            //$this->CallStack_Show();
        }
    }
    
    //*
    //* 
    //* 

    function Permissions_Get_Query($type,$msgkey,$module="")
    {
        return
               $this->Sql_Select_Hash_Query
                (
                    array
                    (
                        "Message_Type" => $type,
                        "Message_Key" => $msgkey,
                        "Module" => $module,
                    ),
                    array
                    (
                        "ID",
                        "Message_Key",
                        $this->Profile(),
                        "Person",
                        "Module",
                    )
                );
            
    }
    
    //*
    //* 
    //* 

    function Permissions_Data_Add()
    {
        $permdef=
            $this->ReadPHPArray
            (
                $this->ApplicationObj()->MyApp_Setup_Root().
                "/Application/System/Languages/Permission.php"
            );

        $lkey="Name_".$this->ApplicationObj->Language;
        
        $profiles=$this->ApplicationObj()->ValidProfiles;
        array_push($profiles,"Person");
        
        foreach ($profiles as $profile)
        {
            $this->ItemData[ $profile ]=$permdef;
            
            $hash=
                $this->Sql_Select_Hash
                (
                    array
                    (
                        "Message_Type" => $this->Language_Profile_Type,
                        "Message_Key" => $profile,
                    ),
                    array("ID",$lkey)
                );
            
            $this->ItemData[ $profile ][ "Name" ]=$hash[ $lkey ];
        }

        $this->Sql_Table_Structure_Update();
    }

    //*
    //* 
    //* 

    
    function Permissions_Data_Groups_Add()
    {
        $groupname="Permissions";
        $profiles=$this->ApplicationObj()->ValidProfiles;
        array_push($profiles,"Person");

        #Groups
        $this->ItemDataGroups[ $groupname ]=
            $this->ReadPHPArray
            (
                $this->ApplicationObj()->MyApp_Setup_Root().
                "/Application/System/Languages/Permission.Group.php"
            );

        $this->ItemDataGroups[ $groupname ][ "Data" ]=
            array_merge
            (
                $this->ItemDataGroups[ $groupname ][ "Data" ],
                $profiles
            );


        
        #Groups
        $this->ItemDataSGroups[ $groupname ]=
            $this->ReadPHPArray
            (
                $this->ApplicationObj()->MyApp_Setup_Root().
                "/Application/System/Languages/Permission.SGroup.php"
            );

        $this->ItemDataSGroups[ $groupname ][ "Data" ]=
            array_merge
            (
                $this->ItemDataSGroups[ $groupname ][ "Data" ],
                $profiles
            );
    }
}
?>