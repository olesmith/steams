<?php

include_once("Language_Messages/CLI.php");
include_once("Language_Messages/DBHash.php");
include_once("Language_Messages/Access.php");
include_once("Language_Messages/MTimes.php");
include_once("Language_Messages/Types.php");
include_once("Language_Messages/Profiles.php");
include_once("Language_Messages/Messages.php");
include_once("Language_Messages/MenuItem.php");
include_once("Language_Messages/LeftMenu.php");
include_once("Language_Messages/Module.php");
include_once("Language_Messages/Permissions.php");
include_once("Language_Messages/Item.php");
include_once("Language_Messages/Actions.php");
include_once("Language_Messages/Datas.php");
include_once("Language_Messages/Group.php");
include_once("Language_Messages/Groups.php");
include_once("Language_Messages/Modules.php");
include_once("Language_Messages/Handle.php");
include_once("Language_Messages/DBs.php");

include_once("Language_Messages/Add.php");

class Language_Messages extends Language_Messages_DBs
{
    use
        Language_Messages_Add;
    
    var $Language_Message_Type=1;
    var $Language_Array_Type=2;
    var $Language_Profile_Type=3;
    var $Language_LeftMenu_Type=4;
    var $Language_MenuItem_Type=5;
    var $Language_Module_Type=6;
    var $Language_Action_Type=7;
    var $Language_Data_Type=8;
    var $Language_Group_Type=9;
    var $Language_SGroup_Type=10;
    var $Language_Help_Type=11;
    var $Language_Mail_Type=12;

    var $KeyDatas=array();
    var $LanguageKeyDatas=array();
    var $LanguageDataKeys=array();
    var $LanguageSubKeys=array();
    
    var $Groups=array();
    var $Datas=array();

    var $NItems=0;
    
    //*
    //* Constructor.
    //*

    function Language_Messages($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=array("Module","Message_Key","Message_Type");
        $this->Sort=array("Module","Message_Type","Message_Key");
        
        $this->ItemNamer="Message_Key";
        $this->ItemName_UK="Message";
        $this->ItemsName_UK="Messages";
        
        $this->MyMod_Group_Rows_Method="Language_Message_Item_Rows";

        $this->NItemsPerPage=20;
        $this->MyMod_Paging_NPages_In_Menu=$this->MyMod_Paging_NPages_Intermediate=40;
        $this->IncludeAllDefault=False;

        $this->CellMethods[ "Message" ]=TRUE;


        $this->IncludeAllDefault=TRUE;
        $this->Message_Debug_Pre=
            $this->ApplicationObj()->DBHash[ "Languages_Pre" ];
    }

    //*
    //* 
    //*

    function Message($edit=0,$item=array(),$data="")
    {
        if (empty($item))
        {
            return
                $this->MyMod_ItemName();
        }
        
        return
            $this->MyLanguage_GetMessage_DB
            (
                $item[ "Message_Key" ],
                $subkey="Name",$langkey="",
                $type=$item[ "Message_Type" ]
            );
    }

    //*
    //* Init.
    //*

    function App_Init()
    {
        $this->Sql_Table_Create_If_Non_Existent();
    }

    //*
    //* Export messages defaults.
    //*

    function Language_Messages_Export_Defaults()
    {
        $exports=
            array
            (
                "ID","Module","Message_Key","Message_Type","N","File",
            );

        $sorts=array();
        $n=0;
        foreach ($exports as $exp) { $sorts[ $n++ ]=1; }
        
        foreach ($this->KeyDatas as $data)
        {
            foreach ($this->Language_Keys() as $lang)
            {
                array_push($exports,$data."_".$lang);
            }
        }

        $this->Export_Defaults=
            array
            (
                "NFields" => count($exports),
                "Data" => $exports,
                "Sort" => $sorts,                
            );
    }

    function PreProcessItemData()
    {
        array_push
        (
            $this->ItemDataPaths,
            $this->ApplicationObj()->MyApp_Setup_Root().
             "/Application/System/Languages"
        );
    }

    //*
    //* PostProcessItemData
    //*

    function PostProcessItemData()
    {
        $valuedatadefs=
            $this->ReadPHPArray
            (
                $this->ApplicationObj()->MyApp_Setup_Root().
                "/Application/System/Languages/Key.php"
            );

        $this->KeyDatas=array_keys($valuedatadefs);
        $this->LanguageKeyDatas=array();
        $this->LanguageDataKeys=array();
        $this->LanguageSubKeys=array();
        
        $search=True;
        foreach ($valuedatadefs as $data => $def)
        {
            if (!isset($this->LanguageDataKeys[ $data ]))
            {
                $this->LanguageDataKeys[ $data ]=array();
            }
                
            foreach ($this->Language_Keys() as $lkey)
            {
                if (empty($lkey))
                {
                    $lkey=$this->ApplicationObj()->Language_Default;
                }
                
                $lkey=preg_replace('/^_/',"",$lkey);
            
                if (!isset($this->LanguageKeyDatas[ $lkey ]))
                {
                    $this->LanguageKeyDatas[ $lkey ]=array();
                }
            
                $rdata=$data."_".$lkey;
                $this->ItemData[ $rdata ]=
                    $this->MyHash_Filter_Hash
                    (
                        $def,
                        array("Lang" => $lkey)
                    );
                
                $this->ItemData[ $rdata ][ "Search" ]=$search;
                if ($search)
                {
                    /* $this->ItemData[ $rdata ][ "SqlMethod" ]= */
                    /*     "Language_Key_Search_Clause"; */
                    $this->ItemData[ $rdata ][ "SearchName" ]=$lkey;
                    $this->ItemData[ $rdata ][ "SearchName_UK" ]=$lkey;
                    $this->ItemData[ $rdata ][ "SearchName_ES" ]=$lkey;
                }
                
                
                array_push($this->LanguageDataKeys[ $data ],$rdata);
                array_push($this->LanguageKeyDatas[ $lkey ],$rdata);
                $this->LanguageSubKeys[ $data ]=True;
            }

            $search=False;
        }
        
        $this->LanguageDataKeys[ "MTime" ]=array();
        foreach ($this->Language_Keys() as $lkey)
        {
            array_push
            (
                $this->LanguageDataKeys[ "MTime" ],
                "MTime_".$lkey
            );
        }


        $timedef=
            $this->ReadPHPArray
            (
                $this->ApplicationObj()->MyApp_Setup_Root().
                "/Application/System/Languages/MTime.php"
            );
        
        foreach ($this->Language_Keys() as $lkey)
        {
            $this->ItemData[ "MTime_".$lkey ]=$timedef;
        }
        
        $this->LanguageSubKeys=array_keys($this->LanguageSubKeys);
        $this->Language_Messages_Export_Defaults();

        $this->Permissions_Data_Add();
    }
    
    //*
    //* 
    //*

    function LanguageSubKeys()
    {
        if (empty($this->LanguageSubKeys))
        {
            $this->LanguageSubKeys_Detect();
        }

        return $this->LanguageSubKeys;
    }
    
    function LanguageSubKeys_Detect()
    {
        $valuedatadefs=
            $this->ReadPHPArray
            (
                $this->ApplicationObj()->MyApp_Setup_Root().
                "/Application/System/Languages/Key.php"
            );

        $this->KeyDatas=array_keys($valuedatadefs);
        $this->LanguageKeyDatas=array();
        $this->LanguageDataKeys=array();
        $this->LanguageSubKeys=array();
        
        foreach ($this->Language_Keys() as $lkey)
        {
            if (empty($lkey)) { $lkey=$this->ApplicationObj()->Language_Default; }
            $lkey=preg_replace('/^_/',"",$lkey);
            
            if (!isset($this->LanguageKeyDatas[ $lkey ]))
            {
                $this->LanguageKeyDatas[ $lkey ]=array();
            }
            
            foreach ($valuedatadefs as $data => $def)
            {
                if (!isset($this->LanguageDataKeys[ $data ]))
                {
                    $this->LanguageDataKeys[ $data ]=array();
                }
                 
                array_push($this->LanguageDataKeys[ $data ],$rdata);
                array_push($this->LanguageKeyDatas[ $lkey ],$rdata);
                $this->LanguageSubKeys[ $data ]=True;
            }
        }

        $this->LanguageSubKeys=array_keys($this->LanguageSubKeys);    
    }

    function Language_Text_Datas()
    {
        $datas=array();
        foreach ($this->Language_Keys() as $lkey)
        {
            if (!empty($this->LanguageKeyDatas[ $lkey ]))
            {                
                $datas=
                    array_merge
                    (
                        $datas,
                        $this->LanguageKeyDatas[ $lkey ]
                    );
            }
        }

        return $datas;
    }
    
    function Language_Message_Datas()
    {
        return preg_grep('/^(Name|Title)/',$this->Language_Text_Datas());
    }
    
    function PreProcessItemDataGroups()
    {
        array_push
        (
            $this->ItemDataGroupPaths,
            $this->ApplicationObj()->MyApp_Setup_Root().
            "/Application/System/Languages"
        );
    }

    function PostProcessItemDataGroups()
    {
        $sgroup=
            $this->ReadPHPArray
            (
                $this->ApplicationObj()->MyApp_Setup_Root().
                "/Application/System/Languages/Key.SGroups.php"
            );
        $group=
            $this->ReadPHPArray
            (
                $this->ApplicationObj()->MyApp_Setup_Root().
                "/Application/System/Languages/Key.Groups.php"
            );
        
        foreach (array_keys($this->LanguageDataKeys) as $key)
        {
            if ($key!="MTime")
            {
                $this->ItemDataGroups[ $key ]=$group;
                $this->ItemDataGroups[ $key ][ "Name" ]=$key;
                $this->ItemDataGroups[ $key ][ "Data" ]=
                    $this->LanguageDataKeys[ $key ];
            }
        }

        
        foreach ($this->Language_Keys() as $lkey)
        {
            $datas=$this->LanguageKeyDatas[ $lkey ];
            array_push($datas,"MTime_".$lkey);
            
            $this->ItemDataSGroups[ $lkey ]=$sgroup;
            $this->ItemDataGroups[ $lkey ]=$group;
            
            $this->ItemDataSGroups[ $lkey ][ "Data" ]=$datas;
            $this->ItemDataGroups[ $lkey ][ "Data" ]=$datas;
            
            $this->ItemDataSGroups[ $lkey ][ "Name" ]=$lkey;
            $this->ItemDataGroups[ $lkey ][ "Name" ]=$lkey;
        }

        $this->Permissions_Data_Groups_Add($this->ItemDataGroups);
    }


    function PreActions()
    {
        array_push
        (
            $this->ActionPaths,
            $this->ApplicationObj()->MyApp_Setup_Root().
            "/Application/System/Languages"
        );
    }


    function PostActions()
    {
    }
    
    
    //*
    //* function PostProcess, Parameter list: $item
    //*
    //* Postprocesses and returns $item.
    //*

    function PostProcess($item,$force=False)
    {
        if (!$force && $this->GetGET("ModuleName")!="Languages")
        {
            return $item;
        }

        if (!isset($item[ "ID" ]) || $item[ "ID" ]==0) { return $item; }
            
        $this->Sql_Select_Hash_Datas_Read
        (
            $item,
            array_merge
            (
                array("Admin","Distributor","MTime"),
                $this->Language_Message_MTime_Datas(),
                $this->Language_Text_Datas()
            )
        );

        $olditem=$item;
        $updatedatas=
            array_merge
            (
                $this->Language_Actions_Defaults($item),
                $this->Language_Datas_Defaults($item),
                $this->Language_Groups_Defaults($item),
                $this->PostProcess_Defaults($item)
            );
        
        foreach ($this->Language_Keys() as $language)
        {
            $ldata=$this->Language_Message_MTime_Key($language);
            if (empty($item[ $ldata ]))
            {
                $item[ $ldata ]=$item[ "MTime" ];
                array_push($updatedatas,$ldata);
            }
        }

        
        if (count($updatedatas)>0)
        {
            echo
                join
                (
                    "<BR>",
                    $this->MyHash_Show($item,$updatedatas,$olditem)
                );
            
            $this->Sql_Update_Item_Values_Set($updatedatas,$item);
        }
        
        return $item;
    }

    //*
    //* function PostProcess_Defaults, Parameter list: $item
    //*
    //* Postprocesses and returns $item defaults.
    //*

    function PostProcess_Defaults(&$item)
    {
        $default_language="PT";
        $default_language2="UK";
        
        $name_data="Name";
        $title_data="Title";
                
        $updatedatas=array();        
        foreach ($this->Language_Keys() as $language)
        {
            if ($language!=$default_language)
            {
                if (empty( $item[ $name_data."_".$default_language ]))
                {
                    $dest_key=$name_data."_".$default_language;
                    $src_key=$name_data."_".$default_language2;

                    if (!empty($item[ $src_key ]))
                    {
                        $item[ $dest_key ]=$item[ $src_key ];
                        array_push($updatedatas,$dest_key);
                    }
                }

                if (empty( $item[ $name_data."_".$language ]))
                {
                    $dest_key=$name_data."_".$language;
                    $src_key=$name_data."_".$default_language;
                    
                    if (!empty($item[ $src_key ]))
                    {
                        $item[ $dest_key ]=$item[ $src_key ];
                        array_push($updatedatas,$dest_key);
                    }
                }

                //First try to take language Title as language Name.
                if (empty( $item[ $title_data."_".$language ]))
                {
                    $dest_key=$title_data."_".$language;
                    $src_key=$name_data."_".$language;
                    
                    if (!empty($item[ $src_key ]))
                    {
                        $item[ $dest_key ]=$item[ $src_key ];
                        array_push($updatedatas,$dest_key);
                    }
                }
                
                //Try to take default language Title from default language Name
                if (empty( $item[ $title_data."_".$default_language ]))
                {
                    $dest_key=$title_data."_".$default_language;
                    $src_key=$name_data."_".$default_language;
                    
                    if (!empty($item[ $src_key ]))
                    {
                        $item[ $dest_key ]=$item[ $src_key ];
                        array_push($updatedatas,$dest_key);
                    }
                }
                
             }
        }
        
        return $updatedatas;
    }
    
    //*
    //* Return OR'ed where clause form message content.

    function Language_Key_Search_Clause($data,$datavalues,$rdata)
    {
        if (is_array($datavalues)) { return $datavalues; }
        
        $datavalues=preg_replace('/\s+/',"%",$datavalues);
        $lkey=preg_replace('/\S+_/',"",$rdata);
        
        $ors=array();
        foreach ($this->KeyDatas as $key)
        {
            $rdata=$key."_".$lkey;
            array_push
            (
                $ors,
                $this->Sql_Table_Column_Name_Qualify($rdata).
                " LIKE ".
                $this->Sql_Table_Column_Value_Qualify("%".$datavalues."%")
            );
        }

        if (count($ors)>1)
        {
            return "(".join(" OR ",$ors).")";
        }

        return join(" OR ",$ors);
    }

    //*
    //*
    //* 

    function Language_Keys()
    {
        return $this->MyLanguage_Languages();
    }
    
    //*
    //*
    //* 

    function Language_Key($key)
    {
        return
            $key.
            "_".
            $this->ApplicationObj()->MyLanguage_Detect();
    }
    
    //*
    //*
    //* 

    function Language_Message_Derived_Language_Data()
    {
        $lang=$this->ApplicationObj()->MyLanguage_Detect();

        $datas=array();
        foreach ($this->Language_Data_Read() as $key)
        {
            array_push($datas,$key."_".$lang);
        }
        
        return $datas;
    }
    
    //*
    //*
    //* 

    function Language_Message_Derived_Data()
    {
        return
            array_merge
            (
                $this->AlwaysReadData,
                $this->Language_Message_Derived_Language_Data()
            );
    }

    //*
    //*
    //* 

    function Language_Message_Where($message_key,$type,$n=0,$where=array())
    {
        if (preg_match('/^(\d+)$/',$message_key))
        {
            return
                array
                (
                    "ID" => $message_key,
                );
        }
        
        return
            array_merge
            (
                $where,
                array
                (
                    "Message_Key" => $message_key,
                    "Message_Type" => $type,
                    #"SubKey" => "",
                    "N" => $n,
                )
            );
    }
       
    //*
    //*
    //* 

    function Language_Messages_Where($message_key,$type=2,$where=array())
    {
        return
            array_merge
            (
                $where,
                array
                (
                    "Message_Key" => $message_key,
                    "Message_Type" => $type,
                    #"SubKey" => "",
                )
            );
    }
    
    //*
    //*
    //* 

    function Language_Message_New($message_key,$message,$type,$n=0,$item=array())
    {
        if (empty($module)) { $module="Application"; }
        
        $item=$this->Language_Message_Where($message_key,$type,$n,$item);
        $item[ "File" ]=$message[ "File" ];

        if (!isset($item[ "ATime" ]))
        {
            $item[ "ATime" ]=0;
        }

        $files=$item[ "File" ];
        if (!is_array($files))
        {
            $files=array($files);
        }

        foreach ($files as $file)
        {
            if ($this->MyFile_Exists($file))
            {
                $item[ "ATime" ]=$item[ "CTime" ]=$item[ "MTime" ]=
                    $this->MyFiles_MTime($file);
            }
        }
        
        return $item;
    }
    
    //*
    //* Updates $item from $message.
    //*

    function Language_Message_2_Item($message,&$item,$dbitem)
    {
        $updatedatas=array();
        foreach ($this->LanguageSubKeys as $data)
        {
            if (empty($message[ $data ]))      { continue; }
            if (!is_string($message[ $data ])) { continue; }

            $default=preg_replace('/\'/','"',$message[ $data ]);
                    
            foreach ($this->Language_Keys() as $key)
            {
                $rdata=$data."_".$key;

                $item[ $rdata ]=$default;
                if (!empty($message[ $rdata ]))
                {
                    $newvalue=preg_replace('/\'/','"',$message[ $rdata ]);
                    if (empty($dbitem[ $rdata ]) || $dbitem[ $rdata ]!=$newvalue)
                    {
                        $item[ $rdata ]=$newvalue;
                        array_push($updatedatas,$rdata);
                    }
                }
            }                
        }

        foreach (array("File","Module") as $data)
        {
            if (!empty($item[ $data ]))
            {
                if (empty($dbitem[ $data ]) || $dbitem[ $data ]!=$item[ $data ])
                {
                    $dbitem[ $data ]=$item[$data  ];
                    array_push($updatedatas,$data);
                }
            }
        }

        return $updatedatas;
    }
    
    var $Language_Skew=
        array
        (
            "UK" => "Key",
            "UK" => "Key",
        );
    

    
    //*
    //* Reads message item.
    //*

    function Language_Message_Hash($type,$message_key,$subkeys,$language="",$where=array())
    {
        $message=
            $this->Language_Message_Item_Get
            (
                $type,$message_key,$subkeys,$language,$where
            );

        
        $datas=$this->Language_Message_Item_Datas($subkeys,$language);
        $data=$datas[0];
        if (empty($language))
        {
            $language=$this->MyLanguage_Get();
        }
        
        if
            (
                empty($message[ $data ])
                &&
                !empty($this->Language_Skew[ $language ])
            )
        {
            $this->Language_Message_Default
            (
                $message,
                $type,$message_key,$subkeys,$language
            );
        }
        
        return $message;
    }
    
    //*
    //* Try to find defaults for message.
    //*

    function Language_Message_Default(&$message,$type,$message_key,$subkeys,$language="")
    {
        if (empty($language))
        {
            $language=$this->MyLanguage_Get();
        }

        if (empty($this->Language_Skew[ $language ])) { return; }
        
        $skew=$this->Language_Skew[ $language ];
            
        $updatedatas=array(); 
        foreach ($this->Language_Message_Item_Datas($subkeys,$language) as $key)
        {
            if (empty($message[ $key ]))
            {
                if ($skew=="Key")
                {
                    $message[ $key ]=$message_key;
                    array_push($updatedatas,$key);
                    //var_dump($type,$message_key,$skew);
                }
                else
                {
                    $rkey=preg_replace('/_\S\S$/',$skew,$key);
                    if (!empty($message[ $rkey ]))
                    {
                            
                        $message[ $key ]=$message[ $rkey ];
                        array_push($updatedatas,$key);
                        //var_dump($type,$message_key,$skew);
                    }
                }
                    
            }
        }

        if (!empty($updatedatas))
        {
            $this->Sql_Update_Item_Values_Set($updatedatas,$message);
        }
     }
    
    //*
    //* Reads message item.
    //*

    function Language_Message_Get($type,$message_key,$subkeys,$language="",$where=array())
    {
        $message=
            $this->Language_Message_Hash($type,$message_key,$subkeys,$language,$where);

        if (empty($message)) { return $message_key; }

        //var_dump($message,$language);
        foreach
            (
                $this->Language_Message_Item_Datas($subkeys,$language) as $data
            )
        {
            if (!empty($message[ $data ]))
            {
                return preg_replace('/&amp;/',"&",$message[ $data ]);
            }
        }

        return "";
    }
    
    //*
    //* 
    //*

    function Language_Messages_Group_Datas()
    {
        $group=$this->MyMod_Data_Group_Actual_Get();

        if (empty($group)) { $group="Basic"; }

        $datas=array();
        if (!empty($this->ItemDataGroups[ "_Common_" ]))
        {
            $datas=$this->ItemDataGroups[ "_Common_" ][ "Data" ];
        }

        return
            array_merge
            (
                $datas,
                $this->ItemDataGroups[ $group ][ "Data" ]
            );
    }
    
    //* function , Parameter list:
    //*
    //* 
    //*

    function Language_Messages_SGroup_Datas()
    {
        return
            array
            (
                "Module","Message_Type","Message_Group",
                "Message_Key","N",
                "CTime","MTime"
            );
    }
    
    //*
    //* 
    //*

    function MyMod_Data_Group_Titles($group,$datas=array(),$titles=array())
    {
        return $this->Language_Messages_Group_Datas();
    }
    
    //*
    //* 
    //*

    function MyMod_Data_Group_Messages_Should()
    {
        $group=$this->MyMod_Data_Group_Actual_Get();
        
        $res=False;
        if (empty($this->ItemDataGroups[ $group ][ "Messages_On" ]))
        {
            $res=True;
        }

        return $res;
    }
    
    //*
    //* Creates search link to Message of type $type.
    //*

    function Language_Messages_Type_Search_Action($type,$moduleobj)
    {
        return
            $this->LanguagesObj()->Htmls_Href
            (
                "?".
                $this->CGI_Hash2URI
                (
                    array
                    (
                        "ModuleName" => "Languages",
                        "Action" => "EditList",
                        "Type" => $type,
                        "Module" => $moduleobj->ModuleName,
                    )
                ),
                $this->LanguagesObj()->MyMod_ItemsName(),
                "",
                "",
                array(),
                array("TARGET" => "Messages")
            );
    }
    
    //*
    //* Creates search link to Message of type $type.
    //*

    function Sql_Table_Structure_Update($datas=array(),$datadefs=array(),$maycreate=TRUE,$table="",$exit_on_create=False)
    {
        parent::Sql_Table_Structure_Update($datas,$datadefs,$maycreate,$table);
    }
    
    //*
    //* 
    //*

    function Message_Debug_Pre_Should()
    {
        return
            //$this->MyMod_Messages_Access_Has()
            //&&
            $this->CGI_GETint("Messages")==1;
    }
    
    //*
    //* Debug Pre Message: includes link to edit message.
    //*

    function Message_Debug_Pre($type,$message_key,$where=array())
    {
        $this->Actions();
        $this->Actions[ "Edit" ][ "Target" ]=$this->ModuleName;
        
        $action="";
        if ($this->Message_Debug_Pre_Should())
        {
            //Add edit link to messages
            $dbitem=
                $this->Sql_Select_Hash
                (
                    $this->Language_Message_Item_Where
                    (
                        $type,
                        $message_key,
                        $where
                    ),
                    array("ID",$this->Profile())
                );

            if (empty($dbitem))
            {
                var_dump
                (
                    "Empty Message",
                    $this->Language_Message_Item_Where
                    (
                        $type,
                        $message_key,
                        $where
                    )
                );
            }
            
            if (TRUE)
            {
                $action=
                    $this->MyActions_Entry
                    (
                        "Edit",
                        $dbitem,
                        $noicons=0,
                        $class="nowrap",
                        $rargs=array(),
                        $noargs=array(),
                        $alt=FALSE,
                        $icon="far fa-sticky-note",
                        $name="",
                        $size=1
                    );
            }
         }

        
        return $action;
    }

    
    //*
    //* Changes perms on 
    //*

    function Message_Permissions_Group_Set($edit,$item=array(),$group="")
    {
        foreach
            (
                array
                (
                    "Message_Type","Message_Key",
                    "Module",
                    "Name_".$this->ApplicationObj()->Language
                )
                as $data
            )
        {
            $this->ItemData[ $data ][ "Perms_Fixed" ]=
                $this->Min
                (
                    1,
                    $this->ItemData[ $data ][ $this->Profile() ],
                    $this->ItemData[ $data ][ $this->LoginType() ]
                );
        }
    }

    //Do not over kill...
    var $Empty_Loaded=0;
    var $Empty_Max=10;
    
    //*
    //* 
    //*

    function Message_Dynamic_Empty_Is($item,$data="")
    {
        if ($this->Empty_Loaded>$this->Empty_Max) { return False; }
        
        $res=False;
        foreach ($this->Language_Message_Datas() as $data)
        {
            if (empty($item[ $data ])) { $res=True; }
        }
        
        $this->Empty_Loaded++;
        
        return $res;
    }
    
}
?>