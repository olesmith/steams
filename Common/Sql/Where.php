<?php


trait Sql_Where
{
    //*
    //* SQL where clase for $date.
    //*

    function Sql_Where_GT($data,$value="0")
    {
        return
            $this->Sql_Table_Column_Name_Qualify($data).
            ">".
            $this->Sql_Table_Column_Value_Qualify($value).
            "";
    }
    
    //*
    //* SQL where clase for $date.
    //*

    function Sql_Where_Zero_Or_NULL($data,$value="0")
    {
        return
            "(".
            $this->Sql_Table_Column_Name_Qualify
            (
                $data
            ).
            " IS NULL OR ".
            $this->Sql_Table_Column_Name_Qualify
            (
                $data
            ).
            "=".
            $this->Sql_Table_Column_Value_Qualify($value).
            ")";
    }
    
    //*
    //* SQL where clase for $date.
    //*

    function Sql_Where_Ors($ors)
    {
        $where=join(" OR ",$ors);
        if (count($ors)>1)
        {
            $where="(".$where.")";
        }

        return $where;
    }

    //*
    //* SQL where clase for $date.
    //*

    function Sql_Times_Condition($mtime1,$mtime2)
    {
        return " (CTime>='".$mtime1."' AND CTime<'".$mtime2."') ";
    }

    //*
    //* Formats where clause IN $values component.
    //* 

    function Sql_Where_IN($values)
    {
        if (empty($values)) { return ""; }

        //Remove empty values
        foreach ($values as $id => $value)
        {
            if (empty($value)) { unset($values[ $id ]); }
        }

        if (empty($values)) { return ""; }
        
        return
            "IN (".
            $this->Sql_Table_Column_Values_Qualify($values).
            ")";
        
    }

    //*
    //* Reverse: SqlClause2Hash.
    //* 

    function Hash2SqlWhere($hash,$pre="")
    {
        $where="";
        if (is_array($hash))
        {
            $wheres=array();
            foreach ($hash as $key => $value)
            {
                $prekey=$this->Sql_Table_Column_Name_Qualify($pre.$key);

                if (empty($value)) { continue; }
                
                if (is_array($value))
                {
                    if (isset($value[ "Qualifier" ]))
                    {
                        array_push
                        (
                           $wheres,
                           $prekey.
                           " ".$value[ "Qualifier" ]." ".$value[ "Values" ]
                        );
                    }
                    elseif (count($value)>0)
                    {
                        array_push
                        (
                           $wheres,
                           $prekey.
                           " IN (".
                           $this->Sql_Table_Column_Values_Qualify($value).
                           ")"
                        );
                    }
                }
                elseif (preg_match('/^__/',$key))
                {
                    array_push($wheres,$value);
                }
                elseif (preg_match('/\s*IN\s/i',$value))
                {
                    array_push($wheres,$prekey." ".$value);
                }
                elseif (preg_match('/^\(.+\)$/',$value))
                {
                    array_push($wheres," ".$value);
                }

                
                elseif (preg_match('/\s*\!=\s*(\S+)/i',$value,$matches))
                {
                    array_push($wheres,$prekey."!!!=".$matches[1]);
                }
                elseif (preg_match('/\s+LE\s+(\S+)/i',$value,$matches))
                {
                    array_push($wheres,$prekey."<=".$matches[1]);
                }
                elseif (preg_match('/\s+LT\s+(\S+)/i',$value,$matches))
                {
                    array_push($wheres,$prekey."<".$matches[1]);
                }
                elseif (preg_match('/\s+GT\s+(\S+)/i',$value,$matches))
                {
                    array_push($wheres,$prekey.">".$matches[1]);
                }
                elseif (preg_match('/\s+GE\s+(\S+)/i',$value,$matches))
                {
                    array_push($wheres,$prekey.">=".$matches[1]);
                }
                elseif (preg_match('/\s+OR\s+(\S+)/',$value,$matches))
                {
                    array_push($wheres,"(".$value.")");
                }

                //Doesn't work, did above
                elseif (preg_match('/(>=?)\s/',$value,$matches))
                {
                    array_push($wheres,$prekey.$matches[1].$value);
                }
                elseif (preg_match('/(<=?)\s/',$value))
                {
                    array_push($wheres,$prekey.$matches[1].$value);
                }
                elseif (preg_match('/([%_])/i',$value))
                {
                    if (!preg_match('/\bLIKE\b/i',$value))
                    {
                        array_push
                        (
                            $wheres,
                            $prekey.
                            " LIKE ".
                            $this->Sql_Table_Column_Value_Qualify($value).
                            ""
                        );
                    }
                    else
                    {
                        array_push
                        (
                            $wheres,
                            $prekey." ".$value
                        );
                    }
                }
                else
                {
                    array_push
                    (
                        $wheres,
                        $prekey.
                        "=".
                        $this->Sql_Table_Column_Value_Qualify($value).
                        ""
                    );
                }
            }

            $where=join(" AND ",$wheres);
        }

        return $where;
    }
    
    //*
    //* Returns Sql ORs, looping over $datas valued $value. 
    //*
    //* 

    function Sql_Where_Data_Ors($datas,$value)
    {
        $ors=array();
        foreach ($datas as $data)
        {
            array_push
            (
               $ors,
               $data.
               "=".
               $this->Sql_Table_Column_Value_Qualify($value)
            );        
        }

        return "(".join(" OR ",$ors).")";
    }
    
    //*
    //* Creates and SQL query from a hash. Primary key list are
    //* converted to AND clauses - if values are scalars,
    //* just a simple key=val - if values are arrays,
    //* these converts to OR clauses. Fx:
    //* 
    //* Key1 => val1,
    //* Key2 => array(
    //*  val21,
    //*  val22
    //* )
    //*
    //* Converts to:
    //*
    //* Key1='val1' AND (Key2='val21' OR Key2='val22')
    //*

    function Sql_Where_From_Hash($argshash)
    {
        if (!is_array($argshash))
        {
            $argshash=$this->SqlClause2Hash($argshash);
        }

        $ands=array();
        foreach ($argshash as $arg => $value)
        {
            if (preg_match('/^_/',$arg))
            {
                if (!is_array($value)) { $value=array($value); }
                $ands=array_merge($ands,$value);
            }
            elseif (is_array($value))
            {
                $ors=array();
                foreach ($value as $id => $rvalue)
                {
                    if (preg_match('/(LIKE|OR)\b/i',$rvalue))
                    {
                        array_push
                        (
                            $ors,
                            $rvalue
                        );
                    }
                    else
                    {
                        array_push
                        (
                            $ors,
                            $this->Sql_Table_Column_Name_Qualify($arg).
                            "=".
                            $this->Sql_Table_Column_Value_Qualify($rvalue)
                        );
                    }
                }

                $ors=join(" OR ",$ors);
                if (count($value)>1)
                {
                    $ors="(".$ors.")";
                }
                array_push($ands,$ors);
            }
            elseif (!preg_match('/\s*(NULL|LIKE|IN)\s/i',$value))
            {
                array_push
                (
                    $ands,
                    $this->Sql_Table_Column_Name_Qualify($arg).
                    "=".
                    $this->Sql_Table_Column_Value_Qualify($value)
                );
            }
            else
            {
                array_push
                (
                    $ands,
                    $this->Sql_Table_Column_Name_Qualify($arg).
                    " ".
                    $value
                );
            }
        }

        return join(" AND ",$ands);
    }

}
?>