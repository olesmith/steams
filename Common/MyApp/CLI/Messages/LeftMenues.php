<?php

trait App_CLI_Messages_LeftMenues
{
    //*
    //* Leftmenu Messages to insert: MenuItems and Submenues.
    //*

    function MyApp_CLI_Message_LeftMenues_Do()
    {
        $permissions=
            array
            (
                "Admin" => 1,
                "Person" => 1,
                "Public" => 1,
            );
        
        foreach ($this->MyApp_Interface_LeftMenu_Read() as $submenuname => $submenu)
        {
            $this->MyApp_CLI_Message_LeftMenu_Do($submenuname,$submenu,$permissions);
        }
    }
    
    //*
    //* 
    //*

    function MyApp_CLI_Message_LeftMenu_Do($submenuname,$submenu,$permissions)
    {
        $this->MyApp_CLI_Message_LeftMenu_Item_Do($submenuname,$submenu,$permissions);
        $this->MyApp_CLI_Message_LeftMenu_SubMenu_Do($submenuname,$submenu,$permissions);
    }
    //*
    //* 
    //*

    function MyApp_CLI_Message_LeftMenu_Item_Do($submenuname,$submenu,$permissions)
    {
        $key=preg_replace('/^\d+_/',"",$submenuname);
        
        $where=
            array
            (
                "Message_Key" => $key,
                "Message_Type" => $this->LanguagesObj()->Language_LeftMenu_Type,
            );
            
        $message=
            $this->LanguagesObj()->Sql_Select_Hash
            (
                $where                        
            );

        if (empty($message))
        {
            $message=$where;
            $message[ "Name_PT" ]=$key;
            $message=array_merge($message,$permissions);
            
            $this->LanguagesObj()->PostProcess_Defaults($message);
            $this->LanguagesObj()->Sql_Insert_Item($message);
            print "\tLeftMenu $key inserted\n";
        }       
    }

    
    //*
    //* 
    //*

    function MyApp_CLI_Message_LeftMenu_SubMenu_Do($submenuname,$submenu,$permissions)
    {
        $menunames=array_keys($submenu);
        sort($menunames);

        foreach ($menunames as $menuname)
        {
            $this->MyApp_CLI_Message_LeftMenu_SubMenu_Item_Do
            (
                $menuname,
                $submenu[$menuname  ],
                $permissions
            );
        }
    }

    
    //*
    //* 
    //*

    function MyApp_CLI_Message_LeftMenu_SubMenu_Item_Do ($menuname,$menuitem,$permissions)
    {
        $key=preg_replace('/^\d+_/',"",$menuname);
        
        $where=
            array
            (
                "Message_Key" => $key,
                "Message_Type" => $this->LanguagesObj()->Language_MenuItem_Type,
            );
            
        $message=
            $this->LanguagesObj()->Sql_Select_Hash
            (
                $where                        
            );

        if (empty($message))
        {
            $message=$where;
            $message[ "Name_PT" ]=$key;
            $message=array_merge($message,$permissions);

            $this->LanguagesObj()->PostProcess_Defaults($message);
            $this->LanguagesObj()->Sql_Insert_Item($message);

            print "\tMenuItem $key inserted\n";
        }       
    }
}
