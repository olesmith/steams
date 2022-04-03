<?php

trait MyTime
{
    //*
    //* Returns host name of IP address. Should be moved to somewhere sensible...
    //*

    function Host_IP2Address($host)
    {
        return gethostbyaddr($host);
    }

    
    
    //*
    //* 
    //*

    function MyTime_Current_Semester($mtime="")
    {
        $semester=1;
        if ($this->CurrentMonth($mtime)>7)
        {
            $semester=1;
        }

        return $semester;
    }
    
    //*
    //* Returns languaged $weekday name.
    //*

    function MyTime_Curent_Date_Comps()
    {
        return
            join
            (
                ".",
                array
                (
                    $this->CurrentYear(),
                    sprintf("%02d",$this->CurrentMonth()),
                    sprintf("%02d",$this->CurrentDate())
                )
            );
    }
    
    //*
    //* Returns languaged $weekday name.
    //*

    function MyTime_WeekDay($weekday)
    {
        $msgs=$this->MyTime_WeekDays("WeekDays");

        $msg="WARNING! WeekDay weekday '$weekday' not found #1!";
        if ($weekday==0) { $weekday=7; }
        if (isset($msgs[ $weekday-1 ]))
        {
            $msg=$msgs[ $weekday-1 ];
        }
        
        return $msg;
    }

    //*
    //* Returns languaged $weekday name.
    //*

    function MyTime_WeekDays()
    {
        return $this->MyLanguage_GetMessages("WeekDays");
    }
    //*
    //* Returns languaged $month name.
    //*

    function MyTime_Month($month,$key="Name")
    {
        if (is_bool($key))
        {
            if ($key) { $key="Title"; }
            else      { $key="Name"; }
        }
        
        $msgs=$this->MyTime_Months($key);

        $msg="WARNING! Month $month not found!";
        if (isset($msgs[ $month-1 ]))
        {
            $msg=$msgs[ $month-1 ];
        }
        
        return $msg;
    }
    //*
    //* Returns languaged $weekday name.
    //*

    function MyTime_Months($key="Name")
    {
        return $this->MyLanguage_GetMessages("Months",$key);
    }

    //*
    //* Returns $mtime date: DD/MM/YYYY.
    //*

    function MyTime_Date($mtime="")
    {
        $timeinfo=$this->MyTime_Info($mtime);
        return join("/",array($timeinfo[ "MDay" ],$timeinfo[ "Month" ],$timeinfo[ "Year" ]));
            
    }
    
    //*
    //* Returns $mtime time: HH:MM
    //*

    function MyTime_Time($mtime="")
    {
        $timeinfo=$this->MyTime_Info($mtime);
        return join(":",array($timeinfo[ "Hour" ],$timeinfo[ "Min" ]));
            
    }
    
     //*
    //* Tranlate $timeinfo (hash) 'back' to mtime value.
    //*

    function MyTime_Info_2_MTime($timeinfo)
    {
        return
            mktime
            (
                sprintf("%02d",$timeinfo[ "Hour" ]),
                sprintf("%02d",$timeinfo[ "Min" ]),
                sprintf("%02d",$timeinfo[ "Sec" ]),
                
                sprintf("%02d",$timeinfo[ "Month" ]),
                sprintf("%02d",$timeinfo[ "MDay" ]),
                sprintf("%02d",$timeinfo[ "Year" ])
            );
    }
    
    //*
    //* Reads file info.
    //*

    function MyTime_Info($mtime="",$weekday=True)
    {
        if ($mtime=="") { $mtime=time(); }
        if ($mtime==0) { return ""; }

        $mtime=intval($mtime);
        $rtimeinfo=localtime($mtime,TRUE);

        $timeinfo[ "Year" ]=$rtimeinfo[ "tm_year" ]+1900;
        $timeinfo[ "Month" ]=sprintf("%02d",$rtimeinfo[ "tm_mon" ]+1);
        $timeinfo[ "MDay" ]=sprintf("%02d",$rtimeinfo[ "tm_mday" ]);

        $timeinfo[ "WDay" ]=$rtimeinfo[ "tm_wday" ];

        if ($weekday)
        {
            $timeinfo[ "WeekDay" ]=
                $this->ApplicationObj()->MyTime_WeekDay($rtimeinfo[ "tm_wday" ]);
        }
        
        $timeinfo[ "Hour" ]=sprintf("%02d",$rtimeinfo[ "tm_hour" ]);
        $timeinfo[ "Min" ]=sprintf("%02d",$rtimeinfo[ "tm_min" ]);
        $timeinfo[ "Sec" ]=sprintf("%02d",$rtimeinfo[ "tm_sec" ]);
        $timeinfo[ "t" ]=$mtime;

        return $timeinfo;
    }

     //*
    //* Format $mtime.
    //*

    function TimeStamp2Hour($mtime="",$glue=".")
    {
        $timeinfo=$this->MyTime_Info($mtime,False);

        if (empty($timeinfo)) { return "--"; }

        return
            join
            (
               $glue,
               array
               (
                  $timeinfo[ "Hour" ],
                  $timeinfo[ "Min" ]//,
                  //$timeinfo[ "Sec" ]
               )
            );
    }

    
    //*
    //* Format $mtime.
    //*

    function TimeStamps($mtimes,$sep1="-",$sep2=".")
    {
        $times=array();
        foreach ($mtimes as $mtime)
        {
            array_push
            (
                $times,
                $this->TimeStamp($mtime,$sep1,$sep2)
            );
        }

        return $times;
    }
    
    //*
    //* Format $mtime.
    //*

    function TimeStamp($mtime="",$sep1="-",$sep2=".")
    {
        $timeinfo=$this->MyTime_Info($mtime,False);

        return
            join
            (
               $sep2,
               array
               (
                  $timeinfo[ "MDay" ],
                  $timeinfo[ "Month" ],
                  $timeinfo[ "Year" ]
               )
            ).
            $sep1.
            join
            (
               $sep2,
               array
               (
                  $timeinfo[ "Hour" ],
                  $timeinfo[ "Min" ]
               )
            );
        
    }
    //*
    //* Format $mtime.
    //*

    function MyTime_HHMM($mtime="",$sep="")
    {
        $timeinfo=$this->MyTime_Info($mtime);

        return
            join
            (
               $sep,
               array
               (
                  $timeinfo[ "Hour" ],
                  $timeinfo[ "Min" ],
               )
            );
    }
    
    //*
    //* Format $mtime.
    //*

    function MyTime_MTime($hash)
    {
        return
            mktime
            (
                $hour   = $hash[ "Hour" ],
                $minute = $hash[ "Minute" ],
                $second = 0,
                $month  = $hash[ "Month" ],
                $day    = $hash[ "Day" ],
                $year   = $hash[ "Year" ]
            );
    }
    //*
    //* Format $mtime.
    //*

    function MyTime_HHMMSS($mtime="",$sep=":")
    {
        $timeinfo=$this->MyTime_Info($mtime);

        return
            join
            (
               $sep,
               array
               (
                  $timeinfo[ "Hour" ],
                  $timeinfo[ "Min" ],
                  $timeinfo[ "Sec" ]
               )
            );
    }
    
    //*
    //* Format $mtime.
    //*

    function TimeStamp2Text($mtime="",$sep=", ",$weekday=True)
    {
        $timeinfo=$this->MyTime_Info($mtime,$weekday);

        if (empty($timeinfo)) { return "--"; }

        $text="";
        if ($weekday)
        {
            $text.=$timeinfo[ "WeekDay" ].$sep;
        }

        return
            $text.
            join
            (
               "/",
               array
               (
                  $timeinfo[ "MDay" ],
                  $timeinfo[ "Month" ],
                  $timeinfo[ "Year" ]
               )
            ).
            $sep.
            join
            (
               ":",
               array
               (
                  $timeinfo[ "Hour" ],
                  $timeinfo[ "Min" ],
                  $timeinfo[ "Sec" ]
               )
            );
    }

    //*
    //* function MyTime_FileName, Parameter list: $mtime="",$sep=" "
    //*
    //* Format $mtime for a file name..
    //*

    function MyTime_FileName($mtime="",$sep="-",$datesep=".",$timesep=".")
    {
        $timeinfo=$this->MyTime_Info($mtime);

        return
            join
            (
               $datesep,
               array
               (
                  $timeinfo[ "MDay" ],
                  $timeinfo[ "Month" ],
                  $timeinfo[ "Year" ]
               )
            ).
            $sep.
            join
            (
               $timesep,
               array
               (
                  $timeinfo[ "Hour" ],
                  $timeinfo[ "Min" ]//,
                  //$timeinfo[ "Sec" ]
               )
            );
    }

    //* function MyTime_2Sort, Parameter list: $mtime="
    //*
    //* Returns date of $mtime's date key: YYYYMMDD.
    //* Current $mtime, if empty.
    //*

    function MyTime_2Sort($mtime="")
    {
      if ($mtime=="") { $mtime=time(); }
      $mtime=intval($mtime);
      $timeinfo=localtime($mtime,TRUE);

      return 
          ($timeinfo[ "tm_year" ]+1900).
          sprintf("%02d",$timeinfo[ "tm_mon" ]+1).          
          sprintf("%02d",$timeinfo[ "tm_mday" ]);
    }
    
    //* function MyTime_Sort2Date, Parameter list: $date=0
    //*
    //* Returns formatted date of $mtime, today if empty.
    //*

    function MyTime_Date2Hash($date=0)
    {
        if (empty($date)) { $date=$this->MyTime_2Sort(); }

        return
            array
            (
                "Year"  => substr($date,0,4),
                "Month" => substr($date,4,2),
                "Day"   => substr($date,6,2),
            );
    }

    //* function MyTime_Sort2Date, Parameter list: $date=0
    //*
    //* Returns formatted date of $mtime, today if empty.
    //*

    function MyTime_Sort2Date($date=0)
    {
        if (empty($date)) { $date=$this->MyTime_2Sort(); }

        $date=$this->MyTime_Date2Hash($date);
        
        return 
            $date[ "Day" ]."/".
            $date[ "Month" ]."/".
            $date[ "Year" ];
    }

    
    function MyTime_Date2Sort($date)
    {
        $comps=preg_split('/\//',$date);
        $formats=array("%02d","%02d","%d");

        $text="";
        for ($n=0;$n<count($formats);$n++)
        {
            $val=0;
            if (isset($comps[ $n ]))
            {
                $val=$comps[ $n ];
            }

            $val=sprintf($formats[$n],$val);
            $text=$val.$text;
        }

        return $text;
    }
    
    function MyTime_2Hash($mtime="")
    {
        if (empty($mtime)) { $mtime=time(); }

        $mtime=intval($mtime);
        $timeinfo=localtime($mtime,TRUE);

        $timeinfo[ "Year" ]=$timeinfo[ "tm_year" ]+1900;
        $timeinfo[ "Month" ]=sprintf("%02d",$timeinfo[ "tm_mon" ]+1);
        $timeinfo[ "MDay" ]=sprintf("%02d",$timeinfo[ "tm_mday" ]);

        $wday=$timeinfo[ "tm_wday" ];
        if ($wday==0) { $wday=6; }
        else          { $wday--; }

        $timeinfo[ "WeekDay" ]=$this->MyTime_WeekDay($wday);

        $timeinfo[ "Hour" ]=sprintf("%02d",$timeinfo[ "tm_hour" ]);
        $timeinfo[ "Min" ]=sprintf("%02d",$timeinfo[ "tm_min" ]);
        $timeinfo[ "Sec" ]=sprintf("%02d",$timeinfo[ "tm_sec" ]);

        return $timeinfo;
    }
    
    //*
    //* function MyTime_Month_MTime_First, Parameter list: $month
    //*
    //* Converts a $year/$month to first time.
    //*

    function MyTime_Month_MTime_First($month)
    {
        if (preg_match('/^(\d\d\d\d)(\d\d)/',$month,$matches) && count($matches)>=2)
        {
            $year=$matches[1];
            $month=$matches[2];
            $month=sprintf("01/%02d/%d 00:00:00",$month,$year);
        }
        
        $dateobj = DateTime::createFromFormat("d/m/Y H:i:s",$month);
        return $dateobj->format("U");
    }
    
    //*
    //* function MyTime_Month_MTime_Last, Parameter list: $month
    //*
    //* Converts a $year/$month to last time.
    //*

    function MyTime_Month_MTime_Last($month)
    {
        if (preg_match('/^(\d\d\d\d)(\d\d)/',$month,$matches) && count($matches)>=2)
        {
            $year=$matches[1];
            $month=$matches[2];
            
            if ($month<12) { $month++; }
            else           { $month=1; $year++; }

            $month=sprintf("%d%02d",$year,$month);
        }

        return $this->MyTime_Month_MTime_First($month)-1;
        
    }
    
    //*
    //* function MyTime_Date_MTime_First, Parameter list: $date
    //*
    //* Converts a $year/$month/$date to first time.
    //*

    function MyTime_Date_MTime_First($date)
    {
        if (preg_match('/^(\d\d\d\d)(\d\d)(\d\d)/',$date,$matches) && count($matches)>=3)
        {
            $year=$matches[1];
            $month=$matches[2];
            $mday=$matches[3];

            $date=sprintf("%02d/%02d/%d 00:00:00",$mday,$month,$year);

            $dateobj = DateTime::createFromFormat("d/m/Y H:i:s",$date);
            return $dateobj->format("U");
        }

        return 0;
    }
    
    //*
    //* function MyTime_Date_End2MTime, Parameter list: $date
    //*
    //* Converts a $year/$month/$date to first time.
    //*

    function MyTime_Date_MTime_Last($date)
    {
        return $this->MyTime_Date_MTime_First($date)+60*60*24-1;
    }
    
    //*
    //* function MyTime_Dates_From_To, Parameter list: $startdate,$enddate
    //*
    //* Returns list of dates between $startdate and $enddate.
    //*

    function MyTime_Dates_From_To($startdate,$enddate)
    {
        if ($startdate>$enddate)
        {
            $tmp=$startdate;
            $startdate=$enddate;
            $enddate=$tmp;
        }
        $dates=array();
        
        $date=$startdate;
        while ($date<=$enddate)
        {
            array_push($dates,$date);
            $date=$this->GetNextDate($date);
        }

        return $dates;
    }
    
    //*
    //* Trims a date string.
    //*

    function MyTime_Date_Trim($value)
    {
        $rval=$value;
        if (preg_match('/\//',$rval) && preg_match('/\d\d?/',$rval,$matches))
        {
            $date=$matches[0];
            $rval=preg_replace('/\d\d?/',"",$rval,1);

            $mon=0;
            if (preg_match('/\d\d?/',$rval,$matches))
            {
                $mon=$matches[0];
                $rval=preg_replace('/\d\d?/',"",$rval,1);
            }

            $year=0;
            if (preg_match('/\d+/',$rval,$matches))
            {
                $year=$matches[0];

                if ($year<=($this->CurrentYear()-2000)) { $year+=2000; }
                elseif ($year<100) { $year+=1900; }
            }

            $value=sprintf("%04d%02d%02d",$year,$mon,$date);
        }

        return $value;
    }
    
    //*
    //* Trims a date string.
    //*

    function MyTime_Time_Lapse_Text($secs,$start=0)
    {
        $secs-=$start;
        
        $ndays=0;
        $texts=array();
        $n=60*60*24;
        if ($secs>=$n)
        {
            $ndays=floor($secs/$n);
            array_push($texts,$ndays,"days,");

            $secs-=$ndays*$n;
        }
        
        $n=60*60;
        if ($secs>=$n)
        {
            $nhours=floor($secs/$n);
            array_push($texts,$nhours,"hours,");

            $secs-=$ndays*$n;
        }
        
        $n=60;
        if ($secs>=$n)
        {
            $minutes=floor($secs/$n);
            array_push($texts,$minutes,"mins,");

            $secs-=$minutes*$n;
        }
        
        array_push($texts,$secs,"secs");

        return join(" ",$texts);;
    }

}

?>