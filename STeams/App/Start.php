<?php


trait STeams_Start
{
    //*
    //* 
    //*

    function MyApp_Handle_Start($echo=True)
    {        
        $this->MyApp_Interface_Head();
        if
            (
                $this->CGI_GET("Login")==1
                &&
                empty($this->LoginData)
            )
        {
            $this->MyApp_Login_Form();
        }

        $this->Htmls_Echo
        (
            array
            (
               $this->STeams_Start(),
            )
        );

        exit();
            
    }
    
    //*
    //* 
    //*

    function STeams_Start_Tournament_Group()
    {
        $group="Basic";
        if ($this->MyApp_Interface_Mobile_Is())
        {
            $group="Mobile";
        }

        return $group;
    }
    
    //*
    //* 
    //*

    function STeams_Start()
    {
        if ($this->MyApp_Interface_Mobile_Is())
        {
            return $this->STeams_Mobile();
        }

        if (!empty($_GET[ "Pool" ]))
        {
            $cell_id=
                array
                (
                    "P_".$this->Pool("ID"),
                    "S_".$this->Pool("Season"),
                    "T_".$this->Pool("Tournament"),
                );
            
            $this->Htmls_Echo
            (
                array
                (
                    $this->MyApp_Interface_Top(),
                    $this->Htmls_DIV
                    (
                        "Loading Pool",
                        array
                        (
                            "ID" => $cell_id,
                        )
                    ),
                    $this->Htmls_SCRIPT
                    (
                        $this->JS_Load_URL_2_Element
                        (
                            array
                            (
                                "RAW" => 1,
                                "ModuleName" => "Pools",
                                "Action"     => "Friend",
                                "Tournament" => $this->Pool("Tournament"),
                                "Season"     => $this->Pool("Season"),
                                "Pool"       => $this->Pool("ID"),                             
                            ),
                            $cell_id
                        )
                    ),
                )
            );
        }
        elseif (!empty($_GET[ "Season" ]))
        {
            $cell_id=
                array
                (
                    "S_".$this->Season("ID"),
                    "T_".$this->Season("Tournament"),
                );
            
            $this->Htmls_Echo
            (          
                array
                (
                    $this->MyApp_Interface_Top(),
                    $this->Htmls_DIV
                    (
                        "Loading Season",
                        array
                        (
                            "ID" => $cell_id,
                        )
                    ),
                    $this->Htmls_SCRIPT
                    (
                        $this->JS_Load_URL_2_Element
                        (
                            array
                            (
                                "RAW" => 1,
                                "ModuleName" => "Tournaments",
                                "Action"     => "Teams",
                                "Tournament" => $this->Season("Tournament"),
                                "Season"     => $this->Season("ID"),                      
                            ),
                            $cell_id
                        )
                    ),
                )
            );
        }
        elseif (!empty($_GET[ "Tournament" ]))
        {
            $cell_id=
                array
                (
                    "T_".$this->Pool("Tournament"),
                );
            
            $this->Htmls_Echo
            (          
                array
                (
                    $this->MyApp_Interface_Top(),
                    $this->Htmls_DIV
                    (
                        "Loading Season",
                        array
                        (
                            "ID" => $cell_id,
                        )
                    ),
                    $this->Htmls_SCRIPT
                    (
                        $this->JS_Load_URL_2_Element
                        (
                            array
                            (
                                "RAW" => 1,
                                "ModuleName" => "Tournaments",
                                "Action"     => "Seasons",
                                "Tournament" => $this->Pool("Tournament"),               
                            ),
                            $cell_id
                        )
                    ),
                )
            );
        }
        else
        {
            return
                array
                (
                    $this->MyApp_Interface_Top(),
                    $this->TournamentsObj()->MyMod_Items_Dynamic
                    (
                        0,
                        $this->TournamentsObj()->Sql_Select_Hashes
                        (
                        ),
                        $this->STeams_Start_Tournament_Group()
                    ),
                );
        }
    }
    
    //*
    //* 
    //*

    function MyApp_Handle_GET()
    {
        $args=$this->CGI_URI2Hash();
        $action="Search";
        if (!empty($_GET[ "Tournament" ]))
        {
            $action="Groups";
        }

        $args[ "NoMenu" ]=1;
        $args[ "RAW" ]=1;
        $args[ "Action" ]=$action;
        unset($args[ "Search" ]);
        $args[ "NoSearch" ]=1;
        $args[ "ModuleName" ]="Tournaments";

        if (preg_match('/^(Friend)$/',$this->Profile()))
        {
            $args[ "ModuleName" ]="Pools";            
        }

        return $args;

    }

    //*
    //* 
    //*

    function STeams_Mobile()
    {
        $dest_id="Tournament_Cell";
        $season_dest_id="Season";

        return
            array
            (
                $this->MyApp_Interface_Body_Mobile(),

                $this->Htmls_SPAN
                (
                    array
                    (
                        "*",
                    ),
                    array
                    (
                        "ID" => $dest_id,
                    )
                ),
                $this->Htmls_SCRIPT
                (
                    array
                    (
                        $this->JS_Load_Once
                        (
                            $this->STeams_Tournaments_Select_URI($dest_id),
                            $dest_id
                        ),
                    )
                ),
                $this->BR(),
            );
    }

    //*
    //* 
    //*

    function STeams_Tournaments_Select_URI($dest_id)
    {
        return
            array_merge
            (
                $this->CGI_URI2Hash(),
                array
                (
                    "RAW" => 1,
                    "NoHorMenu" => 1,
                    "ModuleName" => "Tournaments",
                    "Action" => "Select",
                    "Dest" => $dest_id,
                )
            );
    }

    //var $__Tournaments__=array();
    //var $__Seasons__=array();
}

?>
