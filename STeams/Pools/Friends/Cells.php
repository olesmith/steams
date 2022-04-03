<?php

trait Pool_Friends_Cells
{
    //*
    //* 
    //*

    function Pool_Friend_Cell_Points($edit=0,$item=array(),$data="")
    {
        if (empty($item))
        {
            return $this->B($this->ApplicationObj()->Sigma);
        }

        return
            $this->B
            (
                $this->Pool_BetsObj()->Sql_Select_Calc
                (
                    array
                    (
                        "Tournament"       => $this->Tournament("ID"),
                        "Pool_Friend"      => $item[ "ID" ],
                    ),
                    "Points"
                )
            );
    }
    
    //*
    //* 
    //*

    function Pool_Friend_Cell_Stats($edit=0,$item=array(),$data="")
    {
        if (empty($item))
        {
            return "";
        }
        
        return
            $this->RoundsObj()->Round_Cell_Friend_Scores_DIV
            (
                $item,
                $item[ "Scores" ]
            );
        
    }
}

?>