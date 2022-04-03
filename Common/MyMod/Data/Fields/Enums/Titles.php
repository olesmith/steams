<?php

trait MyMod_Data_Fields_Enums_Titles
{
    //*
    //* Returns TITLEs to display in SELECT field.
    //*

    function MyMod_Data_Field_Enum_Titles($data,$values)
    {
        $valuetitles=array();
        if (!empty($this->ItemData[ $data ][ "Value_Titles" ]))
        {
            $valuetitles=$this->ItemData[ $data ][ "Value_Titles" ];
        }
        
        $titles=array();
        $checkbox=$this->MyMod_Data_Field_Enum_CheckBox_Is($data);
        
        if ($checkbox==FALSE)
        {
            if (empty($this->ItemData[ $data ][ "NoSearchEmpty" ]))
            {
                $titles=array(0);
            }
        }
        elseif ($checkbox==2)
        {
            $titles=array();
        }

        $n=1;
        foreach ($values as $val)
        {
            $title=$n;
            if (count($valuetitles)>=$n)
            {
                $title=$valuetitles[ $n-1 ];
            }
            
            array_push($titles,$title);
            $n++;
        }

        return $titles;
    }    
}

?>