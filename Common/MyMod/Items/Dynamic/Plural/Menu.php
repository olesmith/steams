<?php

trait MyMod_Items_Dynamic_Plural_Menu
{
    //*
    //* Plural row, below items table. For instance addrow.
    //* Create rows with plural dynamic actions, addind Area destination row.
    //*

    function MyMod_Items_Dynamic_Plural_Menu($items,$group)
    {
        $this->Group=$group;
        $this->Defs=
            $this->ItemDataGroups($group,"Dynamic");

        $this->Htmls_Menues_Dynamic_Init
        (
            //$menu info
            array
            (
                "Name" => "",
                "Title" => "",
                "Color" => "blue",
                "Hide_Color" => "grey",
                "Back_Color" => "white",
                "Reload_Color" => "#efa572",
                "Toggle_Others" => True,
            ),

                
            //Entries
            $this->MyMod_Items_Dynamic_Plural_Entries($items,$group),

            //Entries
            $this->MyMod_Items_Dynamic_Plural_Destinations($items,$group)
        );

        return
            array
            (
                $this->Htmls_DIV
                (
                    $this->Htmls_Menues_Dynamic_Entries($extras=False),
                    array
                    (
                        "CLASS" => 'left',
                    )
                ),
                $this->Htmls_DIV
                (
                    $this->Htmls_Menues_Dynamic_Destinations(),
                    array
                    (
                        "CLASS" => 'center',
                    )
                ),
            );
    }
}

?>