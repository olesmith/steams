<?php

include_once("SubMenu/Inactive.php");
include_once("SubMenu/Item.php");
include_once("SubMenu/List.php");


trait MyApp_Interface_LeftMenu_Generate_SubMenu
{
    use
        MyApp_Interface_LeftMenu_Generate_SubMenu_Inactive,
        MyApp_Interface_LeftMenu_Generate_SubMenu_Item,
        MyApp_Interface_LeftMenu_Generate_SubMenu_List;

    //*
    //* Generates (returns) full submenu entry, incl. title.
    //*

    function MyApp_Interface_LeftMenu_Generate_SubMenu($submenuname,$submenu)
    {
        $html=array();
        if (is_array($submenu))
        {
            if
                (
                    $this->MyApp_Interface_LeftMenu_Generate_Access_Has
                    (
                        $submenuname,$submenu
                    )
                )
            {
                $menu=
                    $this->MyApp_Interface_LeftMenu_Generate_SubMenu_List
                    (
                        $submenu
                    );

                if (empty($menu)) { return array(); }

                $html=
                    array_merge
                    (
                        $html,
                        $this->MyApp_Interface_LeftMenu_Generate_SubMenu_Title
                        (
                            $submenuname,
                            $submenu
                        )
                    );
                
                $html=array_merge($html,$menu);                
            }
        }
        else
        {
            array_push($html,$submenu);
        }

        return $html;
    }

    //*
    //* 
    //*

    function MyApp_Interface_LeftMenu_Generate_SubMenu_Title($submenuname,$submenu,$name="")
    {
        if (empty($name))
        {
            $name=
                $this->LanguagesObj()->Language_LeftMenu_Name_Get
                (
                    $submenuname
                );
        }
            
        return
            $this->Htmls_DIV
            (
                $name,
                $this->MyApp_Interface_LeftMenu_Generate_SubMenu_Options
                (
                    $submenuname,
                    $name
                )
            );
    }
    
    //*
    //* Generates (returns) full submenu entry, incl. title.
    //*

    function MyApp_Interface_LeftMenu_Generate_SubMenu_Options($submenuname,$name)
    {
        $title=
            $this->LanguagesObj()->Language_LeftMenu_Title_Get
            (
                $submenuname
            );

        $options=array("CLASS" => 'menu-label');
        if (!empty($title) && $title!=$name)
        {
            $options[ "TITLE" ]=$title;
        }
           
        return $options;
    }

}

?>