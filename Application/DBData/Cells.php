<?php

class DBDataCells extends DBDataPertains
{    
    //*
    //* function SqlKeyField, Parameter list: $data,$item,$edit,$rdata=""
    //*
    //* Returns sql key field, appends ok/not ok icon.
    //*

    function SqlKeyField($data,$item,$edit,$rdata="")
    {
        if (empty($rdata)) { $rdata=$data; }
        
        $icon="";
        $value="";

        if ($edit==1)
        {
            $value=
                $this->MyMod_Data_Fields_Edit($data,$item,$item[ $data ],"",TRUE,TRUE,FALSE,$rdata);
        }
        else
        {
            $value= 
                $this->MyMod_Data_Fields_Show($data,$item,FALSE,TRUE,FALSE);
        }

        $this->Sql_Select_Hash_Datas_Read($item,array("Unit","Event"));

        $inscriptiontable=$this->Unit("ID")."__".$item[ "Event" ]."_Inscriptions";
        if ($this->DBDataObj()->Sql_Table_Exists($inscriptiontable))
        {
            if ($this->DBDataObj()->Sql_Table_Field_Exists($item[ $data ],$inscriptiontable))
            {
                $icon=
                    $this->MyMod_Interface_Icon
                    (
                        'fas fa-thumbs-up',
                        array
                        (
                            "STYLE" => "color: green;",
                            "TITLE" => $item[ $data ].": Exists in SQL Table ".$inscriptiontable,
                        )
                    );
            }
            else
            {
                $args=$this->CGI_URI2Hash();
                $args[ "Action" ]="CreateTable";
                $icon=
                    $this->Htmls_Href
                    (
                        "?".$this->CGI_Hash2Uri($args),
                        $this->MyMod_Interface_Icon
                        (
                            'fas fa-thumbs-down',
                            array
                            (
                                "STYLE" => "color: red;",
                                "TITLE" => $item[ $data ].": Nonexistent  in SQL Table ".$inscriptiontable,
                            )
                        )
                    );
            }
        }
        else
        {
            $icon=
                $this->MyMod_Interface_Icon
                (
                    'fas fa-exclamation-triangle',
                    array
                    (
                        "STYLE" => "color: red;",
                        "TITLE" => $item[ $data ].": SQL Table ".$inscriptiontable." does not exist"
                    )
                );
        }
 
        return array($value,$icon);
    }

    //*
    //* function SqlDefField, Parameter list: $data,$item,$edit,$rdata=""
    //*
    //* Creates SqlDef field. Adds in table type, for debugging.
    //*

    function SqlDefField($data,$item,$edit,$rdata="")
    {
        if (empty($rdata)) { $rdata=$data; }
        
        if (empty($item[ $data ]))
        {
            $item[ $data ]="";
        }

        $value=array();
        if ($edit==1)
        {
            $value= 
                $this->MyMod_Data_Fields_Edit($data,$item,$item[ $data ],"",TRUE,TRUE,FALSE,$rdata);
        }
        else
        {
            $value= 
                $this->MyMod_Data_Fields_Show($data,$item,FALSE,TRUE,FALSE);
        }

        if (!is_array($value))
        {
            /* var_dump("Warning! function SqlDefField: \$value is not array"); */
            /* var_dump($value); */
            $value=array($value);
        }

        if (!empty($item[ $data ]))
        {
            $inscriptiontable=$this->DBDataObj()->SqlTableName();
            if ($this->DBDataObj()->Sql_Table_Exists($inscriptiontable))
            {
                if ($this->DBDataObj()->Sql_Table_Field_Exists($item[ "SqlKey" ],$inscriptiontable))
                {
                    $type=$this->DBDataObj()->Sql_Table_Column_Type($item[ "SqlKey" ],$inscriptiontable);

                    $sqldef=strtolower($item[ "SqlDef" ]);
                    $sqldef=preg_replace('/\)/',"\)",preg_replace('/\(/',"\(",$sqldef));

                    if ($item[ "SqlDef" ]=="FILE")
                    {
                        if (preg_match('/^VARCHAR\(\d+\)\(\d+\)$/i',$type))
                        {
                            array_push
                            (
                                $value,
                                "<BR>",
                                $this->MyMod_Interface_Icon
                                (
                                    'fas fa-thumbs-up',
                                    array
                                    (
                                        "STYLE" => "color: green;",
                                        "TITLE" => $item[ $data ]." Identical in SQL Table: ".$inscriptiontable
                                    )
                                ),
                                $type
                            );
                        }
                        else
                        {
                            array_push
                            (
                                $value,
                                "<BR>",
                                $this->MyMod_Interface_Icon
                                (
                                    'fas fa-exclamation-triangle',
                                    array
                                    (
                                        "STYLE" => "color: red;",
                                        "TITLE" => $item[ $data ]." Review! SQL Table ".$inscriptiontable
                                    )
                                ),
                                $type
                            );
                        }
                    }
                    elseif (
                              preg_match('/^'.$sqldef.'/',$type)
                              ||
                              ($sqldef=='enum' && $type=='int')
                           )
                    {
                        array_push
                        (
                            $value,
                            "<BR>",
                            $this->MyMod_Interface_Icon
                            (
                                'fas fa-thumbs-up',
                                array
                                (
                                    "STYLE" => "color: green;",
                                    "TITLE" => $item[ $data ]." Identical in SQL Table: ".$inscriptiontable
                                )
                            ),
                            $type
                        );
                    }
                    else
                    {
                        array_push
                        (
                            $value,
                            "<BR>",
                            $this->MyMod_Interface_Icon
                            (
                                'fas fa-exclamation-triangle',
                                array
                                (
                                    "STYLE" => "color: red;",
                                    "TITLE" => $item[ $data ]." Different in SQL Table: ".$inscriptiontable
                                )
                            ),
                            $type." vs. ".$sqldef
                        );
                    }
                 }
                else
                {
                    array_push
                    (
                        $value,
                        $this->MyMod_Interface_Icon
                        (
                            'fas fa-exclamation-triangle',
                            array
                            (
                                "STYLE" => "color: red;",
                                "TITLE" => $item[ $data ]." Nonexistent in SQL Table: ".$inscriptiontable
                            )
                        )
                    );
                }
            }
        }
        
        return $value;
    }

    //*
    //* function DBDataFormDetailsCell, Parameter list: $edit,$item
    //*
    //* Details cell.
    //*

    function DBDataFormDetailsCell($edit,$item)
    {
        return $this->ItemsForm_ItemDetailsCell($edit,$item);
         
    }

    //*
    //* function GetDetailsSGroups, Parameter list: $edit,$item
    //*
    //* Returns matrix of SGroups to include for detailed $item.
    //*

    function GetDetailsSGroups($edit,$item)
    {
        $groupsm=array
        (
            array
            (
               "Basic" => $edit,
               "SQL" => $edit,
            ),
            array
            (
               "Permissions" => $edit,
               "CSS" => $edit,
            ),
        );

        $type=$this->GetEnumValue("Type",$item);
        if (!empty($this->ItemDataSGroups[ $type ]))
        {
            array_push
            (
               $groupsm,
               array
               (
                  $type => $edit,
               )
            );
        }

        return $groupsm;
    }
}


?>