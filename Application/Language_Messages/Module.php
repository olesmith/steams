<?php

class Language_Messages_Module extends Language_Messages_LeftMenu
{
    //*
    //* function Language_Module_File_Update, Parameter list: 
    //*
    //* 

    function Language_Module_File_Update($module,$file,$type)
    {
        $messages=array("Module: ".$module." - File: ".$file);

        foreach ($this->ReadPHPArray($file) as $action => $item)
        {
            array_push
            (
                $messages,
                $this->Language_Module_Item_Update($module,$file,$action,$item,$type)
            );
        }

        $method=$module."Obj";
        $files=$this->$method()->MyActions_GetFiles();
        $messages=array_merge($messages,$files);
        return $messages;
    }
        
    //*
    //* function , Parameter list: 
    //*
    //* Does message $moditem update: add or update.
    //* Returns message generated.
    //* 

    function Language_Module_Item_Update_Do($module,$file,$key,$moditem,$type,$force=False,$updateperms=True)
    {
        $this->NItems++;
        $moditem[ "File" ]=$file;

        $where=array();
        if (!empty($module))
        {
            $where[ "Module" ]=$module;
        }
        
        $new_item=
            $this->Language_Message_New
            (
                $key,$moditem,
                $type,
                0,
                $where
            );

        $dbitem=
            $this->Sql_Select_Hash
            (
                $this->Language_Message_Where
                (
                    $key,
                    $type,
                    0,
                    array
                    (
                        "Module" => $module,
                    )
                )
            );

        $updatedatas=$this->Language_Message_2_Item($moditem,$new_item,$dbitem);

        $message="";
        if (empty($dbitem))
        {
            $message=$this->Language_Message_DB_Insert($key,$new_item,$force);
            $dbitem=$new_item;
        }
        elseif (count($updatedatas)>0)
        {
            $message=$this->Language_Message_DB_Update($key,$new_item,$dbitem,$updatedatas);
            $new_item[ "ID" ]=$dbitem[ "ID" ];
            $dbitem=$new_item;
        }
        else
        {
            $message=$this->Language_Message_DB_UpToDate($key,$new_item,$dbitem);
        }

        if ($updateperms)
        {
            $this->Permissions_File_2_Item($moditem,$dbitem,$module,$key);
        }
        
        return array($message,$dbitem,$new_item);
    }
    
    //*
    //* function Language_Module_File_Item_Update_Rows, Parameter list: 
    //*
    //* Call Language_Module_Item_Update_Do retriving message.
    //* Returns comparing row.
    //* 

    function Language_Module_Item_Update_Rows($module,$file,$key,$moditem,$type,$force=False,$updateperms=False)
    {
        if (!empty($moditem[ "No_DB_Messages" ]))
        {
            return array($key);
        }
        
        $result=
            $this->Language_Module_Item_Update_Do
            (
                $module,$file,$key,
                $moditem,$type,$force,$updateperms
            );

        $message=$result[0];
        $dbitem=$result[1];
        $item=$result[2];

        if (!empty($dbitem[ "ID" ]))
        {
            $item[ "ID" ]=$dbitem[ "ID" ];
        }

        $datas=
            array
            (
                "ID","Edit","File",
                "Module","Message_Type","Message_Key","N",
                "CTime","MTime"
            );
        
        $item[ "No" ]="-";
        $nrowsindent=0;

        if (empty($moditem[ "File" ]))
        {
            $moditem[ "File" ]=$file;
        }
        
        return
            array_merge
            (
                
                array
                (
                    $this->Htmls_Table_Head_Row
                    (
                        $this->MyMod_Data_Titles
                        (
                            $datas
                        )
                    ),
                    $this->MyMod_Items_Table_Row
                    (
                        0,$n="",
                        $dbitem,
                        $datas
                    ),
                ),
                    
                $this->Language_Message_Item_Languages_Rows
                (
                    0,
                    $this->NItems,
                    $dbitem,
                    $nrowsindent,
                    $this->B("DB:"),
                    $leading2="",$force=False,$includehead=True
                ),
                $this->Language_Message_Item_Languages_Rows
                (
                    0,
                    "",
                    $item,
                    $nrowsindent,
                    $this->B("File:"),
                    $this->TimeStamp2Text
                    (
                        $this->MyFiles_MTime($moditem[ "File" ]),
                        $sep=" ",False
                    ),
                    $force=False,$includehead=False
                ),
                array
                (
                    array
                    (
                        $this->Htmls_Table_Multi_Cell($message,count($datas)),
                    )
                )
            );

        return $rows;
        
    }
    
    //*
    //* 
    //* 

    function Language_Module_Item_Update_Html($module,$file,$key,$moditem,$type,$force=False,$updateperms=False)
    {
            return
                $this->Htmls_Table
                (
                    "",
                    $this->Language_Module_Item_Update_Rows
                    (
                        $module,$file,$key,$moditem,$type,$force=False,$updateperms=False
                    ),
                    array("WIDTH" => '100%')
                );
    }
}
?>