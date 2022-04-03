<?php

include_once("Handle/Select.php");
include_once("Handle/Seasons.php");
include_once("Handle/Groups.php");
include_once("Handle/Teams.php");
include_once("Handle/Rounds.php");
include_once("Handle/Matches.php");
include_once("Handle/Pools.php");

trait Tournaments_Handle
{
    use
        Tournaments_Handle_Select,
        Tournaments_Handle_Seasons,
        Tournaments_Handle_Groups,
        Tournaments_Handle_Teams,
        Tournaments_Handle_Rounds,
        Tournaments_Handle_Matches,
        Tournaments_Handle_Pools;

    
    function Tournament_Handle_LeftMenu($tournament=array())
    {
        if (empty($tournament)) { $tournament=$this->ItemHash; }

        $this->Htmls_Echo
        ( 
            array
            (
                $this->ApplicationObj()->MyApp_Interface_LeftMenu_Generate_SubMenu_List
                (
                    $this->ReadPHPArray("System/Tournaments/LeftMenu.php"),
                    $tournament,
                    array(),$call_method=True,$debug=True
                )
            )
        );
        
    }

    
    function Tournament_Handle_API($tournament=array())
    {
        if (empty($tournament)) { $tournament=$this->ItemHash; }

        $div_id="API_".$tournament[ "ID" ];
        $div_id_info="API_".$tournament[ "ID" ]."_1";

        $this->Htmls_Echo
        (
            array
            (
                $this->Htmls_DIV
                (
                    "APIs",
                    array
                    (
                        "ID" => $div_id_info,
                    )
                ),
                $this->Htmls_SCRIPT
                (
                    array
                    (
                        $this->JS_Function_Call
                        (
                            "Load_URL_2_Element_Do",
                            array
                            (
                                $div_id_info,
                                
                                "?".
                                $this->CGI_Hash2URI
                                (                
                                    array
                                    (
                                        "RAW" => 1,
                                        "NoHorMenu" => 1,
                                        "ModuleName" => "Tournaments",
                                        "Action"     => "Edit",
                                        "Tournament" => $tournament[ "ID" ],
                                        "Season"     => $tournament[ "Season" ],
                                        "GroupName" => "API_Status",
                                    )
                                )
                            )
                        ),
                    )
                ),
                $this->Htmls_DIV
                (
                    "APIs",
                    array
                    (
                        "ID" => $div_id,
                    )
                ),
                $this->Htmls_SCRIPT
                (
                    array
                    (
                        $this->JS_Function_Call
                        (
                            "Load_URL_2_Element_Do",
                            array
                            (
                                $div_id,
                                "?".
                                $this->CGI_Hash2URI
                                (                
                                    array
                                    (
                                        "RAW" => 1,
                                        "NoHorMenu" => 1,
                                        "ModuleName" => "APIs",
                                        "Action"     => "Search",
                                        "Tournament" => $tournament[ "ID" ],
                                        "Season"     => $tournament[ "Season" ],
                                    )
                                )
                            )
                        ),
                    )
                ),
            )
        );
        

        print "Tournament_Handle_API<BR>";
        $this->Tournament_API_Matches_Retrieve($tournament);
        print "Tournament_Handle_API<BR>";
    }
}

?>