<?php

trait Sql_Select_Hashes
{
    var $Sql_Select_Hashes_Unique_Col="ID";
    
    //*
    //* Perform a select query on Table $table in the current DB.
    //* Returns each match as a hash of the field names in
    //* in $fields or all data if $fields is not an array.

    function Sql_Select_Hashes($where="",$fieldnames=array(),$orderby="",$postprocess=FALSE,$table="",$limit="",$offset="")
    {
        if (!$this->Sql_Table_Exists($table)) { return array(); }

        $this->LastSqlWhere=
            $this->Sql_Select_Hashes_Query
            (
                $where,
                $fieldnames,
                $orderby,
                $table,
                $limit,
                $offset
            );

        $result=$this->DB_Query_2Assoc_List($this->LastSqlWhere);

        if ($result && $postprocess && method_exists($this,"PostProcessItemList"))
        {
            $this->PostProcessItemList($result);
        }

        if (empty($result)) { $result=array(); }
        
        if (empty($table)) { $table=$this->SqlTableName(); }
        foreach (array_keys($result) as $id)
        {
            $result[ $id ][ "SQL" ]=$table;
        }
        
        return $result;
    }
    
    //*
    //* Perform a select query on Table $table in the current DB.
    //* Returns number of matches aconforming to $where.
    //* 

    function Sql_Select_NHashes($where="",$table="")
    {
        if (!$this->Sql_Table_Exists($table)) { return 0; }
        
        $query=$this->Sql_Select_NHashes_Query($where,$table);

        $result = $this->DB_Query_2Assoc_List($query);

        //var_dump($result);
        $this->LastSqlWhere=$query;

        $type=$this->DB_Dialect();
        if ($type=="mysql")
        {
            return intval($result[0][ 'COUNT('.$this->Sql_Select_Hashes_Unique_Col.')' ]);
        }
        elseif ($type=="pgsql")
        {
            return intval($result[0][ 'count' ]);
        }

        return 0;
    }
    
    
    //* 
    //* Perform a select query on Table $table in the current DB.
    //* Returns each match as a hash of the field names in
    //* in $fields or all data if $fields is not an array.
    //* 

    function Sql_Select_Hashes_ByID($where="",$fields=array(),$bykey="ID",$orderby="",$postprocess=FALSE,$table="",$limit="",$offset="")
    {
        return
            $this->MyHash_HashesList_2ID
            (
                $this->Sql_Select_Hashes
                (
                    $where,
                    $fields,
                    $orderby,
                    $postprocess,
                    $table,
                    $limit,
                    $offset
                ),
                $bykey
            );
    }
    
    //*
    //* Generates the SQL select hashes query.
    //* 

    function Sql_Selects_Hashes($tables,$where="",$fieldnames=array(),$orderby="",$postprocess=FALSE,$limit="",$offset="")
    {
        $items=array();
        foreach ($tables as $table)
        {
            $ritems=
                $this->Sql_Select_Hashes
                (
                    $where,$fieldnames,
                    $orderby,
                    $postprocess,
                    $table,
                    $limit,$offset
                );
            foreach (array_keys($ritems) as $id)
            {
                $ritems[ $id ][ "SQL" ]=$table;
            }
            
            $items=array_merge($items,$ritems);
        }

        //var_dump($items);
        return $items;
    }
    
    //*
    //* Generates the SQL slect hashes query.
    //* 

    function Sql_Select_Hashes_Query($where="",$fields=array(),$orderby="",$table="",$limit="",$offset="")
    {
        if (empty($table)) { $table=$this->SqlTableName(); }
        
        if (is_array($where))
        {
            $where=$this->Hash2SqlWhere($where);
        }

        if (empty($fields) || $fields=="*")
        {
            $fieldnames=array();
        }
        else
        {
            $fieldnames=$this->Sql_Table_Fields_Exists($fields,$table);

            if (!preg_grep('/^ID$/',$fieldnames))
            {
                array_push($fieldnames,"ID");
            }
        }
       

        $query=
            'SELECT '.
            $this->Sql_Table_Column_Names_Qualify($fieldnames).
            ' FROM '.
            /* $dbstring. */
            $this->Sql_Table_Name_Qualify_With_DB($table).
            '';

        if (preg_match('/\S/',$where))
        {
            $query.=' WHERE '.$where;
        }
        
        if (!empty($orderby))
        {
            $query.=
                ' ORDER BY '.
                $this->Sql_Table_Column_Sort_Names_Qualify($orderby);
        }

        if (!empty($limit))
        {
            $query.=' LIMIT '.$limit;
        }
        if (!empty($offset))
        {
            $query.=' OFFSET '.$offset;
        }

        return $query;
    }

    //*
    //* Generates several select queries, one for each clause in $wheres.
    //* 

    function Sql_Select_Hashes_Queries($wheres,$fieldnames,$orderby="",$table="")
    {
        $queries=array();
        foreach ($wheres as $where)
        {
            array_push
            (
               $queries,
               $this->Sql_Select_Hashes_Query($where,$fieldnames,$orderby,$table)
            );
        }

        return $queries;
    }
    
    
    //*
    //* Generates the SQL slect hashes query.
    //* 

    function Sql_Select_NHashes_Query($where="",$table="")
    {
        if (empty($table)) { $table=$this->SqlTableName(); }
        if (is_array($where)) { $where=$this->Hash2SqlWhere($where); }

        $type=$this->DB_Dialect();
        $dbstring="";
        if ($type=="mysql")
        {
            $dbstring=
                $this->Sql_Table_Name_Qualify($this->DBHash("DB")).
                ".";
        }
        
        //$fieldnames=array($fieldname);
        $query=
            'SELECT '.
            " COUNT(".$this->Sql_Table_Column_Names_Qualify($this->Sql_Select_Hashes_Unique_Col).")".
            ' FROM '.
            $dbstring.
            $this->Sql_Table_Name_Qualify($table).
            '';
        
        if (preg_match('/\S/',$where)) { $query.=' WHERE '.$where; }

        return $query;
    }


    
    //*
    //* Perform a select query on Table $table in the current DB.
    //* Returns each match as a hash of the field names in
    //* in $fields or all data if $fields is not an array.
    //* 

    function Sql_Select_IDs($ids,$fields,$orderby="",$postprocess=FALSE,$table="")
    {
        return
            $this->Sql_Select_Hashes
            (
                array
                (
                    "ID" => "IN ('".join("', '",$ids)."')"
                ),
                $fields,
                $orderby,
                $postprocess,
                $table           
            );
    }
    
    //*
    //* Returns TRUE, if a Select Hashes sdatement returns any hashes.
    //* 

    function Sql_Select_Hashes_Has($where=array(),$table="")
    {
        $n=$this->Sql_Select_NHashes($where,$table);

        $res=FALSE;
        if ($n>0)
        {
            $res=TRUE;
        }

        return $res;
    }
    //*
    //* function Sql_Select_Hashes_Has_Not, Parameter list: $where,$table=""
    //*
    //* Returns TRUE, if a Select Hashes sdatement returns any hashes.
    //* 

    function Sql_Select_Hashes_Has_Not($where=array(),$table="")
    {
        return (!$this->Sql_Select_Hashes_Has($where,$table));
    }
    
    //*
    //* Reads $field value for $where.
    //* 

    function Sql_Select_Hashes_Value($where,$field,$orderby="",$table="")
    {        
        return
            $this->MyHash_HashesList_Values
            (
                $this->Sql_Select_Hashes
                (
                    $where,
                    array($field),
                    $orderby,
                    $table
                ),
                $field
            );
    }
    
 }
?>