<?php

trait MyMod_Items_Dynamic_Form
{
    //*
    //* Creates table with $items
    //*

    function MyMod_Items_Dynamic_Form($id,$edit,$items,$group,$extrarows=array(),$options=array())
    {
        $this->ItemData();
        $this->Actions();
        $this->ItemDataGroups();
     
        return
            $this->Htmls_Form
            (
                $edit,
                $id,
                $action="",

                //$contents=
                $this->Htmls_Table
                (
                    "",
                    $this->MyMod_Items_Dynamic_Html
                    (
                        $edit,$items,$group,
                        $extrarows
                    )
                ),

                //$args=
                array
                (
                    "Buttons" =>
                    $this->Buttons
                    (
                        $this->MyLanguage_GetMessage("SendButton").
                        " ".
                        $this->MyMod_ItemsName()
                    ),
                    "Hiddens" => array
                    (
                        "Update" => 1,
                    ),
                ),
                
                $options
            );
    }
}

?>