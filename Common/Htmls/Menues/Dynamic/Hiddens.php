<?php


trait Htmls_Menues_Dynamic_Hiddens
{
    //*
    //* 
    //*

    function Htmls_Menues_Dynamic_Hidden_JS($key,$is_hide_cell)
    {
        return
            //"\n//Enter Htmls_Menues_Dynamic_Hidden_JS.\n".
            $this->JS_Hide_Elements_By_ID
            (
                $this->Htmls_Menues_Dynamic_Hidden_IDs
                (
                    $key,
                    $is_hide_cell
                )                
            );
    }
    
    //*
    //* 
    //*

    function Htmls_Menues_Dynamic_Hidden_IDs($key,$is_hide_cell)
    {
        $ids=array();
        if ($this->Htmls_Menues_Dynamic_Entry_Toggle($key))
        {
            $ids=
                $this->Htmls_Menues_Dynamic_Entry_Other_IDs
                (
                    $key,"Hide"
                );
        }
        
        if ($is_hide_cell)
        {
            array_push
            (
                $ids,
                $this->Htmls_Menues_Dynamic_Entry_ID($key,"Hide")
            );

            $destination=
                $this->Htmls_Menues_Dynamic_Entry_Destination_ID($key);

            if (!empty($destination))
            {
                array_push($ids,$destination);
            }

        }
        else
        {
            array_push
            (
                $ids,
                $this->Htmls_Menues_Dynamic_Entry_ID($key,"Show")
            );
            
            if ($this->Htmls_Menues_Dynamic_Entry_Toggle($key))
            {
                $ids=
                    array_merge
                    (
                        $ids,
                        $this->Htmls_Menues_Dynamic_IDs_Destinations($key)
                    );
            }
            else
            {
                $destination=
                    $this->Htmls_Menues_Dynamic_Entry_Destination_ID($key);

                if (!empty($destination))
                {
                    array_push($ids,$destination);
                }
            }
            
        }
        
        return $ids;
    }
}
?>