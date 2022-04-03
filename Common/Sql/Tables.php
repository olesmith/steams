<?php

trait Sql_Tables
{
    var $SQL_Tables=array();
    
    //*
    //* Returns listwith the names of the Tables in current database.
    //* If $regexp given, applies it to list returned. NOT IMPLEMENTED
    //* 

    function Sql_Tables() //removed 20210127! ($regexp="")
    {
        if (empty($this->SQL_Tables))
        {
            $tables=$this->Sql_Table_Names();

            $this->SQL_Tables=array();
            foreach ($tables as $table)
            {
                $comps=preg_split('/_+/',$table);
                $module=array_pop($comps);

                if (empty($this->SQL_Tables[ $module ]))
                {
                    $this->SQL_Tables[ $module ]=array();
                }

                $this->SQL_Tables[ $module ][ $table ]=$table;
            }
        }

        return $this->SQL_Tables;        
    }
    
    //* 
    //* 
    //* 

    function Sql_Tables_Module($module,$regexp="")
    {
        $this->Sql_Tables();

        $tables=array();
        if (!empty($this->SQL_Tables[ $module ]))
        {
            $tables=
                preg_grep
                (
                    '/'.$regexp.'/',
                    $this->SQL_Tables[ $module ]
                );
        }

        return $tables;
    }
    
    //*
    //* Returns list of items, conforming to $where, in lists of tables,
    //* conforming to $regexp.
    //* 

    function Sql_Tables_Select_Hashes($regexp="",$where=array(),$datas=array())
    {
        $sqltables=$this->Sql_Table_Names($regexp);

        $items=array();
        foreach ($sqltables as $sqltable)
        {
            $ritems=$this->Sql_Select_Hashes
            (
               $where,
               $datas,
               "",
               FALSE,
               $sqltable
            );

            if (count($ritems)>0)
            {
                foreach (array_keys($ritems) as $id)
                {
                    $ritems[ $id ][ "SQLTable" ]=$sqltable;
                }
            
                array_push($items,$ritems);
            }
        }
 
        return $items;
    }
    
    //*
    //* Returns list of items, conforming to $where, in lists of tables,
    //* conforming to $regexp.
    //* 

    function Sql_Tables_Select_NHashes($regexp="",$where=array())
    {
        $sqltables=$this->Sql_Table_Names($regexp);

        $nitems=0;
        foreach ($sqltables as $sqltable)
        {
            $nitems+=
                $this->Sql_Select_NHashes
                (
                    $where,
                    $sqltable
                );
        }
 
        return $nitems;
    }
    
    //*
    //* function Sql_Tables_Items_Copy, Parameter list:)
    //*
    //* Copies all $items in $table.
    //* 
    //* 

    function Sql_Tables_Items_Copy($items,$table)
    {
        var_dump("SQL table: ".$table);
        foreach ($items as $item)
        {
            $this->Sql_Tables_Item_Copy($item,$table);
        }
    }
    
    //*
    //* function Sql_Tables_Item_Copy, Parameter list: 
    //*
    //* Copy $item into table.
    //* 
    //* 

    function Sql_Tables_Item_Copy($item,$table)
    {
        $ritem=$this->Sql_Select_Hash(array("ID" => $item[ "ID" ]));

        if (empty($ritem))
        {
            var_dump("Create: ".$item[ "ID" ]);
            var_dump($this->Sql_Insert_Item($item,$table,TRUE));
        }
        else
        {
            var_dump("Update: ".$item[ "ID" ]);
        }
        
    }
}
?>