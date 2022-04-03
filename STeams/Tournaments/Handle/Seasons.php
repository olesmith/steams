<?php



trait Tournaments_Handle_Seasons
{
    //*
    //* 
    //*

    function Tournament_Handle_Seasons($tournament=array())
    {
        if (empty($tournament)) { $tournament=$this->ItemHash; }

        $h=1;
        $this->Htmls_Echo
        (
            array
            (
                $this->Htmls_H($h++,$this->Tournament("Name")),
                $this->Htmls_H($h++,$this->Tournament_SeasonsObj()->MyMod_ItemsName()),
                $this->Tournament_SeasonsObj()->MyMod_Items_Dynamic
                (
                    0,
                    $this->Tournament_Handle_Seasons_Read($tournament),
                    $group=""
                ),
            )
        );
    }
    
    //*
    //* 
    //*

    function Tournament_Handle_Seasons_Read($tournament=array())
    {
        if (empty($tournament)) { $tournament=$this->ItemHash; }

        return
            array_reverse
            (
                $this->Tournament_SeasonsObj()->Sql_Select_Hashes
                (
                    array("Tournament" => $tournament[ "ID" ]),
                    array(),
                    "Year",
                    $postprocess=True
                )
            );
    }
    
    //*
    //* 
    //*

    function Tournament_Handle_Season($tournament=array())
    {
        if (empty($tournament)) { $tournament=$this->ItemHash; }

        $season=$this->Season();

        $h=1;
        $this->Htmls_Echo
        (
            array
            (
                $this->Htmls_H($h++,$this->Tournament("Name")),
                $this->Htmls_H($h++,$this->Tournament_SeasonsObj()->MyMod_ItemName()),
                $this->Htmls_H($h++,$season[ "Name" ]),
                /* $this->Tournament_SeasonsObj()->MyMod_Items_Dynamic */
                /* ( */
                /*     0, */
                /*     $this->Tournament_Handle_Seasons_Read($tournament), */
                /*     $group="" */
                /* ), */
            )
        );
        
        $this->Tournament_SeasonsObj()->ItemHash=$season;
        $this->Tournament_SeasonsObj()->MyMod_Handle_Edit();
    }
}

?>