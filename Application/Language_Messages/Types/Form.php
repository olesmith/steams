<?php

class Language_Messages_Types_Form extends Language_Messages_Types_Update
{    
    //*
    //* function Language_Message_Types_Form, Parameter list: 
    //*
    //* 

    function Language_Message_Types_Form()
    {
        return
            $this->Htmls_Form
            (
                1,
                "Messages",
                "",
                $this->Language_Message_Types_HTML(),
                array
                (
                    "Buttons" => $this->Htmls_Buttons("GO"),
                    "Hiddens" => array
                    (
                        "Run" => 1,
                    )
                )
            );        
    }
}
?>