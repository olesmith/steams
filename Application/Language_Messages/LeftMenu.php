<?php

class Language_Messages_LeftMenu extends Language_Messages_MenuItem
{
    //*
    //* function Language_LeftMenu_Name_Trim, Parameter list: 
    //*
    //* 

    function Language_LeftMenu_Name_Trim($submenuname)
    {
        return preg_replace('/^\d+_/',"",$submenuname);
    }

    
    //*
    //* function Language_LeftMenues_Update, Parameter list: 
    //*
    //* 

    function Language_LeftMenues_Update()
    {

        $this->NItems=0;
        $messages=array();        
        foreach ($this->ApplicationObj()->MyApp_Setup_LeftMenu_DataFiles() as $file)
        {
            $messages=array_merge
            (
                $messages,
                $this->Language_LeftMenu_File_Update($file)
            );
        }
        
        foreach
            (
                $this->ApplicationObj()->MyApp_Setup_SubMenu_DataFiles()
                as $file
            )
        {
            $messages=array_merge
            (
                $messages,
                array("SubFile: ".$file),
                $this->Language_MenuItems_Update
                (
                    $file,
                    $this->ApplicationObj()->ReadPHPArray($file)
                )
            );
        }

        
        return
            array
            (
                $this->H(3,"LeftMenues in Files"),
                $this->Htmls_Table
                (
                    array("No","File","Name","Type","Message",),
                    $messages
                )
            );
    }
    //*
    //* function Language_LeftMenu_File_Update, Parameter list: 
    //*
    //* 

    function Language_LeftMenu_File_Update($file)
    {
        $messages=array("File: ".$file);
        foreach ($this->ReadPHPArray($file) as $submenuname => $submenu)
        {
            $submenuname=$this->Language_LeftMenu_Name_Trim($submenuname);
            $messages=
                array_merge
                (
                    $messages,
                    $this->Language_LeftMenu_Update($file,$submenuname,$submenu)
                );

            $dbitem=
                $this->Sql_Select_Hash
                (
                    $this->Language_Message_Where
                    (
                        $submenuname,
                        $this->Language_LeftMenu_Type
                    ),
                    array("ID","Message_Key")
                );

            if (!empty($submenu[ "File" ]))
            {
                $submenu=$this->ReadPHPArray($submenu[ "File" ]);
            }
            //Register LeftMenu MenuItems
            foreach ($submenu as $menuitemname => $menuitem)
            {
                if ($menuitemname=="Method") { continue; }
                
                
                $menuitemname=$this->Language_LeftMenu_Name_Trim($menuitemname);
                $menudbitem=
                    $this->Sql_Select_Hash
                    (
                        /* array */
                        /* ( */
                        /*     "Message_Key"  => $menuitemname, */
                        /*     "Message_Type" => $this->Language_MenuItem_Type */
                        /* ), */
                        $this->Language_Message_Where
                        (
                            $menuitemname,
                            $this->Language_MenuItem_Type
                        ),
                        array("ID","Message_Key","Message_Group")
                    );
                
                if (empty($menudbitem[ "Message_Group" ]))
                {
                    //$menuitem[ "Group" ]=$dbitem[ "ID" ];
                    
                    var_dump("Update Group: $menuitemname, $submenuname",$dbitem[ "ID" ]);
                    $this->Sql_Update_Item_Value_Set
                    (
                        $menudbitem[ "ID" ],
                        "Message_Group",
                        $dbitem[ "ID" ]
                    );
                }
            }
        }

        return $messages;
    }
    //*
    //* function Language_LeftMenu_Update, Parameter list: 
    //*
    //* 

    function Language_LeftMenu_Update($file,$submenuname,$submenu)
    {
        $submenu[ "File" ]=$file;

        $item=
            $this->Language_Message_New
            (
                $submenuname,$submenu,
                $this->Language_LeftMenu_Type
            );

        $dbitem=
            $this->Sql_Select_Hash
            (
                $this->Language_Message_Where
                (
                    $submenuname,
                    $this->Language_LeftMenu_Type
                )
            );

        $updatedatas=$this->Language_Message_2_Item($submenu,$item,$dbitem);

        $message="";
        if (empty($dbitem))
        {
            $message=$this->Language_Message_DB_Insert($submenuname,$item);
        }
        elseif (count($updatedatas)>0)
        {
            $message=$this->Language_Message_DB_Update($submenuname,$item,$dbitem,$updatedatas);
        }
        else
        {
            $message=$submenuname." exists and is uptodate.";
        }

        $this->Permissions_File_2_Item($submenu,$dbitem);
        
        $messages=$this->Language_MenuItems_Update($file,$submenu);
        $this->NItems++;
        
        array_push
        (
            $messages,
            array
            (
                $this->NItems,
                $file,$submenuname,
                $this->Language_LeftMenu_Type,
                $message
            )
        );

        return $messages;
    }
         
    //*
    //* function Language_LeftMenu_Name_Get, Parameter list: 
    //*
    //* 

    function Language_LeftMenu_Name_Get($leftmenuname)
    {
        $name=
            $this->Language_Message_Get
            (
                $this->Language_LeftMenu_Type,
                $this->Language_LeftMenu_Name_Trim($leftmenuname),
                array("Name","Title")
            );
        

        if (empty($name))
        {
            $name=$leftmenuname;
        }
        
        return
            array
            (
                $this->Message_Debug_Pre
                (
                    $this->Language_LeftMenu_Type,
                    $this->Language_LeftMenu_Name_Trim($leftmenuname)
                ),
                $name
            );
    }
    
    //*
    //* function Language_LeftMenu_SubMenu_Title_Get, Parameter list: $submenu
    //*
    //* Generates (returns) full submenu entry, incl. title.
    //*

    function Language_LeftMenu_Title_Get($leftmenuname)
    {
        return $leftmenuname;
        return 
            $this->Language_Message_Get
            (
                $this->Language_LeftMenu_Type,
                $this->Language_LeftMenu_Name_Trim($leftmenuname),
                array("Title")
            );
    }
}
?>