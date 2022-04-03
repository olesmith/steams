<?php

trait MyMod_HorMenu_Entry_URL
{
    //*
    //* Menu entry url for loading.
    //*

    function MyMod_HorMenu_Entry_URL($action,$item,$field_id)
    {
        return
            "?".
            $this->CGI_Hash2URI
            (
                array_merge
                (
                    //array("ModuleName" => $this->ModuleName),
                    $this->CGI_URI2Hash
                    (
                        $this->MyActions_Entry_URL
                        (
                            $action,
                            $item
                        )
                    ),
                    $this->MyMod_CGI_RAW
                    (
                        array
                        (
                            "NoHorMenu" => 1,
                            "Dest" => $field_id,
                        )
                    )
                )
            );
    }
}

?>