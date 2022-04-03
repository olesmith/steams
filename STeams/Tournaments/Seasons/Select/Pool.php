<?php

trait Tournaments_Seasons_Select_Pool
{
    //*
    //* 
    //*

    function Tournament_Season_Select_Pool()
    {        
        $dest_id="Pools";

        return
            array
            (
                $this->Htmls_SPAN
                (
                    "*",
                    array
                    (
                        "ID" => $dest_id,
                    )
                ),
                $this->Htmls_SCRIPT
                (
                    $this->JS_Load_Once
                    (
                        $this->Tournament_Seasons_Select_Pool_URL
                        (
                            $dest_id
                        ),
                        $dest_id
                    )
                ),
            );
    }
    
    //*
    //* 
    //*

    function Tournament_Seasons_Select_Pool_URL($dest_id)
    {
        $args=$this->CGI_URI2Hash();
        if (isset($args[ "Login" ]))
        {
            unset($args[ "Login" ]);
        }
        
        return
            array_merge
            (
                $args,
                array
                (
                    "NoHorMenu" => 1,
                    "ModuleName" => "Pools",
                    "Dest" => $dest_id,
                )
            );
    }
}

?>