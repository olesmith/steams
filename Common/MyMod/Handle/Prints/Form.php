<?php

trait MyMod_Handle_Prints_Form
{
    //*
    //* 
    //*

    function MyMod_Handle_Prints_Form($type)
    {
        return
            $this->Htmls_Form
            (
                1,
                $this->MyMod_Handle_Prints_Form_ID(),

                "",//action
                
                $contents=
                array
                (
                    $this->MyMod_Handle_Prints_Html($type)
                ),
                $args=
                array
                (
                    "Buttons" => array
                    (
                        $this->Htmls_Button("Print")
                    ),
                    "Hiddens" => array
                    (
                        "Print" => 1,
                    ),
                )
            );
    }
    
    //*
    //* 
    //*

    function MyMod_Handle_Prints_Form_ID($type)
    {
        return $this->CGI_GET("Dest")."_Prints_".$type;
    }
    
}

?>