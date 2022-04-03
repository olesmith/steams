<?php

trait Tournaments_Rounds_Matches_Cell
{
    //*
    //* 
    //*

    function Tournament_Round_Match_CGI_Name($data,$match,$t=0)
    {
        $comps=array($data);
        if ($t>0) { array_push($comps,$t); }
        array_push($comps,"Match",$match[ "ID" ]);

        return join("_",$comps);
    }
            
    //*
    //* 
    //*

    function Tournament_Round_Match_Cell($edit,$t,$tournament,$round,$group_id,$match)
    {
        $namer="Name_".$this->MyLanguage_Get();
        $titler="Title_".$this->MyLanguage_Get();
        
        $names=array("");
        $titles=array("");
        $values=array(0);
        $disableds=array(0);

        foreach ($this->__Teams_Group__ as $team)
        {
            array_push($names,$team[ $namer ]);
            array_push($titles,$team[ $titler ]);
            array_push($values,$team[ "ID" ]);

            array_push
            (
                $disableds,
                $this->Tournament_Round_Match_Cell_Disabled
                (
                    $match,$t,$team
                )
            );
        }
        
        return
            $this->Htmls_Select
            (
                $this->Tournament_Round_Match_CGI_Name("Hour",$match,$t),
                $values,
                $names,
                $selected=$match[ "Team".$t ],
                //$args=
                array
                (
                    "Titles" => $titles,
                    "Disableds" => $disableds,
                ),
                array
                (
                    "TABINDEX" => 1,
                )
            );
    }
    
    //*
    //* 
    //*

    function Tournament_Round_Match_Cell_Disabled($match,$t,$team)
    {
        $disabled=False;
        if
            (
                !empty
                (
                    $this->__Teams_Group__
                    [ $team[ "ID" ] ][ "Disabled" ]
                )
            )
        {
            if ($team[ "ID" ]!=$match[ "Team".$t ])
            {
                $disabled=True;
            }
        }

        return $disabled;
    }
}

?>