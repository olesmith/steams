<?php


trait Htmls_Menues_Dynamic_Toggles
{
    //*
    //* Generates horisontal dynamic menu cell for $key.
    //*

    function Htmls_Menues_Dynamic_Toggles($key,$is_last,$extras)
    {
        if
            (
                !is_array($this->_Entries_[ $key ])
                ||
                empty($this->_Entries_[ $key ])
                ||
                !isset($this->_Entries_[ $key ][ "Hide" ])
            )
        {
            return array();
        }
        
        $hide=$this->_Entries_[ $key ][ "Hide" ];
        
        $toggles=
            array
            (
                $this->Htmls_Menues_Dynamic_Toggle
                (
                    $key,False,$hide
                ),
                $this->Htmls_Menues_Dynamic_Toggle
                (
                    $key,True,!$hide
                ),                
            );

        if (!empty($this->_Entries_[ $key ][ "Trailing" ]))
        {
            $toggles=
                array_merge
                (
                    $toggles,
                    $this->_Entries_[ $key ][ "Trailing" ]
                );
        }

        if ($extras)
        {
            $toggles=
                array_merge
                (
                    $toggles,
                    $this->Htmls_Menues_Dynamic_Toggles_Extras($key,$is_last)
                );
        }        
        
        return $toggles;
    }
    
    
    
    //*
    //* 
    //*

    function Htmls_Menues_Dynamic_Toggles_Extras($key,$is_last)
    {        
        $entry=$this->_Entries_[ $key ];

        $extras=array();
        if (!empty($entry[ "Last" ]))
        {
            $add=
                $this->_Htmls_Menues_Dynamic_Entries_End.
                $this->BR(2);
            
            if (!$is_last)
            {
                $add.=
                    $this->_Htmls_Menues_Dynamic_Entries_Start;
            }

            array_push($extras,$add);
        }
        else
        {
            $add=
                $this->_Htmls_Menues_Dynamic_Entries_Sep;
            if ($is_last)
            {
                $add=
                    $this->_Htmls_Menues_Dynamic_Entries_End;
            }
                
            array_push($extras,$add);
        }
        
        return $extras;
    }
    
}
?>