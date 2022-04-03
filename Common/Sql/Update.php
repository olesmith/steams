<?php

trait Sql_Update
{
    var $Sql_Update_Queries=array();
    
    //*
    //* Updates $item (assoc array) to DB table $table, if needed.
    //* 

    function Sql_Update_Item($item,$where,$datas=array(),$table="",$force=False,$pretend=False)
    {
        $query=$this->Sql_Update_Item_Query($item,$where,$datas,$table,$force);

        array_push($this->ApplicationObj()->Sql_Update_Queries,$query);

        if ($pretend) { return $query; }

        if (!empty($query))
        {
            $res=$this->DB_Query($query);
            return $query;
        }
        else
        {
            return -1;
        }
    }

    //*
    //* Sets value of var $var of item with key $idvar $id in table $table. 
    //* Returns value set.
    //* 

    function Sql_Update_Item_Value_Set($id,$var,$value,$idvar="ID",$table="")
    {
        if (is_array($id)) { $id=$id[ "ID" ]; }
        
        $query=
            $this->Sql_Update_Item_Value_Set_Query
            (
                $id,$var,$value,$idvar,$table
            );
        
        array_push
        (
            $this->ApplicationObj()->Sql_Update_Queries,
            $query
        );

        return $this->DB_Query($query);
    }
    
    //*
    //* Returns values of var $vars of item with key $idvar $id in table $table. 
    //* 

    function Sql_Update_Item_Values_Set($updatedatas,$item,$table="")
    {
        if (empty($updatedatas)) { return; }

        $query=$this->Sql_Update_Item_Values_Set_Query($updatedatas,$item,$table);
        
        array_push($this->ApplicationObj()->Sql_Update_Queries,$query);
        $this->DB_Query($query);

        return $query;
    }
    
    //*
    //* function Sql_Update_Item_Query, Parameter list: $item,$where,$datas=array(),$table=""
    //*
    //* Updates $item (assoc array) to DB table $table, if needed.
    //* 

    function Sql_Update_Item_Query($item,$where,$datas=array(),$table="",$force=False)
    {
        if (is_array($where)) { $where=$this->Hash2SqlWhere($where); }
        if (empty($datas)) { $datas=array_keys($item); }

        $olditem=$this->Sql_Select_Hash($where,$datas,FALSE,$table);

        $query="";
        
        $nchanges=0;
        foreach ($datas as $key)
        {
            $value=$item[ $key ];
            $value=preg_replace('/\'/',"''",$value);
            
            if
                (
                    $force
                    ||
                    (
                        isset($olditem[ $key ])
                        &&
                        $value!=$olditem[ $key ]
                    )
                )
            {
                $query.=
                    $this->Sql_Table_Column_Name_Qualify($key).
                    "=".
                    $this->Sql_Table_Column_Value_Qualify($value).
                    ", ";
                $nchanges++;
            }
        }

        if ($nchanges>0)
        {
            $query=preg_replace('/,\s$/',"",$query);
            $query="UPDATE ".
                $this->Sql_Table_Name_Qualify($table).
                " SET ".
                $query.
                " WHERE ".
                $where;
        }

        return $query;
    }


    //*
    //* Sets value of var $var of item with key $idvar $id in table $table. 
    //* Returns value set.
    //* 

    function Sql_Update_Item_Value_Set_Query($id,$var,$value,$idvar="ID",$table="")
    {
        $value=preg_replace("/'/","''",$value);
        return
            "UPDATE ".
            $this->Sql_Table_Name_Qualify($table).
            " SET ".
            $this->Sql_Table_Column_Name_Qualify($var).
            "='".$value."'".
            " WHERE ".
            $this->Sql_Table_Column_Name_Qualify($idvar).
            "='".$id."'";
    }
    
    
    
    //*
    //* Sets value of var $var of multiple items with key $idvar $id in table $table. 
    //* Returns value set.
    //* 

    function Sql_Update_Items_Value_Set($idvar,$id,$var,$value,$table="")
    {
        $value=preg_replace("/'/","''",$value);
        $query=
            "UPDATE ".
            $this->Sql_Table_Name_Qualify($table).
            " SET ".
            $this->Sql_Table_Column_Name_Qualify($var).
            "=".
            $this->Sql_Table_Column_Value_Qualify($value).
            " WHERE ".
            $this->Sql_Table_Column_Name_Qualify($idvar).
            "=".
            $this->Sql_Table_Column_Value_Qualify($id);

        $this->DB_Query($query);

        return $value;
    }

    //*
    //* Returns update query.
    //* 

    function Sql_Update_Item_Values_Set_Query($updatedatas,$item,$table="")
    {
        //if (empty($table)) { $table=$this->SqlTableName($table); }

        $item[ "MTime" ]=time();
        array_push($updatedatas,"MTime");

        $done=array();
        
        $sets=array();
        foreach ($updatedatas as $vid => $var)
        {
            if (!empty($done[ $var ])) { continue; }
            
            $type=$this->Sql_Table_Column_Type($var);
            if (preg_match('/^int/',$type) && empty($item[ $var ]))
            {
                $item[ $var ]=0;
            }

            if (is_array($item))
            {
                $value=preg_replace("/'/","''",$item[ $var ]);
            }
            
            array_push
            (
               $sets,
               $this->Sql_Table_Column_Name_Qualify($var).
               "=".
               $this->Sql_Table_Column_Value_Qualify($value)
            );

            $done[ $var ]=True;
        }
    
        return
            "UPDATE ".
            $this->Sql_Table_Name_Qualify($table).
            " SET ".
            join(", ",$sets)." ".
            "WHERE ".
            $this->Sql_Table_Column_Name_Qualify("ID").
            "=".
            $this->Sql_Table_Column_Value_Qualify($item[ "ID" ]);
    }
    
    
    //*
    //* Generrates UPDATE, SET $item WHERE $where.
    //* 

    function Sql_Update_Where_Query($item,$where,$datas=array(),$table="")
    {
        if (is_array($where)) { $where=$this->Hash2SqlWhere($where); }
        if (empty($datas)) { $datas=array_keys($item); }
        
        $sets=array();
        foreach ($datas as $vid => $var)
        {
            $value=preg_replace("/'/","''",$item[ $var ]);
            array_push
            (
               $sets,
               $this->Sql_Table_Column_Name_Qualify($var).
               "=".
               $this->Sql_Table_Column_Value_Qualify($value)
            );
        }
    
        return
            "UPDATE ".
            $this->Sql_Table_Name_Qualify($table).
            " SET ".join(", ",$sets).
            " WHERE ".$where;
    }
    
    //*
    //* Updates $item with $datas, according to $where.
    //* 

    function Sql_Update_Where($item,$where,$datas=array(),$table="")
    {
        $naffected=
            $this->DB_Exec
            (
                $this->Sql_Update_Where_Query
                (
                    $item,$where,$datas,$table
                )
            );

        return $naffected;
    }

    
    //*
    //* Updates $item with $datas, according to $where - if $item unique, according to $where!"
    //* 

    function Sql_Update_Where_Unique($item,$where,$datas=array(),$table="")
    {
        $hash=$this->SelectUniqueHash($table,$uniquewhere);
        if (empty($hash) || empty($hash[ "ID" ])) { return FALSE; }
        
        return $this->Sql_Update_Where($item,$where,$datas,$table);
    }        

    //*
    //*
    //* Sets value of var $var of item with key $idvar $id in table $table. 
    //* Returns value set.
    //* 

    function Sql_Update_Item_Value_Set_It(&$item,$data,$value,$idvar="ID",$table="")
    {
        $item[ $data ]=$value;
        $this->Sql_Update_Item_Value_Set
        (
            $item[ $idvar ],
            $data,$value,
            $idvar,
            $table
        );
        
        /* ( */
        /*    $idvar, */
        /*    $item[ $idvar ], */
        /*    $data, */
        /*    $value, */
        /*    $table */
        /* ); */
    }
    
    //*
    //* Updates $item with column $data, according to $where - if $item unique, according to $where!"
    //* 

    function Sql_Update_Set_Column_Where_NOT_NULL($data,$value,$table="")
    {
        if (empty($table)) { $table=$this->SqlTableName(); }

        $res=NULL;
        if
            (
                $this->Sql_Table_Field_Exists($data,$table)
                &&
                !empty($value)
            )
        {
            $res=
                $this->Sql_Update_Where
                (
                    array($data => $value),
                    array
                    (
                        "__".$data."__"
                        =>
                        $this->Sql_Table_Column_Name_Qualify($data).
                        " IS NULL",
                    ),
                    array($data),
                    $table
                );
        }                

        return $res;
    }

}
?>