<?php

trait MyActions_Entry_Icon
{
    //*
    //* Generates action $icon, only.
    //*

    function MyActions_Entry_Icon($data,$noicons=0,$size='',$icon="")
    {
        $options=array();
        if (empty($icon))
        {
            $icon=$this->Actions[ $data ][ "Icon" ];
            if (!empty($this->Actions[ $data ][ "Icon_Color" ]))
            {
                $options[ "COLOR" ]=$this->Actions[ $data ][ "Icon_Color" ];
            }
        }

        if ($noicons==1 || empty($icon))
        {
            $icon=
                $this->LanguagesObj()->Language_Action_Name_Get
                (
                    $this,
                    $data
                );
        }
        else
        {
            if ($this->MyMod_Data_Image_Value_Is($icon))
            {
                $icon=$this->ApplicationObj()->MyApp_Icon_IMG($icon,$size);
            }
            else
            {
                $icon=
                    $this->MyMod_Interface_Icon
                    (
                        $icon,
                        $options,
                        $size
                    );
            }
        }
        
        return $icon;
    }
}