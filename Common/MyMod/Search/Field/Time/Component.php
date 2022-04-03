<?php


trait MyMod_Search_Field_Time_Component
{        
    //*
    //* Create the $field/$component select field..
    //*

    function MyMod_Search_Field_Time_Component_Field($cgi,$component,$field,$data,$rdata,$rval)
    {
        return
            $this->Htmls_Select
            (
                $this->MyMod_Search_Field_Time_Component_Key($component,$field,$data,$rdata),
                $this->MyMod_Search_Field_Time_Component_Range($component),
                $this->MyMod_Search_Field_Time_Component_Range_Titles($component),
                $this->MyMod_Search_Field_Time_Component_Value($cgi,$component,$field,$data,$rdata,$rval),
                $args=array
                (
                    
                ),
                $options=array
                (
                    "TITLE" => $this->MyMod_Search_Field_Time_Components_Letters($component),
                )
            );
    }

    //*
    //* 
    //*

    function MyMod_Search_Field_Time_Component_Range($component)
    {
        $this->MyMod_Search_Field_Time_Ranges();
        return $this->MyMod_Search_Field_Time_Components_Ranges[ $component ];
    }
    
    //*
    //* 
    //*

    function MyMod_Search_Field_Time_Component_Range_Titles($component)
    {
        $this->MyMod_Search_Field_Time_Ranges();
        $titles=array();
        foreach
            (
                array_keys($this->MyMod_Search_Field_Time_Components_Ranges[ $component ]) as $id
            )
        {
            array_push
            (
                $titles,
                sprintf("%02d",$this->MyMod_Search_Field_Time_Components_Ranges[ $component ][ $id ])
            );
        }

        return $titles;
    }
    
    
    //*
    //* 
    //*

    function MyMod_Search_Field_Time_Component_Key_CGI($component,$field,$data,$rdata="")
    {
        return
            join
            (
                "_",
                array
                (
                    $this->ModuleName,
                    $data,
                    "Search",
                    $field,
                    $component
                )
            );
    }
    
    //*
    //* 
    //*

    function MyMod_Search_Field_Time_Component_Key($component,$field,$data,$rdata="")
    {
        if (empty($rdata)) { $rdata=$data; }
        
        return
            $this->MyMod_Search_Field_Time_Field_Key
            (
                $field,$data,$rdata
            ).
            "_".
            $component;
    }
    
    //*
    //* 
    //*

    function MyMod_Search_Field_Time_Component_Value($cgi,$component,$field,$data,$rdata="")
    {
        return $cgi[ $field ][ $component ];
    }
    
}

?>