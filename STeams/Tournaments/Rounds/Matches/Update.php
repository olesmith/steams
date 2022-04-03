<?php

trait Tournaments_Rounds_Matches_Update
{
    //*
    //* 
    //*

    function Tournament_Round_Matches_Update($edit,$tournament,$round,$group_id,&$matches)
    {
        //var_dump($_POST);
        foreach (array_keys($matches) as $match_id)
        {
            $this->Tournament_Round_Match_Update
            (
                $edit,$tournament,$round,$group_id,$matches[ $match_id ]
            );
        }
    }
    
    //*
    //* 
    //*

    function Tournament_Round_Match_Update($edit,$tournament,$round,$group_id,&$match)
    {
        $updatedatas=array();

        foreach (array(1,2) as $t)
        {
            $team=
                $this->CGI_POSTint
                (
                    $this->Tournament_Round_Match_CGI_Name("Hour",$match,$t)
                );

            if ($team!=$match[ "Team".$t ])
            {
                $match[ "Team".$t ]=$team;
                array_push($updatedatas,"Team".$t);
            }
        }

        if
            (
                !empty($match[ "Team1" ])
                &&
                !empty($match[ "Team2" ])
                &&
                $match[ "Team1" ]!=$match[ "Team2" ]
            )
        {
            $date=
                $this->CGI_POST
                (
                    $this->Tournament_Round_Match_CGI_Name("Date",$match)
                );

            $comps=preg_split('/\//',$date);
            if ( count($comps)==3 )
            {
                $comps=preg_split('/\//',$date);
                $comps=array_reverse($comps);

                $date=join("",$comps);

                if ($match[ "Date" ]!=$date)
                {
                    $match[ "Date" ]=$date;
                    array_push($updatedatas,"Date");
                }
            }
        

            $hour=
                $this->CGI_POSTint
                (
                    $this->Tournament_Round_Match_CGI_Name("HHMM",$match)
                );
            
            if ($match[ "HHMM" ]!=$hour)
            {
                $match[ "HHMM" ]=$hour;
                array_push($updatedatas,"HHMM");
            }

            foreach (array(1,2) as $t)
            {
                $goals=
                    $this->CGI_POSTint
                    (
                        $this->Tournament_Round_Match_CGI_Name("Goals".$t,$match)
                    );

                if (empty($goals)) { $goals="0"; }
                if ($goals!=$match[ "Goals".$t ])
                {
                    $match[ "Goals".$t ]=$goals;
                    array_push($updatedatas,"Goals".$t);
                }
            }
        }
        else { $updatedatas=array(); }
        


        if (count($updatedatas)>0)
        {
            //var_dump($updatedatas);
            $this->Sql_Update_Item_Values_Set
            (
                $updatedatas,
                $match,
                $this->Tournament_MatchesObj()->Tournament_Sql_Table
                (
                    $this->Tournament_MatchesObj()->ModuleName,
                    $tournament
                )
            );
        }
    }
}

?>