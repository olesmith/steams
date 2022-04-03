<?php


trait STeams_LeftMenu_Pools
{    
    //
    //* Produces the avaliabe Pool left menu.
    //*

    function STeams_LeftMenu_Pool($pool)
    {
        return
            array
            (
                $this->MyApp_Interface_LeftMenu_Generate_SubMenu_List
                (
                    $this->ReadPHPArray("System/Pools/LeftMenu.php"),
                    $pool
                ),
                /* $this->Htmls_List */
                /* ( */
                /*     $this->STeams_LeftMenu_Pools($pool), */
                /*     array("CLASS" => 'leftmenulist') */
                /* ), */
            );
    }
    //*
    //* Produces the available Tournamet left seasons menu.
    //*

    function STeams_LeftMenu_Pools($season)
    {        
        return
            $this->MyApp_Interface_LeftMenu_Dynamic_Menu
            (
                "",
                $this->PoolsObj(),
                $this->STeams_LeftMenu_Pools_Read($season),
                
                $this->STeams_LeftMenu_Pool_Default($season),
                "Rounds",
                
                $this->STeams_LeftMenu_Args(),
                "Season",
                "#Name",
                "#Year"
            );
    }

    //*
    //* Reads tournament seasons.
    //*

    function STeams_LeftMenu_Pools_Read($season)
    {
        return
            $this->PoolsObj()->Sql_Select_Hashes
            (
                array
                (
                    "Tournament" => $season[ "Tournament" ],
                    "Season"     => $season[ "ID" ],
                ),
                array(),
                "Name"
            );
    }

    //*
    //*
    //*

    function STeams_LeftMenu_Pool_Default()
    {        
        return
            $this->CGI_GETint("Pool");
    }

}

?>