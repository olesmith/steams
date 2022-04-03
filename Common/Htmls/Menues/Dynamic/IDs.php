<?php


trait Htmls_Menues_Dynamic_IDs
{    
    //*
    //* Cell IDs of _Destinations_.
    //* If $ckey is given (non-empty), exclude the ID of this destination.
    //*

    function Htmls_Menues_Dynamic_IDs_Destinations($ckey="")
    {
        $ids=array();
        foreach ($this->Htmls_Menues_Dynamic_Destination_Keys() as $key)
        {
            if (!empty($ckey) && $ckey==$key)
            {
                continue;
            }

            $id=
                $this->Htmls_Menues_Dynamic_ID_Destination
                (
                    $key
                );


            if (is_string($id) && !empty($id))
            {
                $ids[ $id ]=True;
            }
        }

        $ids=array_keys($ids);
        sort($ids);
        //var_dump($ids);
        return $ids;
    }

    //*
    //*
    //*

    function Htmls_Menues_Dynamic_ID_Destination($key)
    {
        return
            $this->Htmls_Menues_Dynamic_Destination_Value
            (
                $key,"ID" //"Cell_ID";
            );
    }
   
}
?>