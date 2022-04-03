<?php

include_once("API/Locate.php");
include_once("API/Swap.php");
include_once("API/Update.php");

trait Tournament_Matches_API
{
    use
        Tournament_Matches_API_Locate,
        Tournament_Matches_API_Swap,
        Tournament_Matches_API_Update;

    //*
    //* Returns Hash with $data -> $api_key's.
    //* Based on Matches::ItemData 'Key's.
    //*

    function Tournament_Matches_API_Hash()
    {
        $hash=array();
        foreach (array_keys($this->MatchesObj()->ItemData()) as $data)
        {
            if (!empty($this->MatchesObj()->ItemData[ $data ][ "Key" ]))
            {
                $hash[ $data ]=
                    $this->MatchesObj()->ItemData[ $data ][ "Key" ];
                
                if (!is_array($hash[ $data ]))
                {
                    $hash[ $data ]=array($hash[ $data ]);
                }
            }
        }

        return $hash;
    }  

}

?>