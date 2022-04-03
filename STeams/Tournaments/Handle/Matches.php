<?php



trait Tournaments_Handle_Matches
{
    //*
    //* 
    //*

    function Tournament_Handle_Matches($tournament=array())
    {
        if (empty($tournament)) { $tournament=$this->ItemHash; }

        $this->__Tournament__=$tournament;

        $this->Htmls_Echo
        (
            $this->Htmls_Frame
            (
                array
                (
                    $this->Htmls_H
                    (
                        1,
                        array
                        (
                            $this->Season("Name").",",
                            $this->MatchesObj()->MyMod_ItemsName()
                        )
                    ),
                    $this->Tournament_Handle_Matches_Cup($tournament),
                    $this->Tournament_Handle_Matches_Groups($tournament),
                )
            )
        );
    }

    //*
    //* 
    //*

    function Tournament_Handle_Matches_Groups($tournament)
    {
        return
            array
            (
                $this->GroupsObj()->Tournament_Groups_Matches_Generate()
            );
    }

    
    //*
    //* 
    //*

    function Tournament_Handle_Matches_Cup($tournament)
    {
        $data="Stage";
        
        $cup_matches=
            $this->MatchesObj()->Sql_Select_Hashes
            (
                array
                (
                    "__Type__" =>
                    $this->Sql_Table_Column_Name_Qualify($data).
                    ">".
                    $this->Sql_Table_Column_Value_Qualify(2)
                ),
                array(),
                "Date DESC,HHMM DESC"
            );
        
        $cupped_matches=array();
        foreach ($cup_matches as $cup_match)
        {
            $stage=$cup_match[ $data ];
            if (empty($cupped_matches[ $stage]))
            {
                $cupped_matches[ $stage ]=array();
            }

            array_push($cupped_matches[ $stage ],$cup_match);
        }

        $html=array();

        $stages=$this->MatchesObj()->ItemData[ $data ][ "Values" ];

        foreach ($cupped_matches as $stage => $matches)
        {
            $id=
                $this->Tournament_Handle_Matches_Cup_Stage_ID($tournament,$stage);
        
            array_push
            (
                $html,
                $this->Htmls_H
                (
                    2,
                    array
                    (
                        $stages[ $stage-1 ],
                        $this->Htmls_Dynamic_Cells
                        (
                            array
                            (
                                "Tag" => "SPAN",
                                "ID" => $id,
                                "Names" => array
                                (
                                    $this->MyMod_Interface_Icon("fas fa-plus"),
                                    $this->MyMod_Interface_Icon("fas fa-divide"),
                                ),
                                "Options" => array
                                (
                                    array
                                    (
                                        "ONCLICK" =>
                                        $this->JS_Show_Element_By_ID
                                        (
                                            $id
                                        ),
                                    ),
                                    array
                                    (
                                        "ONCLICK" =>
                                        $this->JS_Hide_Element_By_ID
                                        (
                                            $id
                                        ),
                                    ),
                                ),
                                "Styles" => array
                                (
                                    array
                                    (
                                        "display" => 'none',
                                        "color" => 'blue',
                                    ),
                                    array
                                    (
                                        "color" => 'orange',
                                    ),
                                ),
                            )
                        ),
                    )
                ),
                $this->Tournament_Handle_Matches_Cup_Stage
                (
                    $tournament,
                    $stage,$matches
                )
            );
        }

        return $html;
    }

    
    //*
    //* 
    //*

    function Tournament_Handle_Matches_Cup_Stage_ID($tournament,$stage)
    {
        return
            array
            (
                "Tournament",$tournament[ "ID" ],
                "Stage",
                $stage
            );
    }
    
    //*
    //* 
    //*

    function Tournament_Handle_Matches_Cup_Stage($tournament,$stage,$matches)
    {
        return
            array
            (
                $this->Htmls_DIV
                (
                    array
                    (
                        $this->Tournament_MatchesObj()->MyMod_Items_Dynamic
                        (
                            0,
                            $matches,
                            "Basic"
                        ),
                    ),
                    array
                    (
                        "ID" => $this->Tournament_Handle_Matches_Cup_Stage_ID($tournament,$stage),
                    )
                ),
            );
    }
}

?>