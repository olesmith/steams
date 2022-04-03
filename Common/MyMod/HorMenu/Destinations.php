<?php

trait MyMod_HorMenu_Destinations
{
    //*
    //* Generates menu entries for all menu.
    //*

    function MyMod_HorMenues_Destinations($singular,$id,$item)
    {
        $destinations=array();
        foreach ($this->MyMod_HorMenu_Get($singular) as $cssclass => $menu)
        {
            if (count($menu)>0)
            {
                $destinations=
                    array_merge
                    (
                        $destinations,
                        $this->MyMod_HorMenu_Destinations
                        (
                            $singular,
                            $menu,$cssclass,$id,$item
                        )
                    );
            }
        }

        return $destinations;
    }
    
    //*
    //*
    //*

    function MyMod_HorMenu_Destinations($singular,$pactions,$cssclass,$id,$item)
    {
        $current_action=$this->MyActions_Detect();
        
        $destinations=array();
        $included=array();
        foreach
            (
                $this->MyMod_HorMenu_Actions_Get
                (
                    $singular,
                    $pactions,$id,$item
                )
                as $action
            )
        {
            $destinations[ $action ]=
                $this->MyMod_HorMenu_Destination
                (
                    $action,$cssclass,$id,$item
                );
        }
       

        return $destinations;

    }
}

?>