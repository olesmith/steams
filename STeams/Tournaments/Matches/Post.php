<?php

trait Tournament_Matches_Post
{    
    //*
    //* Postprocesses and returns $item.
    //*

    function PostProcess($item,$force=False)
    {
        if (!$force && $this->GetGET("ModuleName")!=$this->ModuleName)
        {
            return $item;
        }

        if (!isset($item[ "ID" ]) || $item[ "ID" ]==0) { return $item; }


        $updatedatas=array();
        if (!empty($item[ "Tournament_Round" ]))
        {
            foreach (array("Date","HHMM") as $data)
            {
                if (empty($item[ $data ]))
                {
                    $item[ $data ]=
                        $this->Tournament_RoundsObj()->Sql_Select_Hash_Value
                        (
                            $item[ "Tournament_Round" ],
                            $data
                        );
                    
                    array_push($updatedatas,$data);
                }
            }
        }

        if (isset($item[ "Name" ]))
        {
            $name=
                join
                (
                    " ",
                    array
                    (
                        $this->TeamsObj()->Sql_Select_Hash_Value
                        (
                            $item[ "Team1" ],"Name"
                        ),
                        " - ",
                        $this->TeamsObj()->Sql_Select_Hash_Value
                        (
                            $item[ "Team2" ],"Name"
                        ),
                    )
                );

            if ($item[ "Name" ]!=$name)
            {
                $item[ "Name" ]=$name;
                array_push($updatedatas,"Name");
            }
            
        }

        if ($this->Match_PostProcess_Status($item))
        {
            array_push($updatedatas,"Status");
        }

        //var_dump($item);

        $this->Match_PostProcess_Goals($item,$updatedatas);
        $this->Match_PostProcess_Points($item,$updatedatas);
        
        if (count($updatedatas)>0)
        {
            //var_dump($updatedatas);
            $this->Sql_Update_Item_Values_Set($updatedatas,$item);
        }

        return $item;
    }

    //*
    //* 
    //*

    function Match_PostProcess_Goals(&$match,&$updatedatas)
    {
        $keys=
            array
            (
                "Goals1","Goals2",
                "Goals1_Half","Goals2_Half",
                "Goals1_Extra","Goals2_Extra",
                "Goals1_Penalties","Goals2_Penalties",
                "Points1","Points2",
            );

        //print "POST Goals<BR>";
        if ($match[ "Status" ]<=1)
        {
            foreach ($keys as $key)
            {
                if (empty($match[ $key ]) || $match[ $key ]!="-")
                {
                    $match[ $key ]="-";
                    array_push($updatedatas,$key);
                }     
            }
        }
        else
        {
            foreach ($keys as $key)
            {
                if (empty($match[ $key ]) || $match[ $key ]=="-")
                {
                    $match[ $key ]=" 0";
                    array_push($updatedatas,$key);
                }    
            }            
        }

    }
    
    //*
    //* 
    //*

    function Match_PostProcess_Points(&$match,&$updatedatas)
    {
        if ($match[ "Status" ]<=1) { return; }
        
        $win=$this->Tournament("Points_Win");
        $draw=$this->Tournament("Points_Draw");

        $p1=$p2=" 0";
        if ($match[ "Goals1" ]>$match[ "Goals2" ])
        {
            $p1=$win;
        }
        elseif ($match[ "Goals1" ]==$match[ "Goals2" ])
        {
            $p1=$p2=$draw;
        }
        else
        {
            $p2=$win;
        }
        
        $data="Points1";
        if ($match[ $data ]!=$p1)
        {
            $match[ $data ]=$p1;
            array_push($updatedatas,$data);
        }
        
        $data="Points2";
        if ($match[ $data ]!=$p2)
        {
            $match[ $data ]=$p2;
            array_push($updatedatas,$data);
        }
    }
    
    //*
    //* 
    //*

    function Match_PostProcess_Status(&$match)
    {
        $status=1; //awaiting

        $date=$this->MyTime_2Sort();
        
        if ($date==$match[ "Date" ])
        {
            $time=$this->MyTime_Info();
            $time=
                sprintf("%02d",$time[ "Hour" ]).
                sprintf("%02d",$time[ "Min" ]).
                "";
            
            if ($time>=$match[ "HHMM" ])
            {
                $status=2; //active
                if ($time>$match[ "HHMM" ]+180)
                {
                    $status=3; //finished
                }
            }            
        }
        elseif ($date>$match[ "Date" ])
        {
            $status=3; //finished
        }

        if ($match[ "Status" ]!=$status)
        {
            $match[ "Status" ]=$status;

            return True;
        }

        return False;
    }
}

?>