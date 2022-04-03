<?php

trait MyMod_Handle_Info_Menu_Destinations
{
    //*
    //* Generates menu entries
    //*

    function MyMod_Handle_Info_Menu_Destinations($hash)
    {
        $entries=array();
        foreach ($hash as $type => $name) 
        {
            $entries[ $type ]=
                $this->MyMod_Handle_Info_Menu_Destination
                (
                    $hash,$type,$name
                );
        }
        
        return $entries;
    }    
}

?>