<?php


trait MyMod_Search_Table_Buttons
{
    //*
    //* Returns search table button title.
    //*

    function MyMod_Search_Table_Button_Title()
    {
        return
            strtoupper
            (
                $this->GetMessage($this->MyMod_Search_Messages,"SearchButton")
            );
            
    }
    
    //*
    //* Returns search table button title row.
    //*

    function MyMod_Search_Table_Buttons_Row($buttons)
    {
        array_unshift
        (
            $buttons,
            $this->Html_Input_Button_Make
            (
                "submit",
                $this->MyMod_Search_Table_Button_Title()
            )
        );
        return
            array
            (
                $this->Htmls_DIV
                (
                    array($buttons),
                    array("CLASS" => 'center')
                )
           );        
    }
}

?>