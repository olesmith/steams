<?php


trait Pool_Friend
{
    //*
    //* 
    //*

    function Pool_Friend_Handle()
    {
        $pool_friend=
            $this->Pool_FriendsObj()->Pool_Friend_Read();


        $h=1;
        $this->Htmls_Echo
        (
            array
            (
               /* $this->Htmls_H */
               /*  ( */
               /*      $h++, */
               /*      $this->TournamentsObj()->MyMod_ItemName(": "). */
               /*      $this->Tournament("Name") */
               /*  ), */
                $this->Htmls_H
                (
                    $h++,
                    $this->Season("Name")
                ),
                $this->Htmls_H
                (
                    $h++,
                    $this->Pool("Name")
                ),
                $this->Htmls_H
                (
                    $h++,
                    $pool_friend[ "Name" ]
                ),
                $this->GroupsObj()->Tournament_Groups_Rounds_Generate
                (
                    $datagroup="Friend"
                )
            )
        );
    }
}

?>