<?php


trait MyMod_Search_Field_Time_CGI
{
    var $MyMod_Search_Field_Time_CGI=array();
    
    //*
    //* Detect From and To MTimes from CGI values.
    //*

    function MyMod_Search_Field_Time_CGI_Interval($data,$rdata)
    {
        $cgi=$this->MyMod_Search_Field_Time_CGI($data,$rdata);

        $cgi_from = $this->MyTime_Info_2_MTime($cgi[ "From" ]);
        $cgi_to   = $this->MyTime_Info_2_MTime($cgi[ "To" ]);
        if
            (
                ($cgi_from - $cgi[ "From" ][ 't' ]!=0)
                ||
                ($cgi_to   - $cgi[ "To" ][ 't' ]!=0)
            )
        {
            if ($cgi_from>$cgi_to)
            {
                #var_dump("$data: Swap!!! $cgi_from-$cgi_to",$cgi_to-$cgi_from);
                $tmp=$cgi_from;
                $cgi_from=$cgi_to;
                $cgi_to=$tmp;
            }
            
            return
                array
                (
                    $cgi_from,
                    $cgi_to
                );
            /* return */
            /*     array */
            /*     ( */
            /*         $this->MyTime_Info_2_MTime($cgi[ "From" ]), */
            /*         $this->MyTime_Info_2_MTime($cgi[ "To" ]) */
            /*     ); */
        }

        return array();
    }

    //*
    //* Will read CGI and fill in defaults.
    //*

    function MyMod_Search_Field_Time_CGI($data,$rdata)
    {
        if (empty($this->MyMod_Search_Field_Time_CGI[ $data ]))
        {
            $this->MyMod_Search_Field_Time_CGI[ $data ]=
                $this->MyMod_Search_Field_Time_CGI_Read($data,$rdata);
        }

        return $this->MyMod_Search_Field_Time_CGI[ $data ];
    }

    
    //*
    //* Will read CGI and fill in defaults.
    //*

    function MyMod_Search_Field_Time_CGI_Read($data,$rdata)
    {
        $cgi=
            array
            (
                "Year" => $this->CurrentYear(),
                "Month" => $this->CurrentMonth(),
            );

        $min=$this->Sql_Select_Min(array(),$data);
        if ($min==0) { $min=1; }
        
        $max=$this->Sql_Select_Max(array(),$data);
        if ($max==0) { $max=1; }
        $max+=60*60*24;
        
        if ($min>$max)
        {
            //var_dump("$data, Swap:  -");
            $tmp=$min;
            $min=$max;
            $max=$tmp;
        }

        $min=
            array_merge
            (
                array
                (
                    "Time" => $min,
                ),
                $this->MyTime_Info($min)
            );
        $max=
            array_merge
            (
                array
                (
                    "Time" => $max,
                ),
                $this->MyTime_Info($max)
            );
           
        $cgi=
            array
            (
                "From" => $min,
                "To"   =>  $max,
            );

        foreach ($this->MyMod_Search_Field_Time_Fields() as $field)
        {
            foreach ($this->MyMod_Search_Field_Time_Components() as $component)
            {
                $key=$this->MyMod_Search_Field_Time_Component_Key($component,$field,$data,$rdata);
                if (!empty($_POST[ $key ]))
                {
                    $cgi[ $field ][ $component ]=sprintf("%02d",$this->CGI_POSTint($key));
                }
            }
            
            $cgi[ $field ][ "CGI" ]=$this->MyTime_Info_2_MTime($cgi[ $field ]);
        }
        
        
        return $cgi;
    }
}

?>