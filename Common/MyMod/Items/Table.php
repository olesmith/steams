<?php


trait MyMod_Items_Table
{
    //*
    //* Creates table with $items
    //*

    function MyMod_Items_Table($edit,$items,$datas,$options=array())
    {
        $plural=True;
        if (!empty($options[ "Plural" ])) { $plural=$options[ "Plural" ]; }

        $table=array();
        $n=1;
        foreach ($items as $id => $item)
        {
            if (empty($item[ "No" ])){ $item[ "No" ]=$n; }

            if (!empty($item[ "No" ]) && !empty($options[ "Format" ]))
            {
                $item[ "No" ]=sprintf($options[ "Format" ],$item[ "No" ]);
            }

            $pre="";
            if
                (
                    $plural
                    &&
                    !empty($item[ "ID" ])
                )
            {
                $pre=$item[ "ID" ]."_";
            }
            
            $table[ $id ]=
                $this->MyMod_Items_Table_Row
                (
                    $edit,$n,$item,$datas,$plural,$pre
                );

            $n++;
        }

        return $table;
    }
}

?>