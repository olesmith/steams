<?php

trait Tournament_Groups_Matches_Options
{
    //*
    //*
    //*

    function Tournament_Group_Matches_Options($group,$n=0,$options=array())
    {
        if (empty($options[ "STYLE" ])) { $options[ "STYLE" ]=array(); }
        
        return
            array_merge
            (
                $options,
                array
                (
                    "STYLE" =>
                    array_merge
                    (
                        $options[ "STYLE" ],
                        $this->Tournament_Group_Matches_Options_Style
                        (
                            $group,$n
                        )
                    ),
                )
            );
    }
    
    //*
    //* 
    //*

    function Tournament_Group_Matches_Options_Style($group,$n=0)
    {
       return
           array
           (
               "background-color" => '#3399ff',
               "opacity"          =>
               $this->Tournament_Group_Matches_Option_Opacity
               (
                   $group,$n
               ),
           );
    }
    
    //*
    //* 
    //*

    function Tournament_Group_Matches_Option_Opacity($group,$n=0)
    {
        $max=4;
        $n=$n % $max;
        return
           1-(1.0*$n)/(2.0*$max);
    }
}

?>