<?php

include_once("Dynamic/Defaults.php");
include_once("Dynamic/IDs.php");
include_once("Dynamic/Display.php");
include_once("Dynamic/JS.php");
include_once("Dynamic/Url.php");
include_once("Dynamic/Shows.php");
include_once("Dynamic/Hiddens.php");
include_once("Dynamic/Toggle.php");
include_once("Dynamic/Toggles.php");
include_once("Dynamic/Loads.php");
include_once("Dynamic/Entry.php");
include_once("Dynamic/Entries.php");
include_once("Dynamic/Scripts.php");
include_once("Dynamic/Destination.php");
include_once("Dynamic/Destinations.php");

trait Htmls_Menues_Dynamic
{
    use
        Htmls_Menues_Dynamic_Defaults,
        Htmls_Menues_Dynamic_IDs,
        Htmls_Menues_Dynamic_Display,
        Htmls_Menues_Dynamic_JS,
        Htmls_Menues_Dynamic_Url,
        Htmls_Menues_Dynamic_Shows,
        Htmls_Menues_Dynamic_Hiddens,
        Htmls_Menues_Dynamic_Toggle,
        Htmls_Menues_Dynamic_Toggles,
        Htmls_Menues_Dynamic_Loads,
        Htmls_Menues_Dynamic_Entry,
        Htmls_Menues_Dynamic_Entries,
        Htmls_Menues_Dynamic_Scripts,
        Htmls_Menues_Dynamic_Destination,
        Htmls_Menues_Dynamic_Destinations;
       
    //*
    //* Generates horisontal dynamic menu cell for $key.
    //*
    //* $menu, array with keys:
    //*
    //*   Name,Title.
    //*   Class.
    //*   Color,Hide_Color, Reload_Color.
    //*   Back_Color
    //*   Toggle_Others: Activate one item, desactivate all other items
    //*   Items_Per_Line
    //*
    //* Entries is a list of arrays with keys:
    //*
    //* ID,Name,Tag,Cell_ID.
    //* Hide,Onclick
    //*
    

    function Htmls_Menues_Dynamic($menu,$entries,$destinations=array(),$loads=array(),$debug=False)
    {
        $this->Htmls_Menues_Dynamic_Init
        (
            $menu,
            $entries,$destinations,$loads
        );

        $name="";
        if (!empty($menu[ "Name" ]))
        {
            $name=$menu[ "Name" ];
            if (!empty($menu[ "Title" ]))
            {
                $name=
                    $this->Htmls_Span
                    (
                        $name,
                        array("TITLE" => $menu[ "Title" ])
                    );
            }
        }
        
        return
            array
            (
                $this->Htmls_DIV
                (
                    array
                    (
                        $name,          
                        $this->Htmls_Menues_Dynamic_Entries(),
                        $this->Htmls_Menues_Dynamic_Destinations(),
                        $this->Htmls_Menues_Dynamic_Scripts($debug),
                    ),
                    array
                    (
                        "CLASS" => array
                        (
                            $this->Htmls_Menu_Horisontal_Class($menu)
                        ),
                        "STYLE" => array
                        (
                            "text-align" => 'center',
                        )
                    )
                )
            );
    }
    
     
    //*
    //* ID,Name,Tag,Cell_ID.
    //* Hide,Onclick
    //*
    

    function Htmls_Menues_Dynamic_Init($menu,$entries,$destinations=array(),$loads=array())
    {
        $this->_Menu_=
            $this->Htmls_Menues_Dynamic_Defaults_Menu($menu);
        
        $this->_Entries_=
            $this->Htmls_Menues_Dynamic_Defaults_Entries($entries);
        
        $this->_Destinations_=
            $this->Htmls_Menues_Dynamic_Defaults_Destinations($destinations);

        $this->_Loads_=
            $this->Htmls_Menues_Dynamic_Defaults_Loads($loads);

    }
    
    
    //*
    //* 
    //*
    

    function Htmls_Menu_Horisontal_Class($menu)
    {
        return $this->Htmls_Menues_Dynamic_Menu("Class");
    }
    
    //*
    //* 
    //*

    function Htmls_Menues_Dynamic_Title($menu)
    {
        $html=array();

        if (!empty(   $title=$this->Htmls_Menues_Dynamic_Menu("Title")   ))
        {
            array_push
            (
                $html,
                $this->H(3,$title)
            );
        }
        
        return $html;
    }
   
    //*
    //*
    //*

    function Htmls_Menues_Dynamic_Menu($key="")
    {
        if (!empty($key))
        {
            if (isset($this->_Menu_[ $key ]))
            {   
                return $this->_Menu_[ $key ];
            }

            return False;
        }
        
        return $this->_Menu_;
    }    
}
?>