<?php

trait MyMod_HorMenu_Destination
{
    //*
    //*
    //*

    function MyMod_HorMenu_Destination($action,$cssclass,$id,$item,$display='none')
    {
        return
            array
            (
                "Tag" => $this->MyMod_HorMenu_Destination_Tag($action),
                "Display" => 'initial',
                "Hide"     => $this->MyMod_HorMenu_Action_InActive($action),
                
                "ID"       => $this->MyMod_HorMenu_Destination_ID($action),
                
                "Title"     => "",
                "Name"     => 
                $this->MyMod_HorMenu_Entry_Name
                (
                    $action,$id,$item
                ),
                
                "Contents" =>
                $this->MyMod_HorMenu_Destination_Contents($action),
            );
    }

    //*
    //* Empty tag prevents Dynamic menu from creating destination field.
    //*

    function MyMod_HorMenu_Destination_Tag($action)
    {
        $tag="DIV";
        if
            (
                !$this->MyMod_HorMenu_Dynamic_ByLoad
                &&
                $this->MyMod_HorMenu_Action_Active($action)
            )
        {
            $tag="";
        }

        return $tag;
    }
    
    //*
    //*
    //*

    function MyMod_HorMenu_Destination_Contents($action)
    {
        return $this->ModuleName.", $action";
        //"Content ".$this->MyMod_HorMenu_Destination_ID($action);
    }
    //*
    //*
    //*

    function MyMod_HorMenu_Destination_ID($action)
    {
        return
            
            join
            (
                "_",
                array
                (
                    $this->ModuleName,
                    $action,
                    $this->JS_CSS_Field
                )
            );
    }
    
}

?>