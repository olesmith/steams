<?php

include_once("Select/Actions.php");
include_once("Select/Pool.php");

trait Tournaments_Seasons_Select
{
    use
        Tournaments_Seasons_Select_Actions,
        Tournaments_Seasons_Select_Pool;
    
    //*
    //* 
    //*

    function Tournament_Seasons_Select_Handle()
    {
        $actions=array("Show","Season","Teams","Matches","Rounds","Pools");

        $default_action="Teams";
        if (!empty($_GET[ "Pool" ]))
        {
            $default_action="";
        }
        
        $dest_id="Action";
        
        $this->Htmls_Echo
        (
            array
            (
                $this->B
                (
                    array
                    (
                        $this->MyMod_ItemName(":"),
                    )
                ),
                $this->Htmls_Select_Hashes_Field
                (
                    "Season",
                    $this->Tournament_Seasons_Read(),
                    //$args=
                    array
                    (
                        "Selected" => $this->Season("ID"),
                        "Name_Key"  => "Name",
                        "Title_Key" => "ID",
                    ),
                    //$options=
                    array
                    (                        
                        "ONCHANGE" => array
                        (                            
                            $this->JS_Select_Send
                            (
                                $this->CGI_URI2Hash(),
                                "Season"
                            ),
                        ),
                    )
                ),
                $this->Tournament_Season_Select_Actions_Field
                (
                    $dest_id,$actions,$default_action
                ),
                
                $this->BR(),
                $this->Tournament_Season_Select_Pool(),
                $this->BR(),

                $this->Tournament_Season_Select_Actions_SPAN($dest_id),
                
                $this->Tournament_Season_Select_Actions_SCRIPT
                (
                    $dest_id,$default_action
                ),
                $this->BR(),
            )
        );
    }
}

?>