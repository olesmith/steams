<?php


include_once("LeftMenu/Tournaments.php");
include_once("LeftMenu/Seasons.php");
include_once("LeftMenu/Pools.php");


trait STeams_LeftMenu
{
    use
        STeams_LeftMenu_Tournaments,
        STeams_LeftMenu_Seasons,
        STeams_LeftMenu_Pools;
    //*
    //*
    //* Handles Dynamic Left menu generation
    //*

    function MyApp_Interface_LeftMenu_Handle()
    {
        $module=$this->CGI_GET("Module");
        if ($module=="Tournaments")
        {
            $id=$this->CGI_GETint("Tournament");
            $item=
                $this->TournamentsObj()->Sql_Select_Hash
                (
                    array("ID" => $id)
                );

            $this->Htmls_Echo
            (
                $this->STeams_LeftMenu_Tournament($item)
            );
        }
        elseif ($module=="Tournament_Seasons")
        {
            $id=$this->CGI_GETint("Season");
            $item=
                $this->Tournament_SeasonsObj()->Sql_Select_Hash
                (
                    array("ID" => $id)
                );

            //var_dump($item);

            $this->Htmls_Echo
            (
                $this->STeams_LeftMenu_Season($item)
            );
        }
        elseif ($module=="Pools")
        {
            $id=$this->CGI_GETint("Pool");
            $item=
                $this->PoolsObj()->Sql_Select_Hash
                (
                    array("ID" => $id)
                );

            //var_dump($item);

            $this->Htmls_Echo
            (
                $this->STeams_LeftMenu_Pool($item)
            );
        }
    }

    //*
    //* 
    //*

    function STeams_LeftMenu_Args()
    {
        $href=array();
        foreach (array("Tournament","Season","Pool") as $cgi_key)
        {
            if (!empty($_GET[ $cgi_key ]))
            {
                $href[ $cgi_key ]=$this->CGI_GETint($cgi_key);
            }
        }

        return $href;
    }
}

?>