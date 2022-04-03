<?php

trait MyMod_Data_Fields_Sql
{
    //*
    //* Returns sql where clause associated with $data.
    //*

    function MyMod_Data_Fields_Sql_Where($data,$value)
    {
        $where=array();
        if (!empty($this->SqlWhere[ $data ]))
        {
            $where[ $data ]=$this->SqlWhere[ $data ];
        }
        elseif (!empty($this->SqlWhere_Search[ $data ]))
        {
            $where[ $data ]=$this->SqlWhere_Search[ $data ];
        }

        return $where;
    }

    //*
    //* Generates search field for SQL object.
    //*

    function MyMod_Data_Fields_Sql_Search_Select($data,$rdata,$value)
    {
        if
            (
                empty($_POST[ $rdata ])
                &&
                $this->ItemData[ $data ][ "GETSearchVarName" ]
                &&
                !preg_match('/^Admin$/',$this->Profile())
            )
        {
            $getvalue=$this->CGI_GETint($this->ItemData[ $data ][ "GETSearchVarName" ]);
            if (!empty($getvalue))
            {
                if (empty($value))
                {
                    $value=$getvalue;
                }
            }
        }

        //Where clause in $data submodule sql table
        $where=
            $this->MyMod_Data_Fields_Sql_Where($data,$value);
        
        if (!is_array($where)) { $where=$this->Hash2SqlWhere($where); }

        //Get values present in table.
        $colvalues=
            $this->Sql_Select_Unique_Col_Values
            (
                $data,
                $where
            );
        
        $colvalues=preg_grep('/^\d+$/',$colvalues);
        //Exclude zero value
        $colvalues=preg_grep('/[1-9]/',$colvalues);
        
        if (!empty($colvalues))
        {
            $where[ "ID" ]=$colvalues;
        }

        
        $datas=$this->MyMod_Data_Fields_Module_Datas($data);
        $datas=preg_grep('/^ID$/',$datas,PREG_GREP_INVERT);
        array_push($datas,"ID");

        $hashes=array();
        if (count($colvalues)==0)
        {
            return "";
        }
        elseif (!empty($this->ItemData[ $data ][ "SqlTables_Regex" ]))
        {
            $class=$this->ItemData[ $data ][ "SqlClass" ];
            
            $hashes=
                $this->Module2Object($data)->Sql_Tables_Select_Hashes
                (
                   $this->ItemData[ $data ][ "SqlTables_Regex" ],
                   $where,
                   $datas
                );
        }
        elseif (!empty($this->ItemData[ $data ][ "Search_Vars" ]))
        {
            $class=$this->ItemData[ $data ][ "SqlClass" ];
            $sqltable=$this->ApplicationObj()->SubModulesVars[ $class ][ "SqlTable" ];

            foreach ($this->ItemData[ $data ][ "Search_Vars" ] as $searchvar)
            {
                $sqltable=
                    preg_replace
                    (
                       '/#'.$searchvar.'/',
                       $this->MyMod_Search_CGI_Value($searchvar),
                       $sqltable
                    );
            }
            
            $hashes=
                $this->Module2Object($data)->Sql_Select_Hashes
                (
                   $where,
                   $datas,
                   "",FALSE,
                   $sqltable
                );
        }
        else
        {
            if (!empty($where[ $data ]))
            {
                #$where[ "ID" ]=$where[ $data ];
                unset($where[ $data ]);
            }
            
            $class=$this->ItemData[ $data ][ "SqlClass" ];
            if (
                   !empty($this->ItemData[ $data ][ "SqlClass" ])
                   &&
                   method_exists($this->Module2Object($data),"SqlWhere")
                )
            {
                 if (!is_array($where))
                 {
                     $where=$this->SqlClause2Hash($where);
                 }

                 $where=
                     array_merge
                     (
                         $where,
                         $this->Module2Object($data)->SqlWhere(array($data => $value))
                     );
             }

            $hashes=
                $this->Module2Object($data)->Sql_Select_Hashes
                (
                   $where,
                   $datas,
                   //Submodule Sort
                   join(",",$this->Module2Object($data)->Sort)
                   //previous
                   //join(",",$this->ApplicationObj()->SubModulesVars[ $class ][ "SqlDerivedData" ])
                );
        }

        $rvalue=
            $this->Htmls_Select_Hashes_Field
            (
                $this->MyMod_Search_CGI_Name($data),
                $this->MyMod_Data_Fields_Module_SubItems_2Options
                (
                    $data,
                    $this->MyMod_Sort_List($hashes,$datas)
                ),
                array
                (
                    "Selected"  => $value,
                    "Name_Key"  => "Name",
                    "Title_Key" => "Title",
                    "ID_Key"    => "ID",
                ),
                $this->MyMod_Data_Fields_Sql_Search_Select_Options
                (
                    $data,$rdata,$value,
                    $hashes
                )
            );
        
        if
            (
                $this->ItemData[ $data ][ "SqlTextSearch" ]
                &&
                empty($value)
            )
        {
            $rvalue=
                array
                (
                    $value,
                    $this->MyMod_Search_Field_Text($data)
                );
        }
        else
        {
            /* $rvalue=preg_replace */
            /* ( */
            /*    '/NAME=\''.$data.'\'/', */
            /*    "NAME='".$rdata."'", */
            /*    $rvalue */
            /* ); */
        }
        
        return $rvalue;
    }
    
    //*
    //* Generates select  options
    //*

    function MyMod_Data_Fields_Sql_Search_Select_Options($data,$rdata,$value,$hashes)
    {
        $options=
            array
            (
                "TITLE" => count($hashes)." ".$this->MyMod_Data_2Module($data)->MyMod_ItemsName(),
            );
        
        if (count($hashes)<=1)
        {
            $options[ "DISABLED" ]=0;
        }

        return $options;
    }
    
    //*
    //* Read subitem $datas.
    //*

    function MyMod_Data_Fields_Sql_SubItems_Read(&$items,$datas)
    {
        foreach ($datas as $data)
        {
            $this->MyMod_Data_Fields_Sql_SubItems_Read_Data($items,$data);
        }
    }
    
    //*
    //* Read subitem $data.
    //*

    function MyMod_Data_Fields_Sql_SubItems_Read_Data(&$items,$data)
    {
        if ($this->MyMod_Data_Field_Is_Sql($data))
        {
            $values=$this->MyHash_HashesList_Values($items,$data);
            $module=$this->MyMod_Data_Field_Sql_2_Module($data)."Obj";

            if (!empty($values))
            {
                $subitems=
                    $this->$module()->Sql_Select_Hashes_ByID
                    (
                        array
                        (
                            "ID" => $values,
                        ),
                        $this->MyMod_Data_Fields_Sql_SubItems_Data
                        (
                            $items,
                            $data
                        )
                    );

                foreach (array_keys($items) as $id)
                {
                    if (!empty($items[ $id ][ $data ]))
                    {
                        $subitemid=$items[ $id ][ $data ];
                        if (!empty($subitems[ $subitemid ]))
                        {
                            $items[ $id ][ $data."_ID" ]=$subitemid;
                            $items[ $id ][ $data ]=
                                $this->Filter
                                (
                                    $this->MyMod_Data_2ModuleKey($data,"SqlFilter"),
                                    $subitems[ $subitemid ]
                                );
                            
                        }
                    }
                }
            }
            
        }
    }
    
    //*
    //* Subitem $data to read
    //*

    function MyMod_Data_Fields_Sql_SubItems_Data($items,$data)
    {
        $datas=array();
        
        $submodule=$this->MyMod_Data_Field_Sql_2_Module($data);

        if (!empty($this->ItemData[ $data ][ "SqlDerivedData" ]))
        {
            $datas=$this->ItemData[ $data ][ "SqlDerivedData" ];
        }
        elseif
            (
                !empty
                (
                    $this->ApplicationObj()->SubModulesVars
                    [ $submodule ][ "SqlDerivedData" ]
                )
            )
        {
            $datas=
                $this->ApplicationObj()->SubModulesVars
                [ $submodule ][ "SqlDerivedData" ];
        }

        array_unshift($datas,"ID");

        return $datas;
        
    }
}

?>