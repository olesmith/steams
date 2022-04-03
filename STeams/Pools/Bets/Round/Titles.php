<?php

trait Pool_Bets_Round_Titles
{
    //*
    //* 
    //*

    function Pool_Bets_Round_Title_Rows($edit,$matches)
    {
        $empty=array("","");
        $titles=
            array
            (
                $this->B("No"),
                $this->B($this->FriendsObj()->MyMod_ItemName()),
            );
        
        return
            array
            (
                array_merge
                (
                    $empty,
                    $this->Pool_Bets_Round_Title_Initials($edit,$matches)
                ),
                array_merge
                (
                    $empty,
                    $this->Pool_Bets_Round_Title_Icons($edit,$matches)
                ),
                array_merge
                (
                    $titles,
                    $this->Pool_Bets_Round_Title_Result($edit,$matches)
                ),
            );
    }
    
    //*
    //* 
    //*

    function Pool_Bets_Round_Title_Icons($edit,$matches)
    {
        $titles=array();
        $m=0;
        foreach ($matches as $match)
        {
            $m++;
            array_push
            (
                $titles,
                array
                (
                    "Cell" => $this->MatchesObj()->Tournament_Match_Cell_Teams_Icons
                    (
                        $redit=0,$match,"Icon",
                        $with_minus=False
                    ),
                    "Options" => $this->Pool_Bet_Round_Cell_Options
                    (
                        0,$m,
                        $match
                    ),
                )
            );
        }

        array_push($titles,"","");

        return $titles;
    }

    //*
    //* 
    //*

    function Pool_Bets_Round_Title_Initials($edit,$matches)
    {
        $titles=array();        
        $m=0;
        foreach ($matches as $match)
        {
            $m++;
            array_push
            (
                $titles,
                array
                (
                    "Cell" => $this->B
                    (
                        $this->MatchesObj()->Match_Name
                        (
                            $match,"Initials",
                            $with_minus=True
                        )
                    ),
                    "Options" => array_merge
                    (
                        $this->Pool_Bet_Round_Cell_Options
                        (
                            0,$m,
                            $match
                        ),
                        array
                        (
                            "TITLE" => $this->MatchesObj()->Match_Time($match),
                        )
                    ),
                )
            );
        }

        array_push($titles,"","");

        return $titles;
    }
    
    //*
    //* 
    //*

    function Pool_Bets_Round_Title_Result($edit,$matches)
    {
        $titles=array();
        $m=0;
        foreach ($matches as $match)
        {
            $m++;
            array_push
            (
                $titles,
                array
                (
                    "Cell" => $this->B
                    (
                        $this->MatchesObj()->Match_Result($match),
                        array
                        (
                            "TITLE" => join
                            (
                                "\n",
                                array
                                (
                                    $this->MatchesObj()->Match_Time($match),
                                    $this->MatchesObj()->Match_Status($match),
                                )
                            ),
                        )
                    ),
                    "Options" => $this->Pool_Bet_Round_Cell_Options
                    (
                        0,$m,
                        $match
                    ),
                )
            );
        }

        array_push
        (
            $titles,
            $this->B($this->ApplicationObj()->Sigma),
            $this->B($this->ApplicationObj()->Sigma.$this->ApplicationObj()->Sigma)
        );

        return $titles;
    }
}

?>