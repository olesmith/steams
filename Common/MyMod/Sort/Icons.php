<?php


trait MyMod_Sort_Icons
{
    var $MyMod_Sort_Icons=
        array
        (
            "Unsorted" => "fas fa-sort-down",
            "Sort"     => "fas fa-sort-down",
            "Reversed" => "fas fa-sort-up",
        );
        
    //*
    //* function MyMod_Sort_Icon_Args, Parameter list: $data,$reversed=False
    //*
    //* Creates sort icon for $data unsorted.
    //*

    function MyMod_Sort_Icon_Args($data,$reversed=False)
    {
        $args=$this->CGI_Query2Hash();
        
        $cgikey=$this->ModuleName."_"."Sort";
        $args[ $cgikey ]=$data;
        
        $cgikey=$this->ModuleName."_"."Reversed";
        if ($reversed)
        {
            $args[ $cgikey ]=1;
        }
        else
        {
            $args[ $cgikey ]=0;
        }

        $args[ "Anchor" ]="SORT";
        return $args;
    }
   
    //*
    //* function MyMod_Sort_Icon_Title, Parameter list: $data,$reversed=False
    //*
    //* Creates options title for sort icon.
    //*

    function MyMod_Sort_Icon_Title($data,$reversed=False)
    {
        return
            $this->MyLanguage_GetMessage("Sort_OrderBy").
            " ".
            $this->MyMod_Sort_Title_Get($data).
            "";
    }
    
    //*
    //* function MyMod_Sort_Icon_Options, Parameter list: $data
    //*
    //* Options to include for SORT icons.
    //*

    function MyMod_Sort_Icon_Options($data)
    {
        return
            array
            (
                "CLASS" => 'datatitlelink',
                "COLOR" => 'gray',
            );
    }
    
    //*
    //* function MyMod_Sort_Icon_Unsorted, Parameter list: $data
    //*
    //* Creates sort icon for $data unsorted.
    //*

    function MyMod_Sort_Icon_Unsorted($data)
    {
        return
            $this->MyMod_Interface_Icon_Link
            (
                $this->MyMod_Sort_Icon_Args($data),
                $this->MyMod_Sort_Icons[ "Unsorted" ],
                $this->MyMod_Sort_Icon_Title($data),            
                $class='head',
                $options=array(),
                $this->MyMod_Sort_Icon_Options($data),
                1
            );
    }
    
    //*
    //* function MyMod_Sort_Icon, Parameter list: $data
    //*
    //* Creates sort icon for sorting $data normally.
    //*

    function MyMod_Sort_Icon($data)
    {
        return
            $this->MyMod_Interface_Icon_Link
            (
                $this->MyMod_Sort_Icon_Args($data),
                $this->MyMod_Sort_Icons[ "Sort" ],
                $this->MyMod_Sort_Icon_Title($data),                           
                $class='head',
                $options=array(),
                $this->MyMod_Sort_Icon_Options($data),
                1
            );
        }

    //*
    //* function MyMod_Sort_Icon_Reversed, Parameter list: $data
    //*
    //* Creates sort icon for sorting $data reversed.
    //*

    function MyMod_Sort_Icon_Reversed($data)
    {
        return
            $this->MyMod_Interface_Icon_Link
            (
                $this->MyMod_Sort_Icon_Args($data,True),
                $this->MyMod_Sort_Icons[ "Reversed" ],
                $this->Language_Message("Sort_Reverse"),
                $class='head',
                $options=array(),
                $this->MyMod_Sort_Icon_Options($data),
                1
            );
    }   
}

?>