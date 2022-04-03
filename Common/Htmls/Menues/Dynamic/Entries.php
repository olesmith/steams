<?php

trait Htmls_Menues_Dynamic_Entries
{
    var
        $_Htmls_Menues_Dynamic_Entries_Start="[",
        $_Htmls_Menues_Dynamic_Entries_Sep="|",
        $_Htmls_Menues_Dynamic_Entries_End="]";
    
    
    //*
    //* Generates horisontal dynamic menu on/off buttons for $key.
    //*

    function Htmls_Menues_Dynamic_Entries($extras=False)
    {
        $html=array();

        if ($extras)
        {
            array_push($html,$this->_Htmls_Menues_Dynamic_Entries_Start);
        }
        
        $nkeys=count($this->Htmls_Menues_Dynamic_Entry_Keys());
        
        $nitems_perline=
            $this->Htmls_Menues_Dynamic_Menu("Items_Per_Line");
        
        $nlines=
            max
            (
                1,
                intval(floor($nkeys/$nitems_perline))
            );
        
        if ($nkeys>$nitems_perline*$nlines){ $nlines++; }

        
        $nitems_perline=intval(ceil($nkeys/$nlines));

        $n=0;
        $is_last=False;
        foreach ($this->Htmls_Menues_Dynamic_Entry_Keys() as $key)
        {
            $n++;

            if ($n==$nkeys) { $is_last=True; }
            
            array_push
            (
                $html,
                $this->Htmls_Menues_Dynamic_Entry($key,$is_last,$extras)
            );

            if (!empty($this->_Entries_[ $key ][ "Last" ]))
            {
                array_push
                (
                    $html,
                    $this->Htmls_Tag
                    (
                        "P",
                        "",
                        array
                        (
                            "STYLE" => array
                            (
                                "height" => '10px',
                            )
                        )
                    )
                );                
            }
        }

        return $html;
    
    }
}
?>