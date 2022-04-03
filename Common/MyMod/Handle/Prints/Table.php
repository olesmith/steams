<?php

trait MyMod_Handle_Prints_Table
{
    //*
    //* 
    //*

    function MyMod_Handle_Prints_Table($type,$item=array())
    {
        $table=array();
        $n=0;
        foreach ($this->LatexData[ $type ][ "Docs" ] as $doc)
        {
            $n++;
            if (!empty($doc[ "Access_Method" ]))
            {
                $method=$doc[ "Access_Method" ];
                if (!$this->$method($item))
                {
                    continue;
                }
            }
            
            array_push
            (
                $table,
                $this->MyMod_Handle_Prints_Row($type,$n,$doc)
            );
        }
        
        return $table;
    }
}

?>