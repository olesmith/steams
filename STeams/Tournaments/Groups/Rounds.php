<?php

trait Tournament_Groups_Rounds
{
    //*
    //*
    //*

    function Tournament_Group_Rounds_Handle($group=array())
    {
        if (empty($group)) { $group=$this->ItemHash; }
        
        $this->Htmls_Echo
        (
            $this->Tournament_Group_Rounds_Generate($group)
        );
    }
    
    //*
    //*
    //*

    function Tournament_Groups_Rounds_Generate($datagroup="Basic")
    {
        $html=
            array
            (
            );
        
        foreach ($this->TournamentsObj()->Tournament_Read_Groups() as $group)
        {
            array_push
            (
                $html,
                $this->GroupsObj()->Tournament_Group_Rounds_Generate
                (
                    $group,$datagroup
                )
            );
        }

        return $html;
    }
    
    //*
    //*
    //*

    function Tournament_Group_Rounds_Generate($group,$datagroup="Basic")
    {
        $this->Tournament_Group_Rounds_Read_Or_Create($group);

        /* $load_method= */
        /*     $this->Tournament_RoundsObj()->ItemDataGroups($datagroup,"Load_Method"); */
        
        return
            array
            (
                $this->Htmls_H
                (
                    1,
                    array
                    (
                        $this->Tournament_RoundsObj()->MyMod_ItemsName().",",
                        $this->MyMod_ItemName(),
                        $group[ "Name" ],
                    )
                ),
                $this->Tournament_RoundsObj()->MyMod_Items_Dynamic
                (
                    0,
                    $this->Tournament_Group_Rounds_Read_Post($group),
                    $datagroup
                ),
            );
    }

    //*
    //*
    //*

    function Tournament_Group_Rounds_Read_Or_Create($group)
    {
        $this->Tournament_RoundsObj()->Sql_Table_Structure_Update();
        $this->Tournament_RoundsObj()->ItemData();

        
        $nrounds_should=
            $this->Tournament_Group_Rounds_N_Should($group);
        
        $nrounds_sql=
            count
            (
                $this->Tournament_Group_Rounds_Read
                (
                    $group,array("ID")
                )
            );

        if ($nrounds_sql==0) { return; }

        $dates=
            $this->MyTime_Dates_From_To
            (
                $this->Tournament("StartDate"),
                $this->Tournament("EndDate")
            );

        $dates_per_round=floor(count($dates)/max(1,$nrounds_should));
        
        for
            (
                $round_no=$nrounds_sql+1;
                $round_no<=$nrounds_should;
                $round_no++
            )
        {
            $round_ndate=
                ($round_no-1)*$dates_per_round;
            
            $this->Tournament_Group_Round_Create
            (
                $group,$round_no,
                $dates[ $round_ndate ]
            );
            
            //var_dump("Create $round_no");
        }      
        return;
    }


    //*
    //*
    //*

    function Tournament_Group_Round_Create($group,$round_no,$round_date)
    {
        $where=
            array
            (
                "Tournament" => $this->Tournament("ID"),
                "Tournament_Group" => $group[ "ID" ],
                "Number" => $round_no,
            );
                
        $rounds=
            $this->Tournament_RoundsObj()->Sql_Select_NHashes
            (
                $where
            );

        if ($rounds==0)
        {
            $round=$where;

            $round[ "Date" ]=$round_date;
            $round[ "HHMM" ]=$this->Tournament("HHMM");
                    
            $this->Tournament_RoundsObj()->Sql_Insert_Item($round);
        }
    }

    //*
    //*
    //*

    function Tournament_Group_Rounds_Read_Post($group,$datas=array())
    {
        return
            $this->RoundsObj()->MyMod_Items_PostProcess
            (
                $this->Tournament_Group_Rounds_Read($group,$datas),
                True
            );
    }

    //*
    //*
    //*

    function Tournament_Group_Rounds_Read($group,$datas=array())
    {
        return
            $this->Tournament_RoundsObj()->Sql_Select_Hashes
            (
                $this->Tournament_Group_Rounds_Where($group),
                $datas
            );
    }


    //*
    //*
    //*

    function Tournament_Group_Rounds_N_Should($group)
    {
        $nteams=            
            count
            (
                $this->Tournament_Group_Teams_Read
                (
                    $group,
                    array("ID")
                )
            );

        if ($nteams==0) { return 0; }
        $nmatches_per_round=intval(ceil($nteams/2));
        
        $nmatches_total=$this->Tournament_Group_Matches_N_Should($group);

        $nrounds=$nmatches_total/$nmatches_per_round;
        
        $nrounds=intval(ceil($nrounds));
        return $nrounds;
    }




    //*
    //*
    //*

    function Tournament_Group_Rounds_Where($group)
    {
        return
            array
            (
                "Season" => $group[ "Season" ],
                "Tournament" => $group[ "Tournament" ],
                "Tournament_Group" => $group[ "ID" ],
            );
    }
}

?>