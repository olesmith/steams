<?php


trait MyMod_Search_Wheres
{
    //*
    //* Adds search vars to $where.
    //*

    function MyMod_Search_Where($where=array(),$datas=array(),$nosearches=FALSE,$includeall=1)
    {
        if ($this->NoSearches) { $nosearches=$this->NoSearches; }

        if ($this->MyMod_Search_CGI_Vars_Defined_Has()) { $nosearches=FALSE; }
        $nosearches=False; //???
        
        $searchwhere="";
        if (!$nosearches && $includeall!=2)
        {
            $searchwhere=$this->MyMod_Search_Vars_Where();
        }
        
        if ($includeall!=2)
        {
            foreach ($where as $key => $value)
            {
                $searchwhere[ $key ]=$value;
            }

        }

        //31/01/2020: Correcting regexp addkey problem
        if (is_array($searchwhere))
        {
            foreach (array_keys($searchwhere) as $data)
            {
                if (!is_array($searchwhere[ $data ]))
                {
                    if (preg_match('/^\S+=\'lower\(/',$searchwhere[ $data ]))
                    {
                        $searchwhere[ $data ]=
                            preg_replace
                            (
                                '/^\S+=\'lower\(/',
                                "lower(",
                                $searchwhere[ $data ]
                            );
                
                        $searchwhere[ $data ]=
                            preg_replace
                            (
                                '/\'$/',
                                "",
                                $searchwhere[ $data ]
                            )."'";
                    }
                }
            }
            
        }

        return $searchwhere;
    }
    
    //*
    //* function MyMod_Search_Vars_Where, Parameter list: $searchvars=array()
    //*
    //* Search vars to search values;
    //*

    function MyMod_Search_Vars_Where($searchvars=array())
    {
        $values=$this->MyMod_Search_Vars_Pre_Where();
        if (count($searchvars)==0)
        {
            $searchvars=array_keys($values);
        }
 
        $wheres=array();
        foreach (array_keys($this->ItemData) as $data)
        {
            $get_key=$this->ItemData($data,"GETSearchVarName");
            if (!empty($get_key))
            {
                $get_value=$this->CGI_GETint($get_key);
                if (!empty($_GET[ $get_key ]))
                {
                    $wheres[ $data ]=$get_value;
                    $add_zero_key=False;//$this->ItemData($data,"GETAddZero");

                    if (!empty($add_zero_key))
                    {
                        $wheres[ $data ]=array(0,$get_value);
                    }
                            
                    //array_push($this->NonGetVars,$data);
                }
            }
        }
       
        foreach ($searchvars as $id => $data)
        {
            $where=$this->MyMod_Search_Var_Where($data,$values[ $data ]);
            if (!empty($where))
            {
                if (!is_array($where))
                {
                    if (preg_match('/\b(R?LIKE|REGEXP_?|SIMILAR\s+TO)/i',$where))
                    {
                        //04/02/2020: Corrected regexp removing erroneous $data=$data
                        $where=
                            preg_replace
                            (
                                //Leading $data='
                                '/^[\'"]?'.$data.'[\'"]?=?\s*[\'"]/',
                                "",
                                $where
                            );

                        if ($this->DB_MySql())
                        {
                            $where=
                                preg_replace
                                (
                                    //Trailing '
                                    '/[\'"]$/',"",
                                    $where
                                );
                        }
                        
                    }
                    //else { var_dump("MATCH",$where); }
                    
                }
            }
            
            $rdata=$this->MyMod_Search_Var_Data($data,$where);           
            if (!empty($where))
            {
                 $wheres[ $rdata ]=$where;
            }
        }

        return $wheres;
    }
    
    //*
    //* function MyMod_Search_Var_Data, Parameter list: $data,$datavalues=array()
    //*
    //* Generates pre sql search vars where, for var $data.
    //*

    function MyMod_Search_Var_Data($data,$datavalues=array())
    {
        $rdata=$data;
        if (!empty($this->ItemData[ $data ][ "SqlMethod" ]))
        {
            $rdata="__".$data;
        }
        elseif ($this->MyMod_Data_Field_Is_Enum($data))
        {
        }
        elseif ($this->MyMod_Data_Field_Is_Time($data))
        {
            $rdata="__".$data;
        }
        elseif (preg_match('/^(ENUM|INT)$/i',$this->ItemData[ $data ][ "Sql" ]))
        {
            if (!is_array($datavalues))
            {
                if (preg_match('/IS\s+(NOT\s+)?NULL/i',$datavalues))
                {
                    $rdata="__".$data;
                }
            }
        }
        elseif ($this->ItemData[ $data ][ "SearchCompound" ])
        {
        }
        else
        {
            $rdata="__".$data;
            if (is_array($datavalues))
            {
            }
            elseif (!preg_match('/LIKE/',$datavalues))
            {
            }
        }

        return $rdata;
    }

    
    //*
    //* function MyMod_Search_Var_Where, Parameter list: $data,$datavalues=array()
    //*
    //* Generates pre sql search vars where, for var $data.
    //*

    function MyMod_Search_Var_Where($data,$datavalues=array(),$rdata="")
    {
        if (empty($rdata)) { $rdata=$data; }
        
        if ($this->MyMod_Search_CGI_Zero_Value($data))
        {
            return
                "(".
                $this->Sql_Table_Column_Name_Qualify($data).
                " IS NULL OR ".
                $this->Sql_Table_Column_Name_Qualify($data).
                "='0'".
                ")";
        }

        elseif ($this->MyMod_Search_CGI_Def_Value($data))
        {
            return
                "(".
                $this->Sql_Table_Column_Name_Qualify($data).
                " IS NOT NULL AND ".
                $this->Sql_Table_Column_Name_Qualify($data).
                ">'0'".
                ")";
        }

        if (preg_match('/^(ENUM|INT)$/i',$this->ItemData[ $data ][ "Sql" ]))
        {
            if (!is_array($datavalues))
            {
                $datavalues=preg_replace('/[\(\)]/',"",$datavalues);
                $datavalues=preg_split('/\s*,\s*/',$datavalues);
            }
            $add_zero_key=$this->ItemData($data,"GETAddZero");

            if (!empty($add_zero_key))
            {
                array_push($datavalues,0);
            }
        }

        $where="";
        if (!empty($this->ItemData[ $data ][ "SqlMethod" ]))
        {
            $method=$this->ItemData[ $data ][ "SqlMethod" ];
            $where=$this->$method($data,$datavalues,$rdata);
        }
        elseif ($this->MyMod_Data_Field_Is_Enum($data))
        {
            if ($this->ItemData[ $data ][ "SearchCheckBox" ])
            {
                if (!empty($datavalues))
                {
                    $where=$datavalues;
                }
            }
            else
            {
                $where=$datavalues;
            }
        }
        elseif ($this->MyMod_Data_Field_Is_File($data))
        {
            if (!empty($datavalues))
            {
                $where=
                    $this->Sql_Table_Column_Name_Qualify($data).
                    "<>".
                    $this->Sql_Table_Column_Value_Qualify('');
            }
        }
        elseif ($this->MyMod_Data_Field_Is_Time($data))
        {
            
            if (count($datavalues)>1)
            {
                $ands=array();
                sort($datavalues,SORT_NUMERIC);
                
                $tdata=$this->ModuleName;
                $colname=$this->Sql_Table_Column_Name_Qualify($data);
                
                $field="From";
                if ($this->MyMod_Search_Field_Time_Field_Checked($field,$data,$tdata))
                {
                    $value=array_shift($datavalues);
                    
                    array_push
                    (
                        $ands,
                        $colname.
                        ">=".
                        $this->Sql_Table_Column_Value_Qualify($value)
                    );
                }
                
                $field="To";
                if ($this->MyMod_Search_Field_Time_Field_Checked($field,$data,$tdata))
                {
                    $value=array_shift($datavalues);
                    
                    array_push
                    (
                        $ands,
                        $colname.
                        "<=".
                        $this->Sql_Table_Column_Value_Qualify($value)
                    );
                }

                if (count($ands)>0)
                {
                    $where=
                        "(".
                        join(" AND ",$ands).
                        ")";
                }
                else
                {
                    $where=array();
                }
            }
            else { $where=$datavalues; }
        }
        elseif (preg_match('/^(ENUM|INT)$/i',$this->ItemData[ $data ][ "Sql" ]))
        {
            //$datavalues=preg_grep('/^\s*0$/',$datavalues,PREG_GREP_INVERT);
            //$datavalues=preg_grep('/\S/',$datavalues);
            if (!empty($datavalues))
            {
                $where=$datavalues;
            }            
        }
        elseif ($this->ItemData[ $data ][ "SearchCompound" ])
        {
            if (!empty($this->ItemData[ $data ][ "Var" ]))
            {
                $var=$this->ItemData[ $data ][ "Var" ];

                $ors=array();
                for ($i=1;$i<=$this->ItemData[ $data ][ "NVars" ];$i++)
                {
                    array_push
                    (
                        $ors,
                        $this->Sql_Table_Column_Name_Qualify($var).$i.
                        "='".$datavalues."'"
                    );
                }
            }
            elseif (!empty($this->ItemData[ $data ][ "Vars" ]))
            {
                foreach ($this->ItemData[ $data ][ "Vars" ] as $var)
                {
                    array_push
                    (
                        $ors,
                        $this->Sql_Table_Column_Name_Qualify($var).
                        "='".$datavalues."'"
                    );
                }
            }

            $where=$this->Sql_Where_Ors($ors);
        }
        else
        {
            if (is_array($datavalues))
            {
                if (count($datavalues)>0)
                {
                    $ors=array();
                    foreach ($datavalues as $no => $val)
                    {
                        $or=$val;
                        if (!preg_match('/\bLIKE\b/',$val))
                        {
                            $or=
                                $this->Sql_Table_Column_Name_Qualify($rdata).
                                "=".
                                $this->Sql_Table_Column_Value_Qualify($val);
                        }

                        array_push($ors,$or);
                    }

                    $where=$this->Sql_Where_Ors($ors);
                }
            }
            elseif (!preg_match('/LIKE/',$datavalues))
            {
                $datavalues=preg_replace('/\s+/',".*",$datavalues);

                $datavalues=strtolower($datavalues);

                if (preg_match('/[_%]/',$datavalues))
                {
                    $where=
                        $this->MyMod_Search_Var_Where_Regexp_String
                        (
                            $data,$datavalues,$rdata
                        );
                }
                elseif (!preg_match('/LIKE/',$datavalues))
                {
                    if (!preg_match('/INT/',$this->ItemData[ $data ][ "Sql" ]))
                    {
                        $where=
                            $this->MyMod_Search_Var_Where_Regexp_String
                            (
                                $data,$datavalues,$rdata
                            );
                    }
                    else
                    {
                        $where=$datavalues;
                    }
                }

                if (!empty($this->ItemData[ $data ][ "Languaged" ]))
                {
                    $rwheres=array($where);
                    foreach ($this->MyMod_Languaged_Data_Get($data) as $langdata)
                    {
                         array_push
                        (
                            $rwheres,
                            preg_replace('/lower\('.$data.'\)/','lower('.$langdata.')',$where)
                        );
                    }
                    
                    foreach ($this->MyMod_Languaged_Data_Get($rdata) as $langdata)
                    {
                         array_push
                        (
                            $rwheres,
                            preg_replace('/lower\('.$rdata.'\)/','lower('.$langdata.')',$where)
                        );
                    }

                    $where=$this->Sql_Where_Ors($rwheres);
                }
            }
            else
            {
                $where=$datavalues;         
            }
        }
 
        return $where;
    }

    //*
    //* SQL string for regexp comparison.
    //*

    function MyMod_Search_Var_Where_Regexp_String($data,$datavalues,$rdata="")
    {
        if (empty($rdata)) { $rdata=$data; }        
        
        return
            "lower(".
            $this->Sql_Table_Column_Name_Qualify($rdata).
            ")".
            " ".
            $this->MyMod_Search_Var_Where_Regexp_LIKE($datavalues).
            "";
    }

    
    //*
    //* Generates pre sql search vars where, for var $data.
    //*

    function MyMod_Search_Var_Where_Regexp_LIKE($datavalues)
    {
        return
            $this->DB_Regexp_Operator().
            " ".
            $this->Sql_Table_Column_Value_Qualify
            (
                $this->MyMod_Search_Var_Where_Regexp_Apply($datavalues)
            );
    }

    //*
    //* Generates pre sql search vars where, for var $data.
    //*

    function MyMod_Search_Var_Where_Regexp_Apply($datavalues)
    {
        $datavalues=preg_replace('/\s+/',"%",$datavalues);
        if (preg_match('/^\^/',$datavalues))
        {
            $datavalues=preg_replace('/^\^/',"",$datavalues);
            return $datavalues.".*";
        }
        
        if (preg_match('/\$$/',$datavalues))
        {
            $datavalues=preg_replace('/\$$/',"",$datavalues);
            return ".*".$datavalues;
        }
        
        $sep=".*";
        if ($this->DB_PostGres())
        {
            $sep="%";
        }

        return
            $sep.
            $datavalues.
            $sep.
            "";
    }
    
}

?>