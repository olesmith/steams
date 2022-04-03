<?php

include_once("Plural/Entry.php");
include_once("Plural/Destination.php");
include_once("Plural/Row.php");
include_once("Plural/Rows.php");
include_once("Plural/Menu.php");

trait MyMod_Items_Dynamic_Plural
{
    use
        MyMod_Items_Dynamic_Plural_Entry,
        MyMod_Items_Dynamic_Plural_Destination,
        MyMod_Items_Dynamic_Plural_Row,
        MyMod_Items_Dynamic_Plural_Rows,
        MyMod_Items_Dynamic_Plural_Menu;
    
    //*
    //* Create plural row.
    //*

    function MyMod_Items_Dynamic_Plural_Entries($items,$group)
    {
        $actions=$this->ItemDataGroups($group,"Plural");
        if (!is_array($actions)) { return array(); }

        $entries=array();
        foreach ($actions as $action => $def)
        {            
            if
                (
                    !empty
                    (
                        $this->MyMod_Item_Dynamic_Action_Allowed
                        (
                            $group,
                            $def
                        )
                    )
                )
            {
                $entries[ $action ]=
                    $this->MyMod_Items_Dynamic_Plural_Entry
                    (
                        $items,$group,$action,$def
                    );
            }
        }

        return $entries;
    }
    
    //*
    //* Create plural row.
    //*

    function MyMod_Items_Dynamic_Plural_Destinations($items,$group)
    {
        $actions=$this->ItemDataGroups($group,"Plural");
        if (!is_array($actions)) { return array(); }

        $destinations=array();
        foreach ($actions as $action => $def)
        {            
            if
                (
                    !empty
                    (
                        $this->MyMod_Item_Dynamic_Action_Allowed
                        (
                            $group,
                            $def
                        )
                    )
                )
            {
                $destinations[ $action ]=
                    $this->MyMod_Items_Dynamic_Plural_Destination
                    (
                        $items,$group,$action,$def
                    );
            }
        }

        return $destinations;
    }
    
}

?>