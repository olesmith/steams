<?php

include_once("Generate/Access.php");
include_once("Generate/SubMenu.php");

trait MyApp_Interface_LeftMenu_Generate
{
    use
        MyApp_Interface_LeftMenu_Generate_Access,
        MyApp_Interface_LeftMenu_Generate_SubMenu;
    //*
    //* function MyApp_Interface_LeftMenu_Generate, Parameter list:
    //*
    //* Generates (returns) the Left menu.
    //*

    function MyApp_Interface_LeftMenu_Generate()
    {
        $this->CompanyHash[ "Language" ]=$this->GetLanguage();
        $this->CompanyHash[ "Path" ]=$this->CGI_Script_Path();

        $html=array();
        foreach
            (
                $this->MyApp_Interface_LeftMenu_Read()
                as $submenuname => $submenu
            )
        {
            array_push
            (
                $html,
                $this->MyApp_Interface_LeftMenu_Generate_SubMenu
                (
                    $submenuname,
                    $submenu
                )
            );

        }
        
        return $this->Htmls_Tag("NAV",$html);
    }


    //*
    //* function MyApp_Interface_LeftMenu_Generate_Items_Menu, Parameter list: $obj,$menumethod,$items,$activeid,$href,$name,$title,$class="leftmenulinks",$add="+",$sub="-"
    //*
    //* Generates (returns) the Left menu.
    //*

    function MyApp_Interface_LeftMenu_Generate_Items_Menu($obj,$menumethod,$items,$activeid,$href,$name,$title,$class="leftmenulinks",$add="+",$sub="-")
    {
        $list=array();
        foreach ($items as $id => $item)
        {
            $text="";

            $item=$obj->MyMod_Data_Fields_Enums_ApplyAll($item);

            $pre=$add;
            if ($item[ "ID" ]==$activeid)
            {
                $pre="&nbsp;".$sub;
            }
            
            $rhref=
                $this->Href
                (
                    $this->Filter($href,$item),
                    $pre.
                    $this->Filter($name,$item).":",
                    $this->Filter($title,$item),
                    "",
                    $class
                );
                        
            if ($item[ "ID" ]==$activeid)
            {
                $text=
                    array
                    (
                        $rhref.
                        $this->BR(),
                        $this->$menumethod(),
                    );
            }
            else
            {
                $text=
                    array
                    (
                        $rhref,
                    );
            }

            array_push($list,$text);
        }

        return $list;
    }
}

?>