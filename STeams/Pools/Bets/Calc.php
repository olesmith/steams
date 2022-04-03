<?php


trait Pool_Bets_Calc
{
    //*
    //* 
    //*

    function Pool_Bet_Calc(&$bet,&$updatedatas,$match=array())
    {
        if
            (
                $bet[ "Goals1" ]=="-"
                ||
                $bet[ "Goals2" ]=="-"
            )
        {
            $this->Pool_Bet_Reset($bet,$updatedatas);

            return;
        }

        if (empty($match))
        {
            $match=
                //Caches match reading
                $this->Pool_Bet_Match
                (
                    $bet,
                    array("ID","Goals1","Goals2","Status","MTime")
                );
        }

        
        $update=False;
        if
            (
                $match[ "MTime" ]>$bet[ "LastCalc" ]
                ||
                $bet[ "MTime" ]>$bet[ "LastCalc" ]
            )
        {
            $update=True;
        }

        if (!$update) { return; }

        //var_dump($update,$bet[ "LastCalc" ]);

        if ($match[ "Status" ]!=3)
        {
            $this->Pool_Bet_Reset($bet,$updatedatas);

            return;
        }
        
        $match_result=0; //draw
        if ($match[ "Goals1" ]>$match[ "Goals2" ])
        {
            $match_result=1;
        }
        elseif ($match[ "Goals1" ]<$match[ "Goals2" ])
        {
            $match_result=2;
        }
        
        $bet_result=0; //draw
        if ($bet[ "Goals1" ]>$bet[ "Goals2" ])
        {
            $bet_result=1;
        }
        elseif ($bet[ "Goals1" ]<$bet[ "Goals2" ])
        {
            $bet_result=2;
        }

        $first=False;
        if ($bet[ "Goals1" ]==$match[ "Goals1" ])
        {
            $first=True;
        }
        
        $second=False;
        if ($bet[ "Goals2" ]==$match[ "Goals2" ])
        {
            $second=True;
        }

        $points=0;
        $goals=1;
        $goal=1;
        $result=1;
        if ($first && $second)
        {
            $goals=2;
            $points+=$this->Pool("Weight_Goals");
        }
        else
        {
            if ($bet_result==$match_result)
            {
                $result=2;
                $points+=$this->Pool("Weight_Result");
            }

            if ($first || $second)
            {
                $goal=2;
                $points+=$this->Pool("Weight_Goal");                
            }
        }

        $changed=False;
        foreach
            (
                array
                (
                    "Result"       => $result,
                    "Result_Goals" => $goals,
                    "Result_Goal"  => $goal,
                    "Points"       => $points,
                )
                as $data => $value
            )
        {
            if (empty($bet[ $data ]) || $bet[ $data ]!=$value)
            {
                $changed=True;
                $bet[ $data ]=$value;
                array_push($updatedatas,$data);
            }
        }

        $data="LastCalc";
        if (empty($bet[ $data ]) || $changed)
        {
            $bet[ $data ]=time();
            array_push($updatedatas,$data);
        }
        
    }
}

?>