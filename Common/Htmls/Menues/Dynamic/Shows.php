<?php


trait Htmls_Menues_Dynamic_Shows
{
    //*
    //* 
    //*

    function Htmls_Menues_Dynamic_Show_JS($key,$is_hide_cell,$display,$dest_display)
    {
        $js=
            array
            (
                "\n//Entering: Htmls_Menues_Dynamic_Show_JS",
                "//Elements to show",
                $this->JS_Show_Elements_By_ID
                (
                    $this->Htmls_Menues_Dynamic_Show_IDs
                    (
                        $key,$is_hide_cell
                    ),
                    $display
                )
            );

        if (!$is_hide_cell)
        {
            $destination=
                $this->Htmls_Menues_Dynamic_Entry_Destination_ID
                (
                    $key
                );

            if (!empty($destination))
            {
                
                array_push
                (
                    $js,
                    "//Show Destination",
                    $this->JS_Show_Elements_By_ID
                    (
                        $destination,
                        $dest_display
                    )
                );
            }

            
            array_push
            (
                $js,
                "//Change color of Show",
                $this->JS_Function_Call_As_String
                (
                    "Color_Element_By_ID",
                    array
                    (
                        $this->Htmls_Menues_Dynamic_Entry_ID($key,"Show"),
                        $this->Htmls_Menues_Dynamic_Toggle_Color_Reload($key),
                    )
                )
            );
        }

        return $js;
    }
    
    //*
    //* 
    //*

    function Htmls_Menues_Dynamic_Show_IDs($key,$is_hide_cell)
    {
        $ids=array();
        if ($this->Htmls_Menues_Dynamic_Entry_Toggle($key))
        {
            $ids=
                $this->Htmls_Menues_Dynamic_Entry_Other_IDs
                (
                    $key,"Show"
                );
        }

        if ($is_hide_cell)
        {
            array_push
            (
                $ids,
                $this->Htmls_Menues_Dynamic_Entry_ID
                (
                    $key,"Show"
                )
            );
        }
        else
        {
            array_push
            (
                $ids,
                $this->Htmls_Menues_Dynamic_Entry_ID
                (
                    $key,"Hide"
                )
            );
        }

        return $ids;
    }
}
?>