<?php

trait MyMod_Handle_Info_Menu_Destination
{
    //*
    //* Generates menu entries
    //*

    function MyMod_Handle_Info_Menu_Destination($hash,$type,$name)
    {
        $args=$this->CGI_URI2Hash();
        
        $dest_field_id=
            $this->MyMod_Handle_Info_Menu_Destination_ID
            (
                $args,$type,$name
            );
        
        return
            array
            (
                "ID"       => $this->MyMod_Handle_Info_Menu_Destination_ID
                (
                    $args,$type,$name
                ),
                
                "Name"     =>  $name,
                "Contents" =>  $type,
                       
                "Tag" => "DIV",
                "Display" => 'none',
                "Hide"     => False,
            );
    }    
}

?>