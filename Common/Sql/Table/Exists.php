<?php


trait Sql_Table_Exists
{
    //*
    //* Tests whether sql table exists.
    //*
    //* 

    function Sql_Table_Exists($tables="")
    {
        $srvtype=$this->DBHash("ServType");
        if ($srvtype=='webservice')
        {
            return True;
        }
        
        if (empty($tables)) { $tables=$this->SqlTableName($tables); }


        if (!is_array($tables)) { $tables=array($tables); }

        $return=False;
        foreach ($tables as $table)
        {
            /* if (!empty($this->ApplicationObj()->Tables[ $table ])) */
            /* { */
            /*     return TRUE; */
            /* } */
        
            $query=$this->Sql_Table_Exists_Query($table);
        
            $exists=True;
            $res=FALSE;
            try
            {
                $res=$this->DB_Query($query,TRUE);
            }

            catch (Exception $e)
            {
                // We got an exception == table not found
                $exists=FALSE;
            }
        

            if ($exists)
            {
                $this->ApplicationObj()->Tables[ $table ]=TRUE;
                return True;
            }            
        }
        

        return $return;
    }
    
    //*
    //* function Sql_Table_Exists_Query, Parameter list: $table=""
    //*
    //* Creates Table according to SQL specification in $vars,
    //* if it does not exist already.
    //*
    //* 

    function Sql_Table_Exists_Query($table="")
    {
        $type=$this->DB_Dialect();
        $query="";
        if ($type=="mysql")
        {
            $query=
                'SELECT 1 FROM '.
                $this->Sql_Table_Name_Qualify($this->DBHash("DB")).
                ".".
                $this->Sql_Table_Name_Qualify($table);
        }
        elseif ($type=="pgsql")
        {
            $query=
                'SELECT 1 FROM '.
                $this->Sql_Table_Name_Qualify($table);
        }
        
        return $query;
    }
    
    //*
    //* function Sql_Tables_Exists, Parameter list: $tables=array()
    //*
    //* Returns existen tables in $table. $table may be one table, a scalar.
    //*
    //* 

    function Sql_Tables_Exists($tables=array())
    {
        if (!is_array($tables)) { $tables=array($tables); }
        
        $rtables=array();
        foreach ($tables as $table)
        {
            if ($this->Sql_Table_Exists($table))
            {
                array_push($rtables,$table);
            }
        }

        return $rtables;
    }
    
    //*
    //* function Sql_Table_Exists, Parameter list: $table=""
    //*
    //* Tests whether sql table exists.
    //*
    //* 

    function Sql_Table_Exists_And_Not_Empty($table="",$where=array())
    {
        if (empty($table)) { $table=$this->SqlTableName($table); }
        
        return
            $this->Sql_Table_Exists()
            &&
            ($this->Sql_Select_NHashes($where,$table)>0);
    }

    //*
    //* function Sql_Table_Exists, Parameter list: $table=""
    //*
    //* Tests whether sql table exists.
    //*
    //* 

    function Sql_Table_Empty_Is($table="",$where=array())
    {
        return !$this->Sql_Table_Exists_And_Not_Empty($table,$where);
    }
    
    //*
    //* function Sql_Table_Exists, Parameter list: $table=""
    //*
    //* Tests whether sql table exists.
    //*
    //* 

    function Sql_Tables_Empty_Is($tables,$where=array())
    {
        $res=True;
        foreach ($tables as $table)
        {
            $res=(   $res && $this->Sql_Table_Empty_Is($table,$where)   );
            
            if (!$res) { break; }
        }

        
        return $res;
    }
}
?>