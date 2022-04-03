<?php



trait Tournaments_Handle_Groups
{
    //*
    //* 
    //*

    function Tournament_Handle_Groups($tournament=array())
    {
        if (empty($tournament)) { $tournament=$this->ItemHash; }

        $this->__Tournament__=$tournament;
      

        $this->Tournament_Update_Structure($tournament);

        $groups=$this->Tournament_Read_Groups();
        $teams=$this->Tournament_Read_Teams();

        $this->Htmls_Echo
        (
            array
            (
                $this->Htmls_H
                (
                    1,
                    $this->GroupsObj()->MyMod_ItemsName().
                    ", ".
                    $tournament[ "Name" ]
                ),
                $this->GroupsObj()->MyMod_Items_Dynamic
                (
                    0,$groups,
                    "Basic"
                ),
            )
        );
    }
}

?>