<?php

trait Sql_Insert
{
    var $Sql_Insert_Echo=False;
    
    //*
    //* Inserts $items into $table.
    //* 

    function Sql_Insert_Items($items,$table="",$nocheckcols=TRUE)
    {
        $queries=$this->Sql_Insert_Items_Queries($items,$table="",$nocheckcols);
        $result=NULL;
        foreach ($queries as $query)
        {
            $result=$this->DB_Query($query);
        }
        
        return $result;
    }
    
    //*
    //* Adds $item (assoc array) to DB table $table
    //* 

    function Sql_Insert_Item(&$item,$table="",$nocheckcols=FALSE)
    {        
        if (!preg_match('/^__(Table|Index)__$/',$table))
        {
            $time=time();
            foreach (array("ATime","CTime","MTime") as $key)
            {
                if (empty($item[ $key ]))
                {
                    $item[ $key ]=$time;
                }
            }
        }

        $this->LastSqlInsert=
            $this->Sql_Insert_Item_Query($item,$table,$nocheckcols);

        if ($this->Sql_Insert_Echo)
        {
            print $this->LastSqlInsert."\n";
        }

        if (!$this->Sql_Table_Exists($table))
        {
            $this->Sql_Table_Structure_Update(array(),array(),TRUE,$table);            
        }
        
        $result=$this->DB_Query($this->LastSqlInsert);
        $item[ "ID" ]=$this->Sql_Insert_LastID($result,$table);

        if ($this->Sql_Insert_Echo)
        {
            print "Insert ID: ".$item[ "ID" ]."\n";
        }
        
        return $result;
    }

    //*
    //* Adds $item (assoc array) to DB table $table
    //* 

    function Sql_Insert_Unique($where,&$item,$table="",$nocheckcols=FALSE)
    {
        $ritem=
            $this->Sql_Select_Hash
            (
                $where,
                TRUE,
                array("ID"),
                $table
            );

       
        if (empty($ritem))
        {
            $this->Sql_Insert_Item($item,$table,$nocheckcols);

            return TRUE;
        }
        else { $item=$ritem; }
       
        return FALSE;
    }
    
    //*
    //* Generates query inserting item into $table.
    //* 

    function Sql_Insert_Item_Query($item,$table="",$nocheckcols=False)
    {
        if (empty($table)) { $table=$this->SqlTableName($table); }

        foreach (array("CTime","ATime","MTime") as $data)
        {
            $item[ $data ]=time();
        }
        
        $query1="";
        $query2="";
        foreach ($item as $data => $value)
        {
            if (!is_array($value))// && !empty($value))
            {
                if
                    (
                        $nocheckcols
                        ||
                        $this->Sql_Table_Field_Exists($data,$table)
                    )
                {
                    $query1.=$this->Sql_Table_Column_Name_Qualify($data).", ";
                    $query2.=$this->Sql_Table_Column_Value_Qualify($value).", ";
                }
            }
        }

        $query1=preg_replace('/,\s$/',"",$query1);
        $query2=preg_replace('/,\s$/',"",$query2);

        return
            "INSERT INTO ".
            $this->Sql_Table_Name_Qualify($table).
            "\n(\n   ".
            $query1.
            "\n) VALUES\n(\n   ".
            $query2.
            "\n)";
    }
    
    //*
    //* Returns next ID: max+1.
    //* 

    function Sql_Insert_NextID($table)
    {
        $ids=$this->Sql_Select_Unique_Col_Values("ID",array(),"",$table);

        $max=0;
        foreach ($ids as $id) { if ($id>$max) { $max=$id; } }

        return $max+1;
    }
    
    //*
    //* Adds $item (assoc array) to DB table $table
    //* 

    function Sql_Insert_LastID($result,$table)
    {
        $type=$this->DB_Dialect();

        $id=0;
        if ($type=="mysql")
        {
            $id=$this->DB_Method_Call("Insert_LastID",$result);
        }
        elseif ($type=="pgsql")
        {
            $query="SELECT max(\"ID\") FROM ".$this->Sql_Table_Name_Qualify($table);
            $result=$this->DB_Query($query);
            $result=$this->DB_Fetch_Assoc($result);
            if (!empty($result[ 'max' ])) $id=$result[ 'max' ];
        }

        return $id;
    }
    
    
    
    //*
    //* Generates query inserting $items into $table.
    //* 

    function Sql_Insert_Items_Queries($items,$table="",$nocheckcols=TRUE)
    {
        $queries=array();
        foreach ($items as $item)
        {
            array_push
            (
                $queries,
                $this->Sql_Insert_Item_Query($item,$table,$nocheckcols)
            );
        }

        return $queries;
    }
    
    //*
    //* Genertates query inserting $items into $table.
    //* 

    function Sql_Insert_Items_Query($items,$table="",$nocheckcols=TRUE)
    {
        $queries=array();
        foreach ($items as $item)
        {
            array_push
            (
                $queries,
                $this->Sql_Insert_Item_Query($item,$table,$nocheckcols)
            );
        }

        return join(";\n",$this->Sql_Insert_Items_Queries($items,$table,$nocheckcols));
    }
}
?>