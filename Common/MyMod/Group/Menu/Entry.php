<?php

trait MyMod_Group_Menu_Entry
{
    //*
    //* Generates group menu entry cell.
    //*

    function MyMod_Groups_Menu_Entry($item,$cellid,$group,$singular=True)
    {
        return
            array
            (
                "Tag" => "SPAN",
                //"Debug" => True,
                
                "ID" =>
                $this->MyMod_Groups_Menu_Entry_ID
                (
                    $item,$group,$singular
                ),

                "Name" =>  $this->MyMod_Data_Group_Name($group,$singular),
                       
                
                "Destination" => $this->MyMod_Groups_Menu_Destination_ID
                (
                    $item,$group,$singular
                ),
                
                "Hide" => $this->MyMod_Groups_Menu_Entry_Hide
                (
                    $group,$singular
                ),
                
                "Onclick" => $this->MyMod_Groups_Menu_Entry_JS
                (
                    $item,$cellid,$group
                ),
                
                "Class" => 'dynamicmenuitem',
            );
    }
    
    //*
    //* 
    //*

    function MyMod_Groups_Menu_Entry_ID($item,$group,$singular=True)
    {
        return
            join
            (
                "_",
                array
                (
                    $this->CGI_GET("Dest"),
                    $group
                )
            );
    }
    
    //*
    //* 
    //*

    function MyMod_Groups_Menu_Entry_Hide($group,$singular=True)
    {
        return
            $this->MyMod_Groups_Menu_Group_Active
            (
                $group,$singular
            );
    }
    
    //*
    //* 
    //*

    function MyMod_Groups_Menu_Entry_JS($item,$cellid,$group,$singular=True)
    {        
        return
            $this->JS_Load_URL_2_Element
            (
                $this->MyMod_Groups_Menu_Entry_URL
                (
                    $item,$cellid,$group
                ),
                
                $this->MyMod_Groups_Menu_Destination_ID
                (
                    $item,$group,$singular
                ),
                
                "GroupMenu"
            );
    }
    
    //*
    //* Java script for activating $group menu.
    //*

    function MyMod_Groups_Menu_Entry_Action($item,$group)
    {
        $action=$this->CGI_GET("Action");
        if
            (
                preg_match
                (
                    '/^(Add|Edit)$/',
                    $action
                )
            )
        {
            $action="Edit";
        }

        return $action;
    }
    
    //*
    //* URL $group menu.
    //*

    function MyMod_Groups_Menu_Entry_URL($item,$cellid,$group)
    {
        return
            array_merge
            (
                $this->CGI_URI2Hash(),
                array
                (
                    "ModuleName" => $this->ModuleName,
                    "Action"     => $this->MyMod_Groups_Menu_Entry_Action
                    (
                        $item,$group
                    ),
                    "ID"         => $item[ "ID" ],
                    "GroupName" => $group,
                    "NoGroupMenu" => 1,
                    "Dest" => $this->MyMod_Groups_Menu_Destination_ID
                    (
                        $item,$group,$singular=True
                    ),
                )
            );
        
     }
}
?>