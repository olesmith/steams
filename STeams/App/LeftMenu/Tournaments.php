<?php


trait STeams_LeftMenu_Tournaments
{ 
    var $__Tournaments__=array();
    
    //
    //* Produces the avaliabe Tournament left menu.
    //*

    function STeams_LeftMenu_Tournament($tournament)
    {        
        return
            array
            (
                $this->MyApp_Interface_LeftMenu_Generate_SubMenu_List
                (
                    $this->ReadPHPArray("System/Tournaments/LeftMenu.php"),
                    $tournament
                ),
                $this->Htmls_List
                (
                    $this->STeams_LeftMenu_Seasons($tournament),
                    array("CLASS" => 'leftmenulist')
                ),
            );
    }
    
    //*
    //* 
    //*

    function STeams_LeftMenu_Tournaments()
    {        
        return
            $this->MyApp_Interface_LeftMenu_Dynamic_Menu
            (
                "",
                $this->TournamentsObj(),
                $this->STeams_LeftMenu_Tournaments_Read(),
                
                $this->STeams_LeftMenu_Tournament_Default(),
                $action="Rounds",
                
                $this->STeams_LeftMenu_Args(),
                "Tournament",
                "#Title",
                "#Name"
            );
    }
        
    
    //*
    //* 
    //*

    function STeams_LeftMenu_Tournaments_Read()
    {
        if (empty($this->__Tournaments__))
        {
            $this->__Tournaments__=
                $this->TournamentsObj()->Sql_Select_Hashes
                (
                    array()
                );
        }

        return $this->__Tournaments__;
    }
    //*
    //* 
    //*

    function STeams_LeftMenu_Tournament_Default()
    {
        $tournament_id=$this->CGI_GETint("Tournament");

        return $tournament_id;
    }
}

?>