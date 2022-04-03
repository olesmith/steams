<?php


trait MyMod_Search_Field_Time_Components
{
    var $MyMod_Search_Field_Time_Components=array();
    var $MyMod_Search_Field_Time_Components_Letters=array();
    var $MyMod_Search_Field_Time_Components_Ranges=array();
    
    //*
    //* 
    //*

    function MyMod_Search_Field_Time_Ranges($component="")
    {
        if (empty($this->MyMod_Search_Field_Time_Components_Ranges))
        {
            $this->MyMod_Search_Field_Time_Components_Ranges=
                array
                (
                    "Year" => range(1970,date("Y")),
                    "Month" => range(1,12),
                    "MDay" => range(1,31),
                    "Hour" => range(0,23),
                    "Min" => range(0,59),
                    "Sec" => range(0,59),
                );
        }
        
        if (!empty($component))
        {
            return $this->MyMod_Search_Field_Time_Components_Ranges[ $component ];
        }

        return $this->MyMod_Search_Field_Time_Components_Ranges;
    }
        
    //*
    //* 
    //*

    function MyMod_Search_Field_Time_Components($component="")
    {
        if (empty($this->MyMod_Search_Field_Time_Components))
        {
            $this->MyMod_Search_Field_Time_Components=
                array
                (
                    "Year",
                    "Month",
                    "MDay",
                    "Hour",
                    "Min",
                );
        }

        if (!empty($component))
        {
            return $this->MyMod_Search_Field_Time_Components[ $component ];
        }

        return $this->MyMod_Search_Field_Time_Components;
    }
        
    //*
    //* 
    //*

    function MyMod_Search_Field_Time_Components_Letters($component="")
    {
        if (empty($this->MyMod_Search_Field_Time_Components_Letters))
        {
            $this->MyMod_Search_Field_Time_Components_Letters=
                array
                (
                    "Year" => "YYYY",
                    "Month" => "MM",
                    "MDay" => "DD",
                    "Hour" => "HH",
                    "Min" => "MM",
                    "Sec" => "SS",
                );
        }
        
        if (!empty($component)) { return $this->MyMod_Search_Field_Time_Components_Letters[ $component ]; }

        return $this->MyMod_Search_Field_Time_Components_Letters;
  
    }
        
    //*
    //* Creates titles row.
    //*

    function MyMod_Search_Field_Time_Components_Titles()
    {
        $titles=array();
        foreach ($this->MyMod_Search_Field_Time_Components() as $component)
        {
            array_push
            (
                $titles,
                $this->B
                (
                    $this->MyLanguage_GetMessage($component)
                )
            );
        }
        
        return $titles;
    }
        
    //*
    //* Creates $component row.
    //*

    function MyMod_Search_Field_Time_Components_Row($cgi,$field,$data,$rdata,$rval)
    {
        $row=array();
        foreach ($this->MyMod_Search_Field_Time_Components() as $component)
        {            
            array_push
            (
                $row,
                $this->MyMod_Search_Field_Time_Component_Field
                (
                    $cgi,
                    $component,
                    $field,
                    $data,
                    $rdata,
                    $rval
                )
            );
        }
        
        return $row;
    }
        
}

?>