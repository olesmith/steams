<?php

trait MyMod_Data_Fields_Enums_Names
{
    //*
    //* Returns TITLEs to display in SELECT field.
    //*

    function MyMod_Data_Field_Enum_Names($data,$values)
    {
        $checkbox=$this->MyMod_Data_Field_Enum_CheckBox_Is($data);
        
        $rvalues=array();
        if (!empty($this->ItemData[ $data ][ "Values" ]))
        {
            $rvalues=$this->ItemData[ $data ][ "Values" ];
        }
        
        $names=array();
        if ($checkbox==FALSE)
        {
            if (empty($this->ItemData[ $data ][ "NoSearchEmpty" ]))
            {
                $names=
                    array
                    (
                        ""//$this->MyMod_Data_Enum_Name_Empty($data)
                    );
            }
        }
        elseif ($checkbox==2)
        {
            $names=array();
        }

        $n=1;
        foreach ($rvalues as $val)
        {
            if ($this->ItemData[ $data ][ "MaxLength" ]>0)
            {
                $val=substr($val,0,$this->ItemData[ $data ][ "MaxLength" ]);
            }

            array_push($names,$val);
            $n++;
        }
        
        return $names;
    }

    
    //*
    //* Empty text on enums.
    //*

    function MyMod_Data_Enum_Name_Empty($data)
    {
        return $this->LanguagesObj()->Language_Data_Empty_Name_Get($this,$data);
    }
    
    
}

?>