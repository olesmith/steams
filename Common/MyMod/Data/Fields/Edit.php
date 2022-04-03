<?php



trait MyMod_Data_Fields_Edit
{
    //*
    //* function MyMod_Data_Fields_Edit, Parameter list: $data,$item,$value="",$tabindex="",$plural=FALSE,$links=TRUE,$callmethod=TRUE,$rdata=""
    //*
    //* Creates input field based on data definition (type, size, etc.).
    //* Should ONLY be called by MakeDataField, who checks access
    //*

    function MyMod_Data_Fields_Edit($data,$item,$value="",$tabindex="",$plural=FALSE,$links=TRUE,$callmethod=TRUE,$rdata="")
    {
        //Make sure we call acesser to ensure loading.
        $sql=$this->ItemData($data,"Sql");
        if (empty($rdata))
        {
            $rdata=$data;
            if ($plural && !empty($item[ "ID" ]))
            {
                $rdata=$item[ "ID" ]."_".$data;
            }
        }
        
        //Save and then disable tabindex
        $rtabindex=$tabindex;
        if (empty($tabindex) && !empty($this->ItemData[ $data ][ "TabIndex" ]))
        {
            $tabindex=$this->ItemData[ $data ][ "TabIndex" ];
        }

        $options=array();

        if (!empty($this->ItemData[ $data ][ "OptionsMethod" ]))
        {
            $method=$this->ItemData[ $data ][ "OptionsMethod" ];

            $options=
                $this->$method($data,$item,$options);
        }
        
        if (!empty($tabindex)) { $options[ "TABINDEX" ]=$tabindex; }

        $options=
            $this->MyMod_Data_Field_Place_Holder($data,$item,$options);

        if
            (
                $callmethod
                &&
                $fieldmethod=
                $this->MyMod_Data_Fields_Method
                (
                    $item,$data,$rdata
                )
            )
        {
           $value=$this->$fieldmethod($data,$item,1,$rdata);
        }
        elseif ($this->MyMod_Data_Field_Is_Color($data))
        {
            //Color fields
            $value=$this->MyMod_Data_Fields_Color_Field($data,$item,1,$rdata);
        }
        elseif ($this->MyMod_Data_Field_Is_Derived($data))
        {
            //Derived data
            $value=$item[ $data ];
        }
        elseif ($this->MyMod_Data_Field_Is_Enum($data))
        {
            //Enums
            $value=
                $this->MyMod_Data_Field_Enum_Edit
                (
                    $data,
                    $item,
                    $value,
                    $tabindex,
                    $plural,
                    //$this->ItemData[ $data ][ "SelectCheckBoxes" ],
                    $links,
                    //"",
                    $callmethod,
                    //$tabindex,
                    $rdata,
                    $ignoredefault=False
                );
        }
        elseif ($this->MyMod_Data_Field_Is_Text($data))
        {
            //TEXTAREAS: Text and Varchar
            $value=
                $this->MyMod_Data_Fields_Text_Edit
                (
                    $data,
                    $item,
                    $value,
                    $rtabindex,
                    $plural,
                    $options,
                    $rdata
                );
        }
        elseif ($this->MyMod_Data_Field_Is_Module($data))
        {
            //ID in another module table
            $value=
                $this->MyMod_Data_Fields_Module_Edit
                (
                    $data,
                    $item,
                    $value,
                    $rtabindex,
                    $plural,
                    $options,
                    $rdata
                );
        }
        elseif ($this->MyMod_Data_Field_Is_File($data))
        {
            //File fields
            $value=
                $this->MyMod_Data_Field_File_Edit
                (
                    $data,
                    $item,
                    $value,
                    $tabindex,
                    $plural,
                    $links,
                    $callmethod,
                    $rdata
                );
        }
        elseif ($this->MyMod_Data_Field_Is_Password($data))
        {
            $value=$this->MyMod_Data_Field_Password_Edit($data,$value,$rdata);
        }
        elseif ($this->MyMod_Data_Field_Is_Date($data))
        {
            $value=
                $this->MyMod_Data_Field_Date_Edit
                (
                    $data,$item,$value,$rdata,
                    False,
                    $tabindex
                );
        }
        elseif (!empty($this->ItemData[ $data ][ "IsHour" ]))
        {
            $value=$this->MyMod_Data_Field_Hour_Edit($rdata,$item,$value);
        }
        else
        {
            if (!empty($tabindex))
            {
                $options[ "TABINDEX" ]=$tabindex;
            }
            
            $value=
                $this->MyMod_Data_Field_Input_Edit
                (
                    $data,$item,$value,$rdata,$plural,$options
                );
        }


        if (
              $this->CGI_POSTint($this->ModuleName."_TabMovesDown")==1
              &&
              !empty($rtabindex)
              &&
              !preg_match('/\sTABINDEX=/i',$value)
           )
        {
            $value=
                preg_replace
                (
                 '/<(INPUT|SELECT|TEXTAREA)\s+/i',
                 "<$1 TABINDEX='".$rtabindex."'",
                 $value
                );
        }


        if (!$plural)
        {
            $comment=$this->MyMod_Data_Field_Comment($data,1);
            if (is_array($value))
            {
                array_push($value,$comment);
            }
            else
            {
                $value.=$this->MyMod_Data_Field_Comment($data,1);
            }
        }

        if
            (
                !empty($this->ItemData[ $data ][ "CGIName" ])
                &&
                !$plural
            )
        {
            $regex="\sNAME='$data";
            if (preg_match('/'.$regex.'/',$value))
            {
                $value=
                    preg_replace
                    (
                        '/'.$regex.'/',
                        " NAME='".$this->ItemData[ $data ][ "CGIName" ],
                        $value
                    );
            }
        }
        
        return $value;
    }
    
    //*
    //* Create default type field: input text.
    //*

    function MyMod_Data_Field_Input_Edit_ID($data,$item)
    {
        $ids=
            array
            (
                $this->ModuleName,
                $data,
            );

        if (!empty($item[ "ID" ]))
        {
            array_push($ids,$item[ "ID" ]);
        }
        
        return join("_",$ids);
    }
    
    //*
    //* Create default type field: input text.
    //*

    function MyMod_Data_Field_Input_Edit($data,$item,$value,$rdata,$plural,$options)
    {
        if (!empty($this->ItemData($data,"Format")))
        {
            $value=sprintf($this->ItemData($data,"Format"),$value);
        }

        if (!empty($this->ItemData[ $data ][ "AutoComplete" ]))
        {
            $options[ "AUTOCOMPLETE" ]=
                $this->ItemData[ $data ][ "AutoComplete" ];
        }
        
        if (!empty($this->ItemData[ $data ][ "Size_Min" ]))
        {
            $options[ "STYLE" ]=
                "width: ".$this->ItemData[ $data ][ "Size_Min" ].";".
                "min-width: ".$this->ItemData[ $data ][ "Size_Min" ].";".
                "";
        }

        $options[ "ID" ]=
            $this->MyMod_Data_Field_Input_Edit_ID($data,$item);

        $options[ "SIZE" ]=
            $this->MyMod_Data_Field_Input_Edit_Size($data,$value,$plural);
        
        return $this->Htmls_Input("text",$rdata,$value,$options);
    }
    

    //*
    //* Create default type field: input text.
    //*

    function MyMod_Data_Field_Place_Holder($data,$item,$options=array())
    {
        if (!empty($method=$this->ItemData($data,"Place_Holder")))
        {
            $options[ "PLACEHOLDER" ]=
                $this->$method($data,$item);
        }

        return $options;
    }
    
    //*
    //* Create default type field: input text.
    //*

    function MyMod_Data_Field_Input_Edit_Size($data,$value,$plural)
    {
        $size=25;
        if ($this->ItemData[ $data ][ "Size" ])
        {
            $size=$this->ItemData[ $data ][ "Size" ];
        }
        
        if ($plural && !empty($this->ItemData[ $data ][ "TableSize" ]))
        {
            $size=$this->ItemData[ $data ][ "TableSize" ];
        }

        if
            (
                !$plural
                &&
                !empty($this->ItemData[ $data ][ "Size_Dynamic" ])
                &&
                preg_match('/VARCHAR/i',$this->ItemData[ $data ][ "Sql" ])
                &&
                !empty($value)
            )
        {
            $size=strlen($this->Html2Sort($value));
        }
        
        if
            (
                !empty($this->ItemData[ $data ][ "Size_Max" ])
                &&
                $size>$this->ItemData[ $data ][ "Size_Max" ]
            )
        {
            //$size=$this->ItemData[ $data ][ "Size_Max" ];
        }

        return $size;
    }

    //*
    //* Returns comment to add to field
    //*

    function MyMod_Data_Field_Comment($data,$edit=0)
    {
        if (
            !$this->NoFieldComments
            &&
            !isset($this->ItemData[ $data ][ "NoComment" ])
           )
        {
            $keys=array();
            if ($edit==1) { array_push($keys,"EditComment"); }
            array_push($keys,"Comment");
            
            $comment=
                $this->LanguagesObj()->Language_Data_Get_If_Defined($this,$data,$keys);
        }

        return "";
    }

}

?>