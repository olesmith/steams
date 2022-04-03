<?php


trait MyMod_Data_Fields_Show
{
    //*
    //* Generates data Info field, returns .
    //*

    function MyMod_Data_Field_Info($data)
    {
        $value=$this->ItemData[ $data ][ "Info" ];

        if (preg_match('/^http(s)?:\/\//',$value))
        {
            $value=$this->A($value,$value);
        }

        return $value;
    }
    
    //*
    //* Generates data show field.
    //*

    function MyMod_Data_Fields_Show($data,$item,$plural=FALSE,$iconify=TRUE,$callmethod=TRUE,$options=array())
    {
        $this->ItemData($data);

        $value="";
        if (isset($item[ $data."_Orig" ]))
        {
            $value=$item[ $data."_Orig" ];
        }
        elseif (isset($item[ $data ]))
        {
            $value=$item[ $data ];
        }
        elseif (isset($item[ $data."_ID" ]))
        {
            $value=$item[ $data."_ID" ];
        }
                
        
        if (empty($this->ItemData[ $data ]))
        {
            $this->DoDie("No such ItemData defined",$this->ModuleName,$data,$this->ItemData);
        }
 
        if (!empty($this->ItemData[ $data ][ "Format" ]))
        {
            $value=sprintf($this->ItemData[ $data ][ "Format" ],$value);
        }
       
        if (!empty($this->ItemData[ $data ][ "HRefIt" ]))
        {
            if (!empty($value) && !preg_match('/^(https?):/i',$value))
            {
                $value="http://".$value;
            }
        }
      
        if (preg_match('/^(VAR)?CHAR/',$this->ItemData[ $data ][ "Sql" ]))
        {
            if (!empty($this->ItemData[ $data ][ "TrimCase" ]))
            {
                $value=$this->TrimCase($value);
                $item[ $data ]=$value;
            }
            elseif (!empty($this->ItemData[ $data ][ "ToUpper" ]))
            {
                $value=strtoupper($value);
                $item[ $data ]=$value;
            }
            elseif (!empty($this->ItemData[ $data ][ "ToLower" ]))
            {
                $value=strtolower($value);
                $item[ $data ]=$value;
            }
        }

        $access=$this->MyMod_Data_Access($data,$item);
        if ($access<1)
        {
            return "forbidden";
        }

        if (!empty($this->ItemData[ $data ][ "ConditionalShow" ]))
        {
            $fieldmethod=$this->ItemData[ $data ][ "ConditionalShow" ];

            $res=$this->$fieldmethod($data,$item,$plural);

            if (!empty($res)) { return $res; }
        }


        $fieldmethod="";
        if (!empty($this->ItemData[ $data ][ "FieldMethod" ]))
        {
            $fieldmethod=$this->ItemData[ $data ][ "FieldMethod" ];
        }
        if (!empty($this->ItemData[ $data ][ "ShowFieldMethod" ]))
        {
            $fieldmethod=$this->ItemData[ $data ][ "ShowFieldMethod" ];
        }

        if ($callmethod && !empty($fieldmethod))
        {
            if (!method_exists($this,$fieldmethod))
            {
                die("No such field method: ".$this->ModuleName.": ".$fieldmethod);
            }

            return $this->$fieldmethod($data,$item,0,$data);
        }
        elseif (preg_match('/^REAL$/i',$this->ItemData[ $data ][ "Sql" ]))
        {
            $format="%.2f";
            if (!empty($this->ItemData[ $data ][ "Format" ]))
            {
                $format=$this->ItemData[ $data ][ "Format" ];
            }
            
            $value=0.0;
            if (!empty($item[ $data ]))
            {
                $value=$item[ $data ];
            }
            return sprintf($format,$value);
        }
        elseif (!empty($this->ItemData[ $data ][ "IsBarcode" ]))
        {
            return $this->MyMod_Data_Fields_Barcode_Field($data,$item,0);
        }
        elseif (!empty($this->ItemData[ $data ][ "Info" ]))
        {
            return $this->MyMod_Data_Field_Info($data);
        }
        elseif (
                  $this->ItemData[ $data ][ "Sql" ]=="TEXT"
                  ||
                  (
                     !empty($this->ItemData[ $data ][ "Size" ])
                     &&
                     preg_match('/\d+x\d+/',$this->ItemData[ $data ][ "Size" ])
                  )
               )
        {
            $value=$this->MyMod_Data_Fields_Text_Show($data,$item,$value);
            $value=html_entity_decode($value);

            //$size=preg_split('/\s*x\s*/',$this->ItemData[ $data ][ "Size" ]);
            //$rows=50;
            //if (count($size)>0) { $rows=$size[0]."px"; }
        
            /* $value= */
            /*     $this->DIV */
            /*     ( */
            /*         $value, */
            /*         array */
            /*         ( */
            /*             "STYLE" => array */
            /*             ( */
            /*                 //"max-width" => $rows, */
            /*             ), */
            /*         ) */
            /*     ); */

        }
        elseif (preg_match('/^FILE$/',$this->ItemData[ $data ][ "Sql" ]))
        {
            $value="";
            if (isset($item[ $data ])) { $value=$item[ $data ]; }

            $value=
                $this->MyMod_Data_Fields_File_Decorator
                (
                    $data,$item,$plural,0
                );
        }
        elseif (!empty($this->ItemData[ $data ][ "IsColor" ]))
        {
           $value=$this->MyMod_Data_Fields_Color_Field($data,$item,0);
        }
        elseif (!empty($this->ItemData[ $data ][ "Password" ]))
        {
            $value=$this->ShowPasswordField($data,$value);
        }
        elseif (!empty($this->ItemData[ $data ][ "TimeType" ]))
        {
            $value="-";
            if (!empty($item[ $data ]))
            {
                $value=
                    $this->Span
                    (
                        $this->TimeStamp2Text($item[ $data ]),
                        array("TITLE" => $item[ $data ])
                    );
            }
        }
        elseif (
                  $iconify
                  &&
                  !empty($this->ItemData[ $data ][ "Iconify" ])
                  &&
                  $this->ItemData[ $data ][ "Iconify" ]
                  &&
                  !$this->LatexMode()
               )
        {
            if ($this->ItemData[ $data ][ "Iconify" ]==2)
            {
                $value=$item[ $data ];
                if (!empty($this->ItemData[ $data ][ "IconifyText" ]))
                {
                    if (!empty($item[ $data ]))
                    {
                        $value=
                            $this->Filter
                            (
                                $this->ItemData[ $data ][ "IconifyText" ],
                                $item
                            );
                    }
                }

                $value="<A HREF='".$item[ $data ]."'>".$value."</A>";
            }
            elseif ($this->ItemData[ $data ][ "Iconify" ])
            {
                #Email, for instance, are generated as a png in tmp dir
                $file=$item[ "ID" ]."_".$data.".png";
                if (!empty($item[ $data ]))
                {
                    $options=array();
                    if (!empty($this->ItemData[ $data ][ "Options" ]))
                    {
                        $options=
                            $this->ItemData[ $data ][ "Options" ];
                    }
                    
                    $value=
                        $this->Htmls_Image_Text
                        (
                            $file,
                            $item[ $data ],
                            $this->ItemData[ $data ][ "IconColors" ],
                            $this->ItemData[ $data ][ "BkIconColors" ],
                            $options
                        );
                }
            }
            else
            {
                $file=$this->ItemData[ $data ][ "Iconify" ];
                $extrapath_pathcorrection=$this->CGI_Script_Extra_Path_Correction();
                if ($extrapath_pathcorrection!="")
                {
                    $file=$extrapath_pathcorrection."/".$file;
                }

                $value="<IMG SRC='".$file."' BORDER='0' ALT='img'";
                if ($this->ItemData[ $data ][ "Width" ]!="")
                {
                    $value.=" WIDTH='".$this->ItemData[ $data ][ "Width" ]."'";
                }
                if ($this->ItemData[ $data ][ "Height" ]!="")
                {
                    $value.=" HEIGHT='".$this->ItemData[ $data ][ "Height" ]."'";
                }

                $value.=">";
                $value="<A HREF='".$item[ $data ]."'>".$value."</A>";
            }
        }
        elseif (
                isset($this->ItemData[ $data ][ "Filter" ])
                ||
                isset($this->ItemData[ $data ][ $this->Profile."Filter" ])
               )
        {
            $value="";
            if (isset($this->ItemData[ $data ][ $this->Profile."Filter" ]))
            {
                $value=$this->ItemData[ $data ][ $this->Profile."Filter" ];
            }
            elseif (isset($this->ItemData[ $data ][ "Filter" ]))
            {
                $value=$this->ItemData[ $data ][ "Filter" ];
            }

            if ($value!="" && method_exists($this,$value))
            {
                $value=$this->$value($data,$item);
            }

            $value=$this->Filter($value,$item);
            $value=$this->FilterObject($value);
        }
        elseif ($this->MyMod_Data_Field_Is_Module($data))
        {
            $value=
                $this->MyMod_Data_Fields_Module_Show($data,$item,$value,$plural);
        }
        elseif ($this->MyMod_Data_Field_Is_Enum($data))
        {
            $value=$this->GetEnumValue($data,$item);

            if (
                  !$this->LatexMode()
                  &&
                  isset($item[ $data ])
                  &&
                  $item[ $data ]>0
               )
            {
                $val=$item[ $data ]-1;
                if
                    (
                        !empty($this->ItemData[ $data ][ "ValueColors" ])
                        &&
                        !empty($this->ItemData[ $data ][ "ValueColors" ][ $val ])
                    )
                {
                    $value=
                        $this->TextColor
                        (
                            $this->ItemData[ $data ][ "ValueColors" ][ $val ],
                            $value
                        );
                }
                elseif
                    (
                        !empty($this->ItemData[ $data ][ "Classes" ])
                        &&
                        !empty($this->ItemData[ $data ][ "Classes" ][ $val ])
                    )
                {
                    $value=
                        $this->Htmls_SPAN
                        (
                            $value,
                            array
                            (
                                "CLASS" => $this->ItemData[ $data ][ "Classes" ][ $val ]
                            )
                        );
                }
            }
        }
        elseif ($this->MyMod_Data_Field_Is_Date($data))
        {
            $value=$this->CreateDateShowField($data,$item,$value);
        }
        elseif ($this->MyMod_Data_Field_Is_Hour($data))
        {
            $value=$this->CreateHourShowField($data,$item,$value);
        }
        else
        {
            if (isset($item[ $data ]) && $item[ $data ])
            {
                $value=$item[ $data ];
            }
            else
            {
                if (
                      preg_match('/^(\S+)_(.+)/',$data,$matches) &&
                      !empty($this->ItemData[ $matches[1] ][ "SqlObject" ])
                   )
                {
                    $basedata=$matches[1];

                    $object=$this->ItemData[ $basedata ][ "SqlObject" ];
                    $keys=preg_grep('/^'.$basedata.'_/',array_keys($item));

                    $ritem=array();
                    foreach ($keys as $kid => $key)
                    {
                        $rkey=preg_replace('/^'.$basedata.'_/',"",$key);
                        $ritem[ $rkey ]=$item[ $key ];
                    }

                    $value=$this->$object->MakeShowField($matches[2],$ritem,$plural,$iconify);
                }
                else
                {
                    
                    if ($this->ItemData[ $data ][ "Sql" ]=="INT")
                    {
                        $value=" 0";
                        if (isset($item[ $data ]))
                        {
                            $value=$item[ $data ];
                        }
                        
                        if ($value=="0")
                        {
                            $value=" 0";
                        }
                    }
                    else
                    {
                        $value=$this->GetEnumValue($data,$item);
                        if (!$this->LatexMode() && !empty($this->ItemData[ $data ][ "ValueColors" ]))
                        {
                            $color=$this->ItemData[ $data ][ "ValueColors" ][ $item[ $data ]-1 ];
                            $value=$this->TextColor($color,$value);
                        }
                    }
                }
            }
        }

        if (is_string($value))
        {
            $value=preg_replace('/&#92;/',"\\",$value);
        }
        
        if (!$plural)
        {
            $comment=$this->MyMod_Data_Field_Comment($data,0);
            if (!empty($comment))
            {
                $value=
                    array
                    (
                        $value,
                        $comment
                    );
            }
        }
        
        if (!empty($this->ItemData[ $data ][ "Align" ]))
        {
            $value=
                $this->Htmls_DIV
                (
                    $value,
                    array("ALIGN" => $this->ItemData[ $data ][ "Align" ])
                );
        }

        if (!empty($this->ItemData[ $data ][ "Format" ]) && is_string($value))
        {
            $value=sprintf($this->ItemData[ $data ][ "Format" ],$value);
        }
        
        if (!empty($this->ItemData[ $data ][ "HRef_Action" ]))
        {
            $obj=$this->ItemData[ $data ][ "SqlClass" ]."Obj";

            $value=
                $this->$obj()->MyActions_Entry
                (
                    $this->ItemData[ $data ][ "HRef_Action" ],
                    $item,
                    $noicons=0,$class="",$rargs=array(),$noargs=array(),$alt=FALSE,$icon="",
                    $name=$value
                );
        }

        if
            (
                isset($item[ $data ])
                &&
                empty($this->ItemData[ $data ][ "Iconify" ])
                &&
                !preg_match('/^FILE$/',$this->ItemData[ $data ][ "Sql" ])
            )
        {
            if
                (
                    !empty($this->ItemData[ $data ][ "ForceZero" ])
                    &&
                    empty($value)
                )
            {
                $value=" 0";
            }

            $value=
                $this->Htmls_SPAN
                (
                    $value,
                    $this->MyMod_Data_Field_Show_Style_Apply
                    (
                        $data,
                        $item,
                        $options
                    )
                );
        }
        
        return $value;
    }

    //*
    //* Generates show text field. Split for HTML/Latex.
    //*

    function MyMod_Data_Field_Show_Title($item,$data,$value)
    {
        $title=$item[ $data ];
        if ($this->MyMod_Data_Field_Is_Module($data))
        {
            $value=$item[ $data ];

            if (!empty($this->ItemData[ $data ][ "Items" ][ $value ][ "Title" ]))
            {
                $title=
                    $this->ItemData
                    [ $data ][ "Items" ][ $value ][ "Title" ];
            }
            elseif (!empty($this->ItemData[ $data ][ "Items" ][ $value ][ "Name" ]))
            {
                $title=
                    $this->ItemData
                    [ $data ][ "Items" ][ $value ][ "Name" ];
            }
        }

        return $title;
    }
    //*
    //* Generates show text field. Split for HTML/Latex.
    //*

    function MyMod_Data_Field_Show_Style_Apply($data,$item,$options)
    {
        if ($this->LatexMode()) { return; }

        $method=$this->ItemData($data,"Style_Method");        
        if (!empty($method))
        {
            $options[ "STYLE" ]=
                $this->$method($item);
        }

        return $options;
    }
    //*
    //* Generates show text field. Split for HTML/Latex.
    //*

    function MyMod_Data_Field_Show_Text($data,$value)
    {
        if ($this->LatexMode())
        {
            return $this->MyMod_Data_Field_Show_Text_Latex($data,$value);
        }
        else
        {
            return $this->MyMod_Data_Field_Show_Text_HTML($data,$value);
        }
    }
    
    //*
    //* Generates latex preprocessed show filed contents.
    //*

    function MyMod_Data_Field_Show_Text_HTML($data,$value)
    {
        $size=$this->ItemData[ $data ][ "Size" ];
        $size=preg_split('/\s*x\s*/',$size);

        $width=50;
        if ($size[0]) { $width=$size[0]; }
        $value=preg_replace("/(\s*\n\s*)+/","<BR>\n",$value);

        $values=preg_split('/\s+/',$value);
        $rvalues=array();

        $rvalue="";
        foreach ($values as $svalue)
        {
            if (strlen($rvalue.$svalue)<$width)
            {
                $rvalue.=" ".$svalue;
            }
            else
            {
                array_push($rvalues,$rvalue);
                $rvalue=$svalue;
            }
        }

        if (preg_match('/\S/',$rvalue))
        {
            array_push($rvalues,$rvalue);
        }

        return join($this->BR(),$rvalues);
    }

    //*
    //* Generates latex preprocessed show filed contents.
    //*

    function MyMod_Data_Field_Show_Text_Latex($data,$value)
    {
        return $value;
    }
}

?>