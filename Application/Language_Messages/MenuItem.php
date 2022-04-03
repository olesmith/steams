<?php

class Language_Messages_MenuItem extends Language_Messages_Messages
{
    
    //*
    //* function Language_MenuItems_Update, Parameter list: $file,$menuitemnames,$submenu
    //*
    //* 

    function Language_MenuItems_Update($file,$submenu)
    {
        $menuitemnames=array();
        foreach ($submenu as $key => $value)
        {
            if (is_array($value)) { array_push($menuitemnames,$key); }
        }

        $messages=array();
        foreach ($menuitemnames as $menuitemname)
        {
            $messages=
                array_merge
                (
                    $messages,
                    $this->Language_MenuItem_Update
                    (
                        $file,
                        $this->Language_LeftMenu_Name_Trim($menuitemname),
                        $submenu[ $menuitemname ]
                    )
                );
        }

        return $messages;
    }
    
    //*
    //* function Language_MenuItem_Update, Parameter list: $file,$menuitemname,$menuitem
    //*
    //* 

    function Language_MenuItem_Update($file,$menuitemname,$menuitem)
    {
        return
            $this->Language_Module_Item_Update_Html
            (
                $module="",$file,
                $menuitemname,$menuitem,
                $this->Language_MenuItem_Type,
                $force=False,$updateperms=True
            );
    }
    
    //*
    //* function Language_MenuItem_Get, Parameter list: 
    //*
    //* 

    function Language_MenuItem_Name_Get($submenuitemname)
    {
          return $this->Message_Debug_Pre.
            $this->Language_Message_Get
            (
                $this->Language_MenuItem_Type,
                $this->Language_LeftMenu_Name_Trim($submenuitemname),
                array("Name","Title")
            );
    }
    
    //*
    //* function Language_MenuItem_Title_Get, Parameter list: $submenu
    //*
    //* Generates (returns) full submenu entry, incl. title.
    //*

    function Language_MenuItem_Title_Get($submenuitemname)
    {
        return 
            $this->Language_Message_Get
            (
                $this->Language_MenuItem_Type,
                $this->Language_LeftMenu_Name_Trim($submenuitemname),
                array("Title")
            );
    }
}
?>