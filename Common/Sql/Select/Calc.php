<?php


trait Sql_Select_Calc
{
    //*
    //* Calc entries $field value, conforming to $where, in table $table.
    //* 

    function Sql_Select_Calc($where,$fields,$function="Sum",$table="")
    {
        if (!$this->Sql_Table_Exists($table)) { return 0; }
        
        $single=FALSE;
        if (!is_array($fields)) { $fields=array($fields); $single=TRUE; }

        $res=
            $this->DB_Query_2Assoc_List
            (
                $this->Sql_Select_Calc_Query
                (
                    $where,$fields,$function,$table
                )
            );

        //$res should contain one entry
        if (!empty($res)) { $res=array_shift($res); }
                
        $result=array();
        foreach ($fields as $field)
        {
            $rfield=
                $this->Sql_Select_Calc_Field_As($function,$field);

            if (isset($res[ $rfield ]))
            {
                $result[ $field ]=$res[ $rfield ];
            }
        }

        /* if ($this->DB_MySql()) */
        /* { */
        /*     var_dump */
        /*     ( */
        /*         "20200601: SELECT_CALC with MySQL: Should test!!", */
        /*         $this->Sql_Select_Calc_Query */
        /*         ( */
        /*             $where,$fields,$function,$table */
        /*         ), */
        /*         $where,$fields,$res,$result */
        /*     ); */
        /* } */
        
        if ($single) { $result=array_shift($result); }
        return $result;
    }
    
    //*
    //* Calc entries $field value, conforming to $where, in table $table.
    //*

    function Sql_Select_Calc_Field_As($function,$field)
    {
        return
            $function.
            "_".
            $field.
            "";
    }
    
    //*
    //* Calc entries $field value, conforming to $where, in table $table.
    //*

    function Sql_Select_Calc_As()
    {
        return " as ";
        
        /* $res=" as "; */
        /* if ($this->DB_PostGres()) */
        /* { */
        /*     $res=" as "; */
        /* } */

        /* return $res; */
    }
    
    //*
    //* Calc entries $field value, conforming to $where, in table $table.
    //*
    //* 

    function Sql_Select_Calc_Query($where,$fields,$function="Sum",$table="")
    {
        if (is_array($where)) { $where=$this->Hash2SqlWhere($where); }
        if (empty($table)) { $table=$this->SqlTableName(); }
        if (!is_array($fields)) { $fields=array($fields); }
        
        foreach (array_keys($fields) as $id)
        {
            $fields[ $id ]=
                $function.
                "(".
                $this->Sql_Table_Column_Name_Qualify($fields[ $id ]).
                ")".
                $this->Sql_Select_Calc_As().
                $this->Sql_Table_Column_Name_Qualify
                (
                    $this->Sql_Select_Calc_Field_As($function,$fields[ $id ])
                );
            
        }
        
        $query=
            'SELECT '.
            join(",",$fields).
            ' FROM '.
            $this->Sql_Table_Name_Qualify($table);
                                                 
        if (preg_match('/\S/',$where)) { $query.=' WHERE '.$where; }
       
        return $query;
    }
    
 
    //*
    //* Sums entries $field value, conforming to $where, in table $table.
    //*
    //* 

    function Sql_Select_Calcs($wheres,$fields,$function="Sum",$table="")
    {
        if (!$this->Sql_Table_Exists($table)) { return array(); }

        $counts=array();
        
        foreach ($wheres as $wid => $where)
        {
            $counts[ $wid ]=$this->Sql_Select_Calc($where,$fields,$function,$table);
        }
        
        return $counts;
    }
    
   //*
    //* Add NOT NULL clauses.
    //*
    //* 

    function Sql_Select_Calc_NOT_NULLs(&$where,$fields)
    {
        if (!is_array($fields)) { $fields=array($fields); }
        
        foreach (array_keys($fields) as $id)
        {
            $where[ "__NULL_".$id ]=
                $this->Sql_Table_Column_Name_Qualify($fields[ $id ]).
                " IS NOT NULL";
        }
    }
    
     //*
    //* Calc Max entry value of  $field, conforming to $where, in table $table.
    //*
    //* 

    function Sql_Select_Max($where,$fields,$table="")
    {
        $this->Sql_Select_Calc_NOT_NULLs($where,$fields);

        return $this->Sql_Select_Calc($where,$fields,"Max",$table);
    }
    
    //*
    //* Calc Min entry value of  $field, conforming to $where, in table $table.
    //*
    //* 

    function Sql_Select_Min($where,$fields,$table="")
    {
        $this->Sql_Select_Calc_NOT_NULLs($where,$fields);          

        return $this->Sql_Select_Calc($where,$fields,"Min",$table);
    }
}
?>