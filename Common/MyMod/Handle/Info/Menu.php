<?php

include_once("Menu/Entry.php");
include_once("Menu/Entries.php");
include_once("Menu/Destination.php");
include_once("Menu/Destinations.php");

trait MyMod_Handle_Info_Menu
{
    use
        MyMod_Handle_Info_Menu_Entry,
        MyMod_Handle_Info_Menu_Entries,
        MyMod_Handle_Info_Menu_Destination,
        MyMod_Handle_Info_Menu_Destinations;
    //*
    //* Generates with sql tables info.
    //*

    function MyMod_Handle_Info_Menu()
    {
        $hash=
            array
            (
                "Actions" => "Actions",
                "Data" => "Item Data",
                "Groups" => "Data Groups",
                "SGroups" => "Data SGroups",
                "HorMenu" => "Horisontal Menus",
            );
        
        return
            $this->Htmls_Menues_Dynamic
            (
                //$menu info
                array
                (
                    "Name" => "",
                    "Title" => "",
                    "Color" => "orange",
                    "Hide_Color" => "grey",
                    "Reload_Color" => "#efa572",
                    "Toggle_Others" => True,
                ),

                
                //Entries
                $this->MyMod_Handle_Info_Menu_Entries($hash),

                /* //Destinations */
                $this->MyMod_Handle_Info_Menu_Destinations($hash),

                
                array()
                
                /* //Loads */
                /* $this->MyMod_Groups_Menu_Loads($group,$item,$cellid,$singular) */
            );
    }
    
   
    //*
    //* Generates menu entry
    //*

    function MyMod_Handle_Info_Menu_Destination_ID($args,$type,$name)
    {
        return
            join
            (
                "_",
                array($this->ModuleName,"Info",$type)
            );
    }
}

?>