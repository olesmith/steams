<?php


trait Htmls_Menues_Dynamic_Destinations
{    
    //*
    //* Generates horisontal dynamic menu cell for $key.
    //*

    function Htmls_Menues_Dynamic_Destinations($html=array())
    {
        foreach ($this->Htmls_Menues_Dynamic_Destination_Keys() as $key)
        {
            if (empty($this->_Destinations_[ $key ])) { continue; }
            
            array_push
            (
                $html,
                $this->Htmls_Menues_Dynamic_Destination($key)
            );
        }
        
        return $html;
    }
}
?>