<?php

trait MyMod_Handle_Info_Menu_Entry
{
    //*
    //* Generates info menu entry cell.
    //*

    function MyMod_Handle_Info_Menu_Entry($hash,$type,$name)
    {
        $args=$this->CGI_URI2Hash();
        
        $dest_field_id=
            $this->MyMod_Handle_Info_Menu_Destination_ID
            (
                $args,$type,$name
            );
        
        $args[ "Type" ]=$type;
        $args[ "Dest" ]=$dest_field_id;
        
        return
            array
            (
                "Tag" => "SPAN",
                "Class" => 'dynamicmenuitem',
                "Hide" => False,
                //"Debug" => True,
                
                "ID" => $this->MyMod_Handle_Info_Menu_Destination_ID
                (
                    $args,$type,$name
                ),
                
                "Name" =>  $type,
                       
                
                "Destination" => $this->MyMod_Handle_Info_Menu_Destination_ID
                (
                    $args,$type,$name
                ),

                "Onclick" =>

                $this->JS_Load_URL_2_Element
                (
                    $args,
                    $this->MyMod_Handle_Info_Menu_Destination_ID
                    (
                        $args,$type,$name
                    ),
                    ""
                )

            );
    }   
}

?>