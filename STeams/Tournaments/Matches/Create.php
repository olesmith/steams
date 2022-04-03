<?php

trait Tournament_Matches_Create
{
    //*
    //* 
    //*

    function Tournament_Matches_Create($tournament,$groups,$teams)
    {
        $nmatches_should=
            $this->Tournament_GroupsObj()->Tournament_Groups_Matches_N
            (
                $tournament
            );
        
        $nmatches_sql=
            $this->Sql_Select_NHashes
            (
                array("Tournament" => $tournament[ "ID" ])
            );


        if ($nmatches_sql<$nmatches_should)
        {
            $this->Tournament_Groups_Matches_Create($tournament);
        }     
        
    }

    //*
    //* 
    //*

    function Tournament_Groups_Matches_Create($tournament)
    {
        foreach (array_keys($tournament[ "Groups" ]) as $group_id)
        {
            $this->Tournament_Group_Matches_Create
            (
                $tournament,$group_id
            );
        }
        
    }
    
    //*
    //* 
    //*

    function Tournament_Group_Matches_Create($tournament,$group_id)
    {
        $teams=$tournament[ "Groups" ][ $group_id ];

        $nmatches_should=2;
        if ($tournament[ "HomeAndAway" ]==2) { $nmatches_should=1; }

        for ($n=0;$n<count($teams);$n++)
        {
            for ($m=$n+1;$m<count($teams);$m++)
            {
                $matches=
                    $this->Sql_Select_Hashes
                    (
                        $this->Tournament_Group_Matches_Where
                        (
                            $tournament,
                            $teams[$n],$teams[$m]
                        ),
                        array("ID")
                    );

                $rmatches=
                    array
                    (
                        array($teams[$n],$teams[$m]),
                    );

                if ($tournament[ "HomeAndAway" ]==1)
                {
                    array_push
                    (
                        $rmatches,
                        array($teams[$m],$teams[$n])
                    );                    
                }

                if (count($matches)<count($rmatches))
                {
                    foreach ($rmatches as $rmatch)
                    {
                        $where=
                            array
                            (
                                "Tournament" => $tournament[ "ID" ],
                                "Team1" => $rmatch[0],
                                "Team2" => $rmatch[1],
                            );
                        
                        $match=
                            $this->Sql_Select_Hash
                            (
                                $where,
                                array("ID")
                            );

                        if (empty($match))
                        {
                            $where[ "Tournament_Group" ]=$group_id;
                            $this->Sql_Insert_Item($where);
                            //var_dump("INS",$where);
                        }
                    }
                }
            }
        }

    }
    //*
    //* 
    //*

    function Tournament_Group_Matches_Where($tournament,$team1,$team2)
    {
        return
            array
            (
                "Tournament" => $tournament[ "ID" ],
                "Team1" => array($team1,$team2),
                "Team2" => array($team1,$team2),
            );
    }
    
}

?>