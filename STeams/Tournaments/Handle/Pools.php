<?php



trait Tournaments_Handle_Pools
{
    //*
    //* 
    //*

    function Tournament_Handle_Pools($tournament=array())
    {
        if (empty($tournament)) { $tournament=$this->ItemHash; }

        $this->Htmls_Echo
        (
            $this->PoolsObj()->MyMod_Items_Dynamic
            (
                0,
                $this->Tournament_Handle_Pools_Read($tournament),
                $group=""
            )
        );
    }
    
    //*
    //* 
    //*

    function Tournament_Handle_Pools_Read($tournament=array())
    {
        if (empty($tournament)) { $tournament=$this->ItemHash; }

        return
            array_reverse
            (
                $this->PoolsObj()->Sql_Select_Hashes
                (
                    array
                    (
                        "Tournament" => $tournament[ "ID" ],
                        "Season" => $this->Season("ID"),
                    ),
                    array(),
                    "Name"
                )
            );
    }
}

?>