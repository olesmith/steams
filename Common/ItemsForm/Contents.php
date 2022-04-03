<?php


trait ItemsFormContents
{
    //*
    //* function ItemsForm_MyMod_Groups_Menu, Parameter list:
    //*
    //* Generates horisontl menu with links to data groups.
    //* 
    //*

    function ItemsForm_MyMod_Groups_Menu()
    {
        if ($this->Args[ "GroupsMenu" ])
        {
            $args=$this->CGI_URI2Hash();
            foreach ($this->Args[ "IgnoreGETVars" ] as $key) { unset($args[ $key ]); }
            foreach ($this->Args[ "DetailsAddVars" ] as $key) { $args[ $key ]=$this->CGI_GET($key); }

            return
                array
                (
                    $this->MyMod_Groups_Menu_old
                    (
                        $this->B
                        (
                            "Dados: ",
                            array("ID" => "GroupsMenu")
                        ),
                        $args,
                        "#GroupsMenu"
                    ).
                    $this->BR()
                );
        }

        return "";
    }

    //*
    //* function ItemsForm_Contents, Parameter list:
    //*
    //* Generates table listing, with possible edit row - and add row.
    //* 
    //*

    function ItemsForm_Contents()
    {
        return
            array
            (
                $this->H
                (
                    2,
                    $this->Args[ "FormTitle" ],
                    array("ID" => "TOP")
                ),
                $this->ItemsForm_MyMod_Groups_Menu(),
                $this->BR(),
                $this->Table_Html($this->Args),
            );
    }

}

?>