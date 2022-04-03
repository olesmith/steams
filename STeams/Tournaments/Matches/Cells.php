<?php

trait Tournament_Matches_Cells
{
    //*
    //* Team icons as a span.
    //*

    function Tournament_Match_Cell_Teams_Icons($edit=0,$match=array(),$data="Icon",$with_minus=True)
    {
        if (empty($match)) { return ""; }

        $namer="Name_".$this->MyLanguage_Get();
        $data="Icon";
        
        $minus=" ";
        if ($with_minus) { $minus="-"; }

        return
            $this->Htmls_Span
            (
                array
                (
                    $this->TeamsObj()->MyMod_Data_Fields_File_Decorator_Download_IMG
                    (
                        $team1=$this->TeamsObj()->Sql_Select_Hash
                        (
                            array("ID" => $match[ "Team1" ]),
                            array($data,$namer)
                        ),
                        $data
                    ),
                    
                    $minus,
                    
                    $this->TeamsObj()->MyMod_Data_Fields_File_Decorator_Download_IMG
                    (
                        $team2=$this->TeamsObj()->Sql_Select_Hash
                        (
                            array("ID" => $match[ "Team2" ]),
                            array($data,$namer)
                        ),
                        $data
                    ),
                ),
                
                array
                (
                    "TITLE" =>
                    $team1[ $namer ].
                    $minus.
                    $team2[ $namer ],
                )
            );
    }

    //*
    //* Cell icons as an array.
    //*

    function Tournament_Match_Cells_Teams_Icons($match=array())
    {
        if (empty($match)) { return array("*","*","*"); }

        $namer="Name_".$this->MyLanguage_Get();

        $data="Icon";

        return
            array
            (
                $this->TeamsObj()->MyMod_Data_Fields_File_Decorator_Download_IMG
                (
                    $team1=$this->TeamsObj()->Sql_Select_Hash
                    (
                        array("ID" => $match[ "Team1" ]),
                        array($data,$namer)
                    ),
                    $data
                ),
                "-",
                $this->TeamsObj()->MyMod_Data_Fields_File_Decorator_Download_IMG
                (
                    $team2=$this->TeamsObj()->Sql_Select_Hash
                    (
                        array("ID" => $match[ "Team2" ]),
                        array($data,$namer)
                    ),
                    $data
                ),
            );
    }
    
    //*
    //*
    //*

    function Match_Cell_Points($edit=0,$match=array(),$data="")
    { 
        if (empty($match))
        {
            return $this->MyLanguage_GetMessage("Points");
        }

        $points=array();
        if ($match[ "Points1" ]>0 || $match[ "Points2" ]>0)
        {
            $pt1=$match[ "Points1" ];
            $pt2=$match[ "Points2" ];
            if ($pt1=="") { $pt1=0; }
            if ($pt2=="") { $pt2=0; }
            
            $points=
                array($pt1."-".$pt2);
        }

        return $points;        
    }
    
    //*
    //*
    //*

    function Match_Cell_Score($edit=0,$match=array(),$data="")
    {
        if (empty($match))
        {
            return $this->MyLanguage_GetMessage("Score");
        }
        
        return
            join
            (
                " ",
                array
                (
                    join
                    (
                        "-",
                        $this->Match_Cells_Goals($match)
                    ),
                    "(".
                    join
                    (
                        "-",
                        $this->Match_Cells_Goals($match,"_Half")
                    ),
                    ")",
                )
            );
    }

    //*
    //*
    //*

    function Tournament_Match_Cells_Score($match)
    {
        $goals=
            $this->Match_Cells_Goals
            (
                $match
            );

        return array($goals[0],"-",$goals[1]);            
    }
    
    //*
    //*
    //*

    function Match_Cells_Goals($match,$post="")
    {
        $goals=array();
        for ($n=1;$n<=2;$n++)
        {
            $goal=$match[ "Goals".$n.$post ];
            if ($match[ "Status" ]>1 && $goal=='-')
            {
                $goal=" 0";
            }
            
            array_push($goals,$goal);
        }
        
        return $goals;
    }
    
}

?>
