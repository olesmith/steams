<?php

trait Tournaments_Seasons_Read
{
    var $__Seasons__=array();
    var $__Pools__=array();
    
    //*
    //* 
    //*

    function Tournament_Seasons_Read()
    {
        $tournament_id=0;
        if (!empty($_GET[ "Tournament" ]))
        {
            $tournament_id=$_GET[ "Tournament" ];
        }
        
        if (empty($this->__Seasons__))
        {
            $this->__Seasons__=
                $this->Tournament_SeasonsObj()->Sql_Select_Hashes
                (
                    array
                    (
                        "Tournament" => $tournament_id,
                    ),
                    array("ID","Name","Year"),
                    "ID"
                );
        }
        
        return $this->__Seasons__;
    }

    
    //*
    //* 
    //*

    function Tournament_Season_Pools_Read($season=array())
    {
        if (empty($season))
        {
            $season=$this->Season();
        }

        if (empty($this->__Pools__))
        {
            $this->__Pools__=
                $this->PoolsObj()->Sql_Select_Hashes
                (
                    array
                    (
                        "Tournament" => $season[ "Tournament" ],
                        "Season"     => $season[ "ID" ],
                    ),
                    array("ID","Name","Friend"),
                    "ID"
                );
        }
        
        return $this->__Pools__;
    }
}

?>