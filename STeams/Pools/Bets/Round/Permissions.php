<?php

trait Pool_Bets_Round_Permissions
{
    //*
    //* 
    //*

    function Pool_Bet_Permissions($bet,$match=array())
    {
        if (empty($match))
        {
            $match_id=$bet[ "Tournament_Match" ];
            if (empty($this->__Pool_Bet_Matches__[ $match_id ]))
            {
                $this->__Pool_Bet_Matches__[ $match_id ]=
                    $this->MatchesObj()->Sql_Select_Hash
                    (
                        array("ID" => $match_id)
                    );

                $match=$this->__Pool_Bet_Matches__[ $match_id ];
            }
        }

        if (empty($match)) { return 0; }

        $permitted=$this->Pool("Show_Others_Minutes");
        $perms=0;
        if ($this->Profile_Public_Is())
        {
            $perms=0;
        }
        elseif ($this->Profile_Friend_Is())
        {
            $perms=1;
            if ($bet[ "Friend" ]==$this->LoginData("ID"))
            {
                $perms=2;
            }
            else
            {
                $permitted=0;
            }
        }
        elseif ($this->Profile_Coordinator_Is())
        {
            $perms=1;
        }
        elseif ($this->Profile_Admin_Is())
        {
            return 2;
        }

        $match_mtime=
            $this->MyTime_MTime
            (
                array
                (
                    "Year"   => substr($match[ "Date" ],0,4),
                    "Month"  => substr($match[ "Date" ],4,2),
                    "Day"    => substr($match[ "Date" ],6,2),
                    "Hour"   => substr($match[ "HHMM" ],0,2),
                    "Minute" => substr($match[ "HHMM" ],2,2),
                )
            );

        $mtime=time();
        //var_dump($mtime."-".$match_mtime."=".($mtime-$match_mtime));

        //var_dump("---",$perms);
        if ($perms>=1)
        {
            $hour=
                $this->MyTime_2Sort().
                $this->MyTime_HHMM().
                "";

            $match_hour=
                10000*$match[ "Date" ]
                +
                $match[ "HHMM" ];

            $dhour=$hour-$permitted-$match_hour;
            $dmtime=
                $mtime-$match_mtime-$permitted*60;

            //var_dump($dhour,$match_hour);
            //var_dump("hour=$hour, permiited=$permitted, match_h=$match_hour: $dhour");


            
            if ($bet[ "Friend" ]==$this->LoginData("ID"))
            {
                if ($dmtime>0)
                {
                    $perms--;
                }
            }
            else
            {
                if ($dmtime<0)
                {
                    $perms--;
                }
            }
        }
        
        //var_dump($perms,"---");
        return $perms;
    }
  
}

?>