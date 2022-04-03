<?php

trait MyList
{
    //*
    //* Merge list of $tables.
    //* Should have same number of lines.
    //*

    function MyList_Merge($tables)
    {
        $table=array_shift($tables);

        foreach ($tables as $rtable)
        {
            if (count($table)==count($rtable))
            {
                foreach (array_keys($rtable) as $id)
                {
                    $table[ $id ]=
                        array_merge
                        (
                            $table[ $id ],
                            $rtable[ $id ]
                        );
                }
            }
            
        }

        return $table;
    }
    
    //*
    //* 
    //*

    function MyList_Append($list,$str)
    {
        foreach (array_keys($list) as $id)
        {
            $list[ $id ].=$str;
        }

        return $list;
    }
    
}

?>