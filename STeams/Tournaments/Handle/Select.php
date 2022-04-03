<?php



trait Tournaments_Handle_Select
{
    //*
    //* 
    //*

    function Tournament_Handle_Select($tournament=array())
    {
        if (empty($tournament))
        {
            $tournament=$this->ItemHash;
        }

        $season_dest_id="Season";
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
                    "Tournament",
                    $this->Tournaments_Read(),
                    //$args=
                    array
                    (
                        "Selected" => $tournament[ "ID" ],
                    ),
                    //$options=
                    array
                    (
                        "ONCHANGE" => array
                        (                            
                            $this->JS_Select_Send
                            (
                                $this->Tournament_Handle_Select_Season_URL
                                (
                                    $season_dest_id
                                ),
                                $season_dest_id
                            ),
                        ),
                    ) 
                ),
                $this->BR(),
                $this->Htmls_SPAN
                (
                    "",
                    array
                    (
                        "ID" => $season_dest_id,
                    )
                ),
                $this->Htmls_SCRIPT
                (
                    array
                    (
                        "\n",
                        $this->JS_Load_Once
                        (
                            $this->Tournament_Handle_Select_Season_URL($season_dest_id),
                            $season_dest_id
                        ),
                    )
                ),
                $this->BR(),
            )
        );
    }
    
    //*
    //* 
    //*

    function Tournament_Handle_Select_Season_URL($season_dest_id)
    {
        $args=$this->CGI_URI2Hash();

        //if (isset($args[ "Season" ])) { unset($args[ "Season" ]); }
        
        return
            array_merge
            (
                $args,
                array
                (
                    "NoHorMenu" => 1,
                    "ModuleName" => "Tournament_Seasons",
                    "Action" => "Select",
                    "Dest" => $season_dest_id,
                )
            );
    }
}

?>