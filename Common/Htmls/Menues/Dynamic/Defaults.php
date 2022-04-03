<?php

trait Htmls_Menues_Dynamic_Defaults
{   
    var $_Htmls_Menues_Dynamic_Defaults_Menu_=
        array
        (
            "Class" => "atablemenu",
            "Back_Color" => "white",
            "Debug" => False,
            "Items_Per_Line" => 8,
            "Display_Show" => 'initial',
            "Display_Dest" => 'block',

        );
    
    var $_Htmls_Menues_Dynamic_Defaults_Entry_=
        array
        (
            "Tag" => "SPAN",
            "Debug" => False,
            "Class" => "activemenuitem",
        );
    
    var $_Htmls_Menues_Dynamic_Defaults_Destination_=
        array
        (
            "Tag" => "DIV",
            "Debug" => False,
        );
    
    var $_Htmls_Menues_Dynamic_Defaults_Load_=
        array
        (
        );
    
    //*
    //* Take defaults for $menu.
    //*
    
    function Htmls_Menues_Dynamic_Defaults_Menu($menu)
    {
        return
            array_merge
            (
                $this->_Htmls_Menues_Dynamic_Defaults_Menu_,
                $menu
            );
    }

    
    //*
    //* Take defaults for $entries.
    //*
    
    function Htmls_Menues_Dynamic_Defaults_Entries($entries)
    {
        foreach (array_keys($entries) as $id)
        {
            if (is_array($entries[ $id ]))
            {
                $entries[ $id ]=
                    array_merge
                    (
                        $this->_Htmls_Menues_Dynamic_Defaults_Entry_,
                        $entries[ $id ]
                    );
            }
        }

        return $entries;
    }
    
    //*
    //* Take defaults for $destinations.
    //*
    
    function Htmls_Menues_Dynamic_Defaults_Destinations($destinations)
    {
        foreach (array_keys($destinations) as $id)
        {
            $destinations[ $id ]=
                array_merge
                (
                    $this->_Htmls_Menues_Dynamic_Defaults_Destination_,
                    $destinations[ $id ]
                );
        }

        return $destinations;
    }
    
    //*
    //* Take defaults for $loads.
    //*
    
    function Htmls_Menues_Dynamic_Defaults_Loads($loads)
    {
        return $loads;
    }
    
}
?>