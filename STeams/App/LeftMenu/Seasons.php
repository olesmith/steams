<?php


trait STeams_LeftMenu_Seasons
{    
    //
    //* Produces the avaliabe Tournament left menu.
    //*

    function STeams_LeftMenu_Season($season)
    {
        $menu=
            $this->MyApp_Interface_LeftMenu_Generate_SubMenu_List
            (
                $this->ReadPHPArray("System/Tournaments/Seasons/LeftMenu.php"),
                $season
            );
        
        if ($this->Profile_Public_Is()) { return array($menu); }
        
        return
            array
            (
                $menu,
                $this->Htmls_List
                (
                    $this->STeams_LeftMenu_Pools($season),
                    array("CLASS" => 'leftmenulist')
                ),
            );
    }
    
    //*
    //* Produces the available Tournamet left seasons menu.
    //*

    function STeams_LeftMenu_Seasons($tournament)
    {        
        return
            $this->MyApp_Interface_LeftMenu_Dynamic_Menu
            (
                "",
                $this->Tournament_SeasonsObj(),
                $this->STeams_LeftMenu_Seasons_Read($tournament),
                
                $this->STeams_LeftMenu_Season_Default($tournament),
                "Teams",
                
                $this->STeams_LeftMenu_Args(),
                "Season",
                "#Name",
                "#Year"
            );
    }

    //*
    //* Produces the available Tournamet left seasons menu.
    //*

    function STeams_LeftMenu_Season_Action($tournament)
    {
        $action="Show";
        if
            (
                $this->Profile_Admin_Is()
            )
        {
            $action="Edit";
        }
        
        return $action;
    }

    //*
    //* Reads tournament seasons.
    //*

    function STeams_LeftMenu_Seasons_Read($tournament)
    {        
        return
            array_reverse
            (
                $this->Tournament_SeasonsObj()->Sql_Select_Hashes
                (
                    array
                    (
                        "ID" => $tournament[ "Season" ],
                    ),
                    array(),
                    "StartDate"
                )
            );
    }

    //*
    //* Reads tournament seasons.
    //*

    function STeams_LeftMenu_Season_Default($tournament)
    {        
        return
            $this->TournamentsObj()->Season("ID");
    }

}

?>