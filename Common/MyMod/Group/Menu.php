<?php

include_once("Menu/Entry.php");
include_once("Menu/Entries.php");
include_once("Menu/Destination.php");
include_once("Menu/Destinations.php");


trait MyMod_Group_Menu
{

    use
        MyMod_Group_Menu_Entry,
        MyMod_Group_Menu_Entries,
        MyMod_Group_Menu_Destination,
        MyMod_Group_Menu_Destinations;
    
    //*
    //* Creates dynamic menu with links to Groups.
    //*

    function MyMod_Groups_Menu($group,$item,$cellid,$singular=True)
    {
        return
            $this->Htmls_Menues_Dynamic
            (
                //$menu info
                array
                (
                    "Items_Per_Line" => 6,
                    "Name" => "",
                    "Title" => "",
                    "Color" => "orange",
                    "Hide_Color" => "grey",
                    "Reload_Color" => "#efa572",
                    "Toggle_Others" => True,
                ),

                
                //Entries
                $this->MyMod_Groups_Menu_Entries
                (
                    $item,$cellid
                ),

                //Destinations
                $this->MyMod_Groups_Menu_Destinations
                (
                    $item,$cellid
                )//,
                
                //Loads
                //$this->MyMod_Groups_Menu_Loads($group,$item,$cellid,$singular)
            );
    }
    
    //*
    //* Creates dynamic menu with links to Groups.
    //*

    function MyMod_Groups_Menu_Group_Active($group,$singular=True)
    {
        $curr_group=
            $this->MyMod_Handle_Show_SGroup_CGI();

        return ($curr_group==$group);
    }
}

?>