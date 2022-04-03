<?php


trait Pool_Ranking_Months
{
    //*
    //* 
    //*

    function Pool_Ranking_Months_Menu($pool)
    {
        if (!empty($_GET[ "Round" ])) { return array(); }
        
        $html=array();
        foreach
            (
                $this->Pool_Ranking_Months($pool) as $month
            )
        {
            array_push
            (
                $html,
                $this->Pool_Ranking_Month_Cell($pool,$month)
            );
        }

        return
            $this->Htmls_DIV
            (
                $html,
                array
                (
                    "ALIGN" => 'center'
                )
            );
    }
    //*
    //* 
    //*

    function Pool_Ranking_Month_Cell($pool,$month)
    {
        $color='orange';
        if ($this->CGI_GETint("Month")==$month)
        {
            $color='grey';
        }
        return
            $this->Htmls_SPAN
            (
                preg_replace('/(\d\d\d\d)(\d\d)/',"$2/$1",$month),
                array
                (
                    "ONCLICK" => $this->JS_Load_URL_2_Element
                    (
                        array_merge
                        (
                            $this->CGI_URI2Hash(),
                            array
                            (
                                "Month" => $month,
                            )
                        ),
                        $this->CGI_GET("Dest")
                    ),
                    "STYLE" => array
                    (
                        "color" => $color,
                    ),
                )
            );
    }
    
    //*
    //* 
    //*

    function Pool_Ranking_Months($pool)
    {
        $dates=
            $this->MatchesObj()->Sql_Select_Unique_Col_Values
            (
                "Date",
                array
                (
                    "Tournament" => $pool[ "Tournament" ],
                    "Season"     => $pool[ "Season" ],
                )
            );

        $months=array();
        foreach ($dates as $date)
        {
            $month=preg_replace('/\d\d$/',"",$date);
            $months[ $month ]=True;
        }
        
        $months=array_keys($months);
        sort($months);

        return $months;
    }
}

?>