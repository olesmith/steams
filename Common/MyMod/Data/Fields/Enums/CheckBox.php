<?php

trait MyMod_Data_Fields_Enums_CheckBox
{
    //*
    //* 
    //*

    function MyMod_Data_Field_Enum_CheckBox($data,$value,$item)
    {
        $checkbox=$this->MyMod_Data_Field_Enum_CheckBox_Is($data);

        $options=$this->MyMod_Data_Field_Enum_Options($data,$tabindex,$item);
       
        if ($checkbox==1)
        {
            $options[ "ALIGN" ]='left';
            $value=
                $this->MakeCheckBoxSetTable
                (
                    $rdata,$values,$names,$value,
                    3,
                    $options
                );
        }
        elseif ($checkbox==2)
        {
             $options[ "ALIGN" ]='left';
             $value=
                 #$this->MakeRadioSet($rdata,$values,$names,$value,$tabindex);
                 $this->Htmls_Radios($rdata,$values,$names,$value,$tabindex);
        }
        elseif ($checkbox==3)
        {
            $options[ "ALIGN" ]='left';
            $options[ "TABINDEX" ]=$tabindex;
            
            $value=
                $this->MakeCheckBox
                (
                    $rdata,1,$value-1,FALSE,
                    $options
                );
        }

        return $value;
    }
    
    //*
    //* Returns check box type. False for select.
    //*

    function MyMod_Data_Field_Enum_CheckBox_Is($data)
    {
        $checkbox=False;
        if (!empty($this->ItemData[ $data ][ "SelectCheckBoxes" ]))
        {
            $checkbox=$this->ItemData[ $data ][ "SelectCheckBoxes" ];
        }

        return $checkbox;
    }
    
}

?>