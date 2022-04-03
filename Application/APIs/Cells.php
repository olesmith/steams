<?php

trait Application_API_Cells
{
    //*
    //* Prettify JSON result
    //*

    function Application_API_Cell_Result($edit=0,$api=array(),$data="")
    {
        if (empty($api[ "Result" ]))
        {
            return $this->MyMod_Data_Title($data);
        }

        $json=json_decode($api[ "Result" ],True);

        var_dump($api[ "Result" ],$json);
        return json_encode($json, JSON_PRETTY_PRINT);
    }
}

?>