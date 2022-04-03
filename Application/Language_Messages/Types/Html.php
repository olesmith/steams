<?php

class Language_Messages_Types_Html extends Language_Messages_Types_Table
{    
    //*
    //* function Language_Message_Types_Table, Parameter list: 
    //*
    //* 

    function Language_Message_Types_HTML()
    {
        return
            array
            (
                $this->H(1,"Message Maintenance"),
                $this->H(2,"Create Update Message"),
                $this->Htmls_Table
                (
                    $this->Language_Message_Type_Row_Titles(),
                    $this->Language_Message_Types_Table()
                ),
            );
    }
}
?>