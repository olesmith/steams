<?php

trait Tournament_Groups_Teams
{
    //*
    //*
    //*

    function Tournament_Group_Teams_Handle($group=array())
    {
        if (empty($group)) { $group=$this->ItemHash; }

        $this->Htmls_Echo
        (
            $this->Tournament_Group_Teams_Generate($group)
        );
    }
    
    //*
    //*
    //*

    function Tournament_Groups_Teams_Generate()
    {
        $html=
            array
            (
                $this->Htmls_H
                (
                    1,
                    $this->TournamentsObj()->MyMod_ItemName().": ".
                    $this->Tournament("Name")
                ),
                $this->Htmls_H
                (
                    1,
                    $this->Tournament_SeasonsObj()->MyMod_ItemName().": ".
                    $this->Season("Name")
                ),
            );
        
        foreach ($this->TournamentsObj()->Tournament_Read_Groups() as $group)
        {
            array_push
            (
                $html,
                $this->GroupsObj()->Tournament_Group_Teams_Generate($group)
            );

            foreach
                (
                   $this->Tournament_TeamsObj()->Sql_Select_Hashes
                   (
                       array
                       (
                           "Tournament" => $group[ "Tournament" ],
                           "Season"     => $group[ "Season" ],
                           "__NULL_" => "Tournament_Group IS NULL",
                       ),
                       array("ID")
                   )
                   as $team
                )
            {
                $this->Tournament_TeamsObj()->Sql_Update_Item_Value_Set
                (
                    $team[ "ID" ],
                    "Tournament_Group",
                    $group[ "ID" ]
                );
            }
        }

        return $html;
    }

    
    //*
    //*
    //*

    function Tournament_Group_Teams_Generate($group)
    {

        $this->Tournament_Group_Teams_Read_Or_Create($group);

        return
            array
            (
                $this->Htmls_H
                (
                    1,
                    array
                    (
                        $this->TeamsObj()->MyMod_ItemsName().", ",
                        $this->MyMod_ItemName(),
                        $group[ "Name" ]
                    )
                ),
                $this->Tournament_TeamsObj()->MyMod_Items_Dynamic
                (
                    0,
                    $this->Tournament_Group_Teams_Read_Post($group)
                ),
            );
    }

   
    
    //*
    //*
    //*

    function Tournament_Group_Teams_Read_Post($group,$datas=array())
    {
        return
            $this->Tournament_Teams_Rank
            (
                $this->Tournament_TeamsObj()->MyMod_Items_PostProcess
                (
                    $this->Tournament_Group_Teams_Read($group,$datas),
                    True
                )
            );
    }
    
    //*
    //*
    //*

    function Tournament_Teams_Rank($teams)
    {
        $sort_keys=
            array
            (
                "Points_Total",
                "Goals_Total",
                "Goals_Favor",
            );

        $rteams=array();
        foreach ($teams as $team)
        {
            $sorts=array();
            foreach ($sort_keys as $sort_key)
            {
                $value=$team[ $sort_key ];
                $value=100000-$value;
                if ($value<0)
                {
                    //$value=100000-$value;
                }
                
                array_push
                (
                    $sorts,
                    sprintf("%06d",$value)
                );
            }

            $sort=join("",$sorts);
            if (empty($rteams[ $sort ]))
            {
                $rteams[ $sort ]=array();
            }

            array_push($rteams[ $sort ],$team);
        }

        $sorts=array_keys($rteams);
        sort($sorts);
        //$sorts=array_reverse($sorts);
        
        $ranking=1;

        $teams=array();
        foreach ($sorts as $sort)
        {
            $rranking=$ranking;

            foreach ($rteams[ $sort ] as $team)
            {
                array_push($teams,$team);
            }
        }

        return $teams;
    }
    
    //*
    //*
    //*

    function Tournament_Group_Teams_Read($group,$datas=array())
    {
        return
            array_reverse
            (
                $this->Tournament_TeamsObj()->Sql_Select_Hashes
                (
                    $this->Tournament_Group_Teams_Where($group),
                    $datas,
                    "Points_Total,Goals_Total,ID"
                )
            );
    }
    
    //*
    //*
    //*

    function Tournament_Group_Teams_Read_Or_Create($group)
    {
        $this->Tournament_TeamsObj()->Sql_Table_Structure_Update();
        $this->Tournament_TeamsObj()->ItemData();

        $group_nteams_sql=
            count
            (
                $this->Tournament_Group_Teams_Read
                (
                    $group,
                    array("ID")
                )
            );

        for
            (
                $team_no=$group_nteams_sql+1;
                $team_no<=$this->Tournament_Group_Teams_N();
                $team_no++
            )
        {
            $this->Tournament_TeamsObj()->Tournament_Team_Create
            (
                $group,
                $team_no
            );
        }      
    }

    //*
    //*
    //*

    function Tournament_Group_Teams_Where($group)
    {
        return
            array
            (
                "Tournament"       => $this->Tournament("ID"),
                "Season"           => $this->Season("ID"),
                "Tournament_Group" => $group[ "ID" ],
            );
    }
}

?>