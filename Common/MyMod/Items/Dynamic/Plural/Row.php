<?php

trait MyMod_Items_Dynamic_Plural_Row
{
    //*
    //* Create plural row.
    //*

    function MyMod_Items_Dynamic_Plural_Row($items,$group)
    {
        $html=
            $this->Htmls_Menues_Dynamic
            (
                //$menu info
                array
                (
                    "Name" => "Plural Row",
                    "Title" => "Plural Row",
                    "Color" => "blue",
                    "Hide_Color" => "grey",
                    "Reload_Color" => "#efa572",
                    "Toggle_Others" => True,
                ),
                
                $this->MyMod_Items_Dynamic_Plural_Entries
                (
                    $items,$group
                ),
                $this->MyMod_Items_Dynamic_Plural_Destinations
                (
                    $items,$group
                )
            );

        //Possibly add extra cell to avoid last cell being multicolumned
        if (!empty($html) && is_array($html))
        {
            array_push($html,"");
        }

        return $html;
    }
}

?>