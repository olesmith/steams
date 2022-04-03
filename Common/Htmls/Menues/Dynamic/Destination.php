<?php

trait Htmls_Menues_Dynamic_Destination
{
    //*
    //* 
    //*

    function Htmls_Menues_Dynamic_Destination_Keys()
    {
        return array_keys($this->_Destinations_);
    }
    
    //*
    //* 
    //*

    function Htmls_Menues_Dynamic_Destination_Value($key,$rkey="")
    {
        if (isset($rkey))
        {
            if (isset($this->_Destinations_[ $key ][ $rkey ]))
            {   
                return $this->_Destinations_[ $key ][ $rkey ];
            }            
        }
        
        return $this->_Destinations_[ $key ];
    }
            
    //*
    //* Generates horisontal dynamic destination cell for $key.
    //*

    function Htmls_Menues_Dynamic_Destination($key)
    {
        $destination=$this->_Destinations_[ $key ];

        if (empty($destination[ "Tag" ])) { return array(); }
        
        return
            array
            (
                $this->Htmls_Tag
                (
                    $destination[ "Tag" ],
                    $destination[ "Contents" ],
                    $this->Htmls_Dynamic_Cell_Options($destination)
                ),
                $this->Htmls_Menues_Dynamic_Destination_Trailing($key)
            );
    }
    
    //*
    //* Generates horisontal dynamic destination cell for $key.
    //*

    function Htmls_Menues_Dynamic_Destination_Trailing($key)
    {
        $destination=$this->_Destinations_[ $key ];

        $trail=array();
        if (!empty($destination[ "Trailing" ]))
        {
            $trail=$destination[ "Trailing" ];
        }

        return $trail;
    }
}
?>