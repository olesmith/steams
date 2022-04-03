<?php

trait Tournament_Matches_Cell
{
    //*
    //* 
    //*

    function Tournament_Goals_Input_Options($data,$item,$options=array())
    {
        return
            array_merge
            (
                $options,
                array
                (
                    /* "ONKEYPRESS" => array */
                    /* ( */
                    /*     $this->JS_Input_Cyclic_KeyBoard */
                    /*     ( */
                    /*         15, */
                    /*         array(), */
                    /*         +1 */
                    /*     ) */
                    /* ), */
                    "ONCLICK" => array
                    (
                        $this->JS_Input_Cyclic_Increasing(15)
                    ),
                    "STYLE" => array
                    (
                        'padding' =>  "1px",
                        'margin' =>  "1px",
                        "width" => "20px",
                        "border-radius" => '0px',
                        "color" => 'green',
                    ),
                )
            );
    }

    //*
    //* 
    //*

    function Tournament_Match_Cell($edit,$match,$team1,$team2)
    {
        $cells=
            array
            (
                $this->MyMod_Interface_Icon("fas fa-balance-scale")
            );
        
        if (!empty($match))
        {
            
            $cells=
                array
                (
                    $this->Tournament_Match_Cell_Name($edit,$match),

                    $this->BR(),
                    
                    $this->Tournament_Match_Cell_Round($edit,$match,$team1,$team2),
                    $this->Tournament_Match_Cell_Date($edit,$match,$team1,$team2),
                    $this->Tournament_Match_Cell_Hour($edit,$match,$team1,$team2),

                    $this->BR(),
                    
                    
                    $this->Tournament_Match_Cell_Goals($edit,$match,$team1,$team2),
                   
                );
        }

        return array($cells);
    }


    //*
    //* 
    //*

    function Tournament_Match_TD_Options($team1_n,$team2_n,$edit,$tournament,$match,$group,$color="white")
    {
        return
            array_merge
            (
                array
                (
                    "CLASS" => $this->Tournament_Match_Classes_Group_Teams
                    (
                        $tournament,$group,$team1_n,$team2_n
                    ),
                    
                    "ONMOUSEOVER" => array
                    (
                        //Mark this row/col
                        $this->JS_Highlight_ByClass
                        (
                            $this->Tournament_Match_Classes_Group_Teams
                            (
                                $tournament,$group,$team1_n,0
                            ),
                            $color
                        ),
                        $this->JS_Highlight_ByClass
                        (
                            $this->Tournament_Match_Classes_Group_Teams
                            (
                                $tournament,$group,0,$team2_n
                            ),
                            $color
                        ),
                    ),
                    "ONMOUSEOUT" => array
                    (
                        //Unmark this row/col
                        $this->JS_Highlight_ByClass
                        (
                            $this->Tournament_Match_Classes_Group_Teams
                            (
                                $tournament,$group,$team1_n,0
                            )
                        ),
                        $this->JS_Highlight_ByClass
                        (
                            $this->Tournament_Match_Classes_Group_Teams
                            (
                                $tournament,$group,0,$team2_n
                            )
                        ),


 
                        //Redo actual cell
                        $this->JS_Highlight_ByClass
                        (
                            $this->Tournament_Match_Classes_Group_Teams
                            (
                                $tournament,$group,$team1_n,$team2_n
                            )
                        ),
                    ),

                ),
                $this->Tournament_Matches_Group_Options
                (
                    $tournament,$team2_n
                )
            );
    }
    
        
    //*
    //* 
    //*

    function Tournament_Match_Cell_Time($edit,$match,$data="")
    {
        if (empty($match)) { return $this->MyMod_Data_Title("Date"); }
        
        return
            array
            (
                $this->MyMod_Data_Field
                (
                    $edit,$match,
                    "Date"
                ),
                $this->BR(),
                $this->MyMod_Data_Field
                (
                    $edit,$match,
                    "HHMM"
                ),
            );
    }

    //*
    //* 
    //*

    function Tournament_Match_Cell_Status($edit,$match,$data="")
    {
        if (empty($match)) { return $this->MyMod_Data_Title("Status"); }
        
        return
            array
            (
                $this->MyMod_Data_Field
                (
                    $edit,$match,
                    "Status"
                ),
                $this->BR(),
                $this->MyMod_Data_Field
                (
                    $edit,$match,
                    "Duration"
                ),
            );
    }

    
    //*
    //* 
    //*

    function Tournament_Match_Cell_Name($edit,$match,$data="")
    {
        if (empty($match)) { return $this->MyMod_Data_Title("Name"); }

        return
            array
            (
                $this->TeamsObj()->Team_Name($match[ "Team1"],$key="Name"),
                $this->BR()."-". $this->BR(),
                $this->TeamsObj()->Team_Name($match[ "Team2"],$key="Name"),
            );
    }
    //*
    //* 
    //*

    function Tournament_Match_Cell_Round($edit,$match,$team1,$team2)
    {
        return
            $this->MyMod_Data_Field
            (
                $edit,$match,
                "Round",$plural=True,
                $tabindex="",$rdata=""
            );
    }
    //*
    //* 
    //*

    function Tournament_Match_Cell_Date($edit,$match,$team1,$team2)
    {
        return "Date";
    }
    //*
    //* 
    //*

    function Tournament_Match_Cell_Hour($edit,$match,$team1,$team2)
    {
        return "Hour";
    }
    
    //*
    //* 
    //*

    function Tournament_Match_Cell_Goals($edit,$match,$team1,$team2)
    {
        return
            array
            (
                $this->MyMod_Data_Field
                (
                    $edit,$match,
                    "Goal1",$plural=True,
                    $tabindex="",$rdata=""
                ),
                "-",
                $this->MyMod_Data_Field
                (
                    $edit,$match,
                    "Goal2",
                    $plural=True,
                    $tabindex="",$rdata=""
                )
            );
    }

    
    //*
    //* Team icons as a span.
    //*

    function Tournament_Match_Cell_Team_Icons($edit=0,$match=array(),$data="")
    {
        if (empty($match)) { return $this->TeamsObj()->MyMod_ItemsName(); }
        
        return
            array
            (
                $this->Tournament_Match_Cell_Team_Icon_1($edit=0,$match,"Teams1"),
                $this->BR(),
                $this->Tournament_Match_Cell_Team_Icon_2($edit=0,$match,"Teams1"),                
            );
    }
    
    //*
    //* Team icons as a span.
    //*

    function Tournament_Match_Cell_Team_Icon_1($edit=0,$match=array(),$data="")
    {
        if (empty($match)) { return $this->TeamsObj()->MyMod_ItemName()." #1"; }

        return
            $this->Htmls_Span
            (
                $this->TeamsObj()->Team_Icon
                (
                    $match[ "Team1"  ]
                ),
                array
                (
                    "ONCLICK" => $this->Tournament_Match_Cell_Team_Icon_ONCLICK
                    (
                        $match,"Team1"
                    ),
                )
            );
        
    }
    
    //*
    //* Team icons as a span.
    //*

    function Tournament_Match_Cell_Team_Icon_2($edit=0,$match=array(),$data="")
    {        
        if (empty($match)) { return $this->TeamsObj()->MyMod_ItemName()." #2"; }

        
        return
            $this->Htmls_Span
            (
                $this->TeamsObj()->Team_Icon
                (
                    $match[ "Team2"  ]
                ),
                array
                (
                    "ONCLICK" => $this->Tournament_Match_Cell_Team_Icon_ONCLICK
                    (
                        $match,"Team2"
                    ),
                )
            );
    }
    
    //*
    //* 
    //*

    function Tournament_Match_Cell_Team_Icon_ONCLICK($match,$data)
    {
        return
            array
            (
                "Table_Insert_Row_After",
                "(this,",
                $this->JS_Quote
                (
                    $this->Tournament_Match_Cell_Team_Icon_URL
                    (
                        $match,"Team1"
                    )
                ),
                ");",
            );
    }
    //*
    //* 
    //*

    function Tournament_Match_Cell_Team_Icon_URL($match,$data)
    {
        return
            "?".
            $this->CGI_Hash2URI
            (
                array
                (
                    //"Dest" => $dest,
                    "NoHorMenu" => 1,
                    "RAW" => 1,
                
                    "ModuleName" => "Teams",
                    "Action"     => "Edit",
                    "Team"       => $match[ $data ],
                )
            );
    }
    
    
    //*
    //* 
    //*

    function Tournament_Match_Cell_Stage($edit=0,$match=array(),$data="")
    {        
        if (empty($match)) { return $this->MyMod_Data_Title("Stage"); }

        $stage=
            $this->MyMod_Data_Fields_Show
            (
                "Stage",
                $match,
                $plural=False,
                    
                $iconify=False,$callmethod=False
            );

        if (!empty($match[ "Tournament_Group" ]))
        {
            array_push
            (
                $stage[1],
                preg_replace
                (
                    '/Group_?\s*/i',
                    "",
                    $this->Tournament_GroupsObj()->Sql_Select_Hash_Value
                    (
                        $match[ "Tournament_Group" ],
                        "Name"
                    )
                )
            );
        }
            

        return $stage;
    }
}

?>
