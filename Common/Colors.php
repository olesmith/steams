<?php


trait Colors
{
    //*
    //* 
    //*

    function Color_Hex_2_RGB($color)
    {
        $color=hexdec(preg_replace('/^#/',"",$color));

        return
            array
            (
                'red'   => (0xFF & ($color >> 0x10)),
                'green' => (0xFF & ($color >> 0x8)),
                'blue'  => (0xFF & $color),
            );
    }
    
    //*
    //* 
    //*

    function Color_Hex_Combination($t,$color,$color2)
    {
        $color=$this->Color_Hex_2_RGB($color);
        $color2=$this->Color_Hex_2_RGB($color2);

        foreach (array_keys($color) as $key)
        {
            $color[ $key ]=
                strtolower(sprintf
                (
                    "%02X",
                    floor
                    (
                        $t*$color[ $key ]
                        +
                        (1.0-$t)*$color2[ $key ]
                    )
                ));
        }
        

        return
            "#".
            $color[ "red" ].
            $color[ "green" ].
            $color[ "blue" ].
            "";
    }
}


?>