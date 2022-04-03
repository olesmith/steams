<?php

trait Tournament_Matches_API_Update_Values
{
    //*
    //* 
    //*

    function Tournament_Match_API_Update_Values_With_Hash($tournament,$season,$jmatch,&$match,&$updatedatas,&$updatevalues,$hash=array())
    {
        if (empty($hash))
        {
            $hash=
                $this->Tournament_Matches_API_Hash();
        }

        
        foreach ($hash as $data => $keys)
        {
            $value=$jmatch;
            foreach ($keys as $key)
            {
                if (isset($value[ $key ]))
                {
                    $value=$value[ $key ];
                }
            }
            
            if (!is_array($value))
            {
                $old_value=
                    $this->MyHash_Key_Get_Save($match,$data,"-");
                
                
                if
                    (
                        !isset($match[ $data ])
                        ||
                        $value!=$old_value
                    )
                {
 
                    if ($this->API_Debug)
                    {
                        print $data.": ".$old_value." --> ".$value."<BR>\n";
                    }
                
                    array_push($updatedatas,$data);
                    array_push($updatevalues,$old_value." => ".$value);
                    $match[ $data ]=$value;
                }
            }
        }
    }
}

?>