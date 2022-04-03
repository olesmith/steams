<?php



trait Tournaments_Handle_Rounds
{
    //*
    //* 
    //*

    function Tournament_Handle_Rounds($tournament=array())
    {
        if (empty($tournament)) { $tournament=$this->ItemHash; }

        $this->__Tournament__=$tournament;

        $rounds=
            $this->RoundsObj()->Sql_Select_Hashes
            (
                array
                (
                    "Tournament" => $this->Tournament("ID"),
                    "Season" =>  $this->Season("ID"),
                ),
                array(),
                "StartDate,Number"
            );

        
        $this->Htmls_Echo
        (
            $this->RoundsObj()->MyMod_Items_Dynamic
            (
                0,
                $rounds
            )
        );
        /* $this->Htmls_Echo */
        /* ( */
        /*     $this->Htmls_Frame */
        /*     ( */
        /*         $this->GroupsObj()->Tournament_Groups_Rounds_Generate() */
        /*     ) */
        /* ); */
    }
}

?>