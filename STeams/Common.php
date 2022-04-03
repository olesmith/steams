<?php

//This class is common to all App modules.


class Common extends ModulesCommon 
{
    //*
    //* Form table name of Tournament specific module.
    //*

    function Tournament_Sql_Table($module,$tournament=array())
    {
        $tournament_id=$this->Tournament("ID");
        if (!empty($tournament))
        {
            $tournament_id=$tournament[ "ID" ];
        }

        return
            join
            (
                "_",
                array
                (
                    $tournament_id,
                    $module
                )
            );        
    }
    
    //*
    //* Form table name of Tournament specific module.
    //*

    function Tournament_Pool_Sql_Table($module,$tournament=array(),$pool=array())
    {
        $tournament_id=$this->Tournament("ID");
        if (!empty($tournament))
        {
            $tournament_id=$tournament[ "ID" ];
        }
        
        $pool_id=$this->Pool("ID");
        if (!empty($pool))
        {
            $pool_id=$pool[ "ID" ];
        }

        return
            join
            (
                "_",
                array
                (
                    $tournament_id,
                    $pool_id,
                    $module
                )
            );        
    }
    
    //*
    //* Read Tournament from CGI, if necessary (cached).
    //*

    function Tournament($key="")
    {
        return $this->TournamentsObj()->Tournament($key);
    }
    
    
    //*
    //* Read Season from CGI, if necessary (cached).
    //*

    function Season($key="")
    {
        return $this->TournamentsObj()->Season($key);
    }
    
    //*
    //* Read or Create Tournament Groups.
    //*

    function Tournament_Groups_Get()
    {
        return $this->Tournament_GroupsObj()->Tournament_Groups_Get();
    }
    
    //*
    //* Read Tournament Teams.
    //*

    function Tournament_Teams_Get()
    {
        return $this->Tournament_TeamsObj()->Tournament_Teams_Get();
    }
    
    //*
    //* Read or Create Tournament Groups.
    //*

    function Tournament_Group_Teams_N()
    {
        return
            intval(ceil
            (
                $this->TournamentsObj()->Tournament("NTeams")
                /
                $this->TournamentsObj()->Tournament("NGroups")
            ));
    }

    function Team_Name($teamid,$key="Name")
    {
        return $this->TeamsObj()->Team_Name($teamid,$key);
    }
    
    function Match_Name($match,$key="Initials")
    {
        return $this->MatchesObj()->Match_Name($match,$key);
    }
    
    function Match_Result($match,$key="Goals")
    {
        return $this->MatchesObj()->Match_Result($match,$key);
    }

    
    //*
    //* Return group name.
    //*

    function Tournament_Group_Name($group_id,$key="Name")
    {
        return $this->GroupsObj()->Tournament_Group_Name($group_id,$key);
    }
    
    //*
    //*
    //*

    function SeasonsObj()
    {
        return $this->SeasonsObj();
    }
    
    //*
    //*
    //*

    function GroupsObj()
    {
        return $this->Tournament_GroupsObj();
    }
    
    
    //*
    //*
    //*

    function MatchesObj()
    {
        return $this->Tournament_MatchesObj();
    }
    
    //*
    //*
    //*

    function RoundsObj()
    {
        return $this->Tournament_RoundsObj();
    }
    
    //*
    //* Read Pool from CGI, if necessary (cached).
    //*

    function Pool($key="")
    {
        return $this->PoolsObj()->Pool($key);
    }
    
    //*
    //* Read Round from CGI, if necessary (cached).
    //*

    function Round($key="")
    {
        return $this->RoundsObj()->Round($key);
    }
    
    //*
    //*
    //*

    function Profile_Public_Is($profile="")
    {
        if (empty($profile)) { $profile=$this->Profile(); }
        
        $res=False;
        if (preg_match('/^Public$/',$profile))
        {
            $res=True;
        }

        return $res;
    }
    //*
    //*
    //*

    function Profile_Friend_Is($profile="")
    {
        if (empty($profile)) { $profile=$this->Profile(); }
        
        $res=False;
        if (preg_match('/^Friend$/',$profile))
        {
            $res=True;
        }

        return $res;
    }
    //*
    //*
    //*

    function Profile_Coordinator_Is($profile="")
    {
        if (empty($profile)) { $profile=$this->Profile(); }
        
        $res=False;
        if (preg_match('/^Coordinator$/',$profile))
        {
            $res=True;
        }

        return $res;
    }
    
    //*
    //*
    //*

    function Profile_Admin_Is($profile="")
    {
        if (empty($profile)) { $profile=$this->Profile(); }
        
        $res=False;
        if (preg_match('/^Admin/',$profile))
        {
            $res=True;
        }

        return $res;
    }
    
    //*
    //* Take Tournament and Season from $item. Start with $where.
    //*

    function Tournament_Season_Where($item=array(),$where=array())
    {
        $tournament_id=$this->Tournament("ID");
        if (!empty($item[ "Tournament" ]))
        {
            $tournament_id=$item[ "Tournament" ];
        }
        
        $season_id=$this->Season("ID");
        if (!empty($item[ "Season" ]))
        {
            $season_id=$item[ "Season" ];
        }
        
        return
            array_merge
            (
                $where,
                array
                (
                    "Tournament"  => $tournament_id,
                    "Season"      => $season_id,
                )
            );
    }
    
    //*
    //* 
    //*

    function Tournament_Season_Pool_Where($item,$where=array())
    {
        $where[ "Pool" ]=$item[ "Pool" ];
        
        return
            $this->Tournament_Season_Where($item,$where);
    }
    
    //*
    //* 
    //*

    function Pool_Bets_Match_Where($match,$where=array())
    {
        return
            array_merge
            (
                $where,
                $this->Tournament_Season_Where($match),
                array
                (
                    "Tournament_Match" => $match[ "ID" ]
                )
            );
    }

    
    //*
    //* 
    //*

    function Pool_Bets_Friend_Where($pool_friend,$where=array())
    {
        return
            array_merge
            (
                $where,
                $this->Tournament_Season_Where($pool_friend),
                array
                (
                    "Pool_Friend" => $pool_friend[ "ID" ],
                )
            );
    }
    
    //*
    //* 
    //*

    function Pool_Rankings_Where($pool=array())
    {
        if (empty($pool)) { $pool=$this->Pool(); }

        $pool_id=0;
        if (!empty($pool[ "Pool" ]))
        {
            $pool_id=$pool[ "Pool" ];
        }
        elseif (!empty($pool[ "ID" ]))
        {
            $pool_id=$pool[ "ID" ];
        }
        
        $where=
            $this->Tournament_Season_Where
            (
                array
                (
                    "Pool"             => $pool_id,
                ),
                array
                (
                    "Tournament_Round" => " 0",
                    "Month"            => " 0",
                )
            );

        $round=$this->CGI_GETint("Round");
        if (!empty($round))
        {
            $where[ "Tournament_Round" ]=$round;
        }

        $month=$this->CGI_GETint("Month");
        if (!empty($month))
        {
            $where[ "Month" ]=$month;
        }

        return $where;
    }
}

?>
