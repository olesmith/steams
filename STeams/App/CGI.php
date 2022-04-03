<?php


trait App_CGI
{    
    //*
    //* Reads common CGI part.
    //*

    function STeams_CGIVars_Get()
    {
        $cgi_datas=array("Tournament");
        
        $hash=array();
        $redirect=False;
        foreach ($cgi_datas as $data)
        {
            $data_cgi=$this->CGI_GETint($data);
            
            if ($data_cgi>0)
            {
                $method="CGI_".$data;
                $hash[ $data ]=$_GET[ $data ];
                $this->$method($hash);
            }
            else
            {
                $method="CGI_".$data."_Default";
                $hash[ $data ]=$this->$method($hash);
                //$redirect=True;
            }
        }

        if ($redirect)
        {            
            $this->CGI_Redirect
            (
                array_merge
                (
                    $this->CGI_Uri2Hash(),
                    $hash
                )
            );
        }

        return array();
    }
    
    //*
    //* Accessor Tournament
    //*

    function Tournament($key="")
    {
        return $this->TournamentsObj()->Tournament($key);
    }
    
    //*
    //* Accessor Season
    //*

    function Season($key="")
    {
        return $this->TournamentsObj()->Season($key);
    }
    
    //*
    //* Accessor Pool
    //*

    function Pool($key="")
    {
        return $this->TournamentsObj()->Pool($key);
    }
    
    //*
    //* Reads Tournament
    //*

    function CGI_Tournament($hash)
    {
        return $this->TournamentsObj()->Tournament();
    }
    //*
    //* Default Tournament
    //*

    function CGI_Tournament_Default($hash)
    {
    }

    //*
    //* 
    //*

    function Tournament_Season_Where($item,$where=array())
    {
        return $this->TournamentsObj()->Tournament_Season_Where($item,$where);
    }
    
    //*
    //* 
    //*

    function Pool_Bets_Match_Where($match,$where=array())
    {
        return $this->TournamentsObj()->Pool_Bets_Match_Where($match,$where);
    }

    
    //*
    //* 
    //*

    function Pool_Bets_Friend_Where($pool_friend,$where=array())
    {
        return $this->TournamentsObj()->Pool_Bets_Friend_Where($pool_friend,$where);
    }
}

?>