<?php


trait MyApp_Interface_LeftMenu_Generate_SubMenu_Inactive
{
    //*
    //* Tests if submenu item is inactive. 
    //*

    function MyApp_Interface_LeftMenu_Generate_SubMenu_Inactive_Is($submenuitemname,$submenuitem,$item=array())
    {
        $inactive=True;
        if (!empty($submenuitem[ "Inactive_Method" ]))
        {
            $method=$submenuitem[ "Inactive_Method" ];
            $inactive=$this->$method($submenuitem,$item);
        }

        return $inactive;
    }
    
    //*
    //* Returns $name/$title span.
    //*

    function MyApp_Interface_LeftMenu_Generate_SubMenu_Inactive($submenuitemname,$submenuitem,$item=array())
    {
        return
            $this->Htmls_Span
            (
                $this->LanguagesObj()->Language_MenuItem_Name_Get($submenuitemname),
                array
                (
                    "TITLE" => $this->LanguagesObj()->Language_MenuItem_Title_Get($submenuitemname),
                )
            );
    }
}

?>