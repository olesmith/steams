<?php

trait Sql_Table_Qualify
{
    //*
    //* Quotes sql table name according to sql dialect.
    //* 

    function Sql_Table_Name_Qualify($table="")
    {
        if (empty($table)) { $table=$this->SqlTableName(); }
        $type=$this->DB_Dialect();
        
        $res=$table;
        if ($type=="mysql")
        {
            $res="`".$table."`";
        }
        elseif ($type=="pgsql" && preg_match('/[A-Z]/',$table))
        {
            $res='"'.$table.'"';
        }

        return $res;
    }
    
    //*
    //* Quotes sql table name according to sql dialect.
    //* 

    function Sql_Table_Name_Qualify_With_DB($table="")
    {
        if (empty($table)) { $table=$this->SqlTableName(); }
        $type=$this->DB_Dialect();
        
        $res=$table;
        if ($type=="mysql")
        {
            $res="`".$table."`";
        }
        elseif ($type=="pgsql" && preg_match('/[A-Z]/',$table))
        {
            $res='"'.$table.'"';
        }

        return
            $this->Sql_DB_String().
            $res;
    }
    
    //*
    //* Quotes sql $tables names according to (sql) dialect - with DB qualifier.
    //* 

    function Sql_Table_Names_Qualify_With_DB($tables)
    {
        if (!is_array($tables)) { $tables=array($tables); }
        
        $rtables=array();
        foreach ($tables as $table)
        {
            array_push
            (
                $rtables,
                $this->Sql_Table_Name_Qualify_With_DB($table)
            );
        }

        return join(",",$rtables);        
    }
    
    //*
    //* Quotes sql $tables names according to (sql) dialect.
    //* 

    function Sql_Table_Names_Qualify($tables)
    {
        if (!is_array($tables)) { $tables=array($tables); }
        
        $rtables=array();
        foreach ($tables as $table)
        {
            array_push
            (
                $rtables,
                $this->Sql_Table_Name_Qualify($table)
            );
        }

        return join(" ",$rtables);
   }
    
    //*
    //* Quotes sql column name according to sql dialect.
    //* 
    //*
    //* 

    function Sql_Table_Column_Name_Qualify($data)
    {
        $type=$this->DB_Dialect();
        
        $res=$data;
        if ($type=="mysql")
        {
            $res=$data;
        }
        elseif ($type=="pgsql")
        {
            $res='"'.$data.'"';
        }

        return $res;
    }
    
    //* 
    //* Quotes sql sort column name according to sql dialect.
    //* Takes ASC/DESC into account
    //* 

    function Sql_Table_Column_Sort_Name_Qualify($data)
    {
        $order="";
        if (preg_match('/\s*(ASC|DESC)\s*/',$data,$matches))
        {
            $data=preg_replace('/\s*(ASC|DESC)\s*/',"",$data);
            $order=" ".preg_replace('/\s+/',"",$matches[0]);
        }

        return
            $this->Sql_Table_Column_Name_Qualify($data).
            $order;        
    }
    
    //*
    //* Quotes sql column name according to sql dialect, a.
    //* 
    //*
    //* 

    function Sql_Table_Column_Names_Qualify_List($datas)
    {
        $rdatas=array();
        foreach ($datas as $data)
        {
            array_push
            (
                $rdatas,
                $this->Sql_Table_Column_Name_Qualify($data)
            );
        }

        return $rdatas;
    }

    //*
    //* Quotes sql column name according to sql dialect.
    //* 
    //*
    //* 

    function Sql_Table_Column_Names_Qualify($datas)
    {
        if (empty($datas)) { return "*"; }
        
        if (!is_array($datas)) { $datas=preg_split('/\s*,\s*/',$datas); }
        
        return
            join
            (
               ", ",
               $this->Sql_Table_Column_Names_Qualify_List($datas)
            );
    }
    
    
    //*
    //* Quotes sql column name according to sql dialect.
    //* 
    //*
    //* 

    function Sql_Table_Column_Sort_Names_Qualify($datas)
    {
        if (empty($datas)) { return "*"; }
        
        if (!is_array($datas)) { $datas=preg_split('/\s*,\s*/',$datas); }

        $names=array();
        foreach ($datas as $data)
        {
            array_push
            (
                $names,
                $this->Sql_Table_Column_Sort_Name_Qualify($data)
            );
        }
        
        return join(", ",$names);
    }
    
    
    //*
    //* Quotes sql column value according to sql dialect.
    //* 
    //*
    //* 

    function Sql_Table_Column_Value_Qualify($value)
    {
        $type=$this->DB_Dialect();
        
        $res=$value;
        if ($type=="mysql")
        {
            if (is_array($value)) var_dump($value); 
            $res="'".$value."'";
        }
        elseif ($type=="pgsql")
        {
            $res="'".$value."'";
        }

        return $res;
    }
    
    //*
    //* Quotes sql column values according to sql dialect.
    //* 
    //*
    //* 

    function Sql_Table_Column_Values_Qualify($values)
    {
        if (!is_array($values)) { $values=array($values); }
        
        $rvalues=array();
        foreach ($values as $value)
        {
            if (!empty($value))
            {
                array_push
                (
                    $rvalues,
                    $this->Sql_Table_Column_Value_Qualify($value)
                );
            }
        }

        return join(", ",$rvalues);
   }
    
    
    //*
    //* Quotes sql column $data=$value qualified according to sql dialect.
    //* 
    //*
    //* 

    function Sql_Table_Column_Name_Value_Qualify($data,$value,$operator="=")
    {
        return
            $this->Sql_Table_Column_Name_Qualify($data).
            $operator.
            $this->Sql_Table_Column_Value_Qualify($value);
    }
    
    //*
    //* function Sql_Table_Column_Hash_Qualify, Parameter list: $hash,$glue=" AND "
    //*
    //* Quotes sql column $data=$value qualified according to sql dialect.
    //* 
    //*
    //* 

    function Sql_Table_Column_Hash_Qualify($hash,$glue=" AND ")
    {
        $wheres=array();
        foreach ($hash as $data => $value)
        {
            array_push($wheres,$this->Sql_Table_Column_Name_Value_Qualify($data,$value));
        }

        return join($glue,$wheres);
    }
    
}
?>