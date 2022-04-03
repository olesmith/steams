<?php

include_once("Enums/CheckBox.php");
include_once("Enums/Value.php");
include_once("Enums/Values.php");
include_once("Enums/Names.php");
include_once("Enums/Title.php");
include_once("Enums/Titles.php");
include_once("Enums/Options.php");

trait MyMod_Data_Fields_Enums
{
    use
        MyMod_Data_Fields_Enums_CheckBox,
        MyMod_Data_Fields_Enums_Value,
        MyMod_Data_Fields_Enums_Values,
        MyMod_Data_Fields_Enums_Names,
        MyMod_Data_Fields_Enums_Title,
        MyMod_Data_Fields_Enums_Titles,
        MyMod_Data_Fields_Enums_Options;
    
    //*
    //* 
    //*

    function MyMod_Data_Enum_Reverse_Value($data,$value)
    {
        $rvalue=0;
        for ($n=0;$n< count( $this->ItemData[ $data ][ "Values" ] );$n++)
        {
            if ($value==$this->ItemData[ $data ][ "Values" ][ $n ])
            {
                $rvalue=$n+1;

                break;
            }
        }

        return $rvalue;
    }
    
   
    //*
    //* Creates input field based on data definition (type, size, etc.).
    //* Should ONLY be called by MakeDataField, who checks access
    //*

    function MyMod_Data_Field_Enum_Edit($data,$item,$value,$tabindex,$plural,$links,$callmethod,$rdata,$ignoredefault=False)
    {
        if (empty($rdata)) { $rdata=$data; }
        
        if ($this->MyMod_Data_Field_Enum_CheckBox_Is($data))
        {
            return
                $this->MyMod_Data_Field_Enum_CheckBox($data,$value,$item);
        }

        $value=
            $this->MyMod_Data_Field_Enum_Value
            (
                $data,$value,
                $ignoredefault
            );
            
        $values=
            $this->MyMod_Data_Field_Enum_Values($data);

        $titles=
            $this->MyMod_Data_Field_Enum_Titles($data,$values);

        return
            $this->Htmls_Select
            (
                $rdata,
                $values,
                $this->MyMod_Data_Field_Enum_Names($data,$values),
                $value,
                array
                (
                    "Disableds" => array(),
                    "Titles" => $titles,
                    "Title" => $this->MyMod_Data_Field_Enum_Title
                    (
                        $data,$titles,$value
                    ),
                    "MaxLen" => 0,
                    "ExcludeDisableds" => False,
                    "Multiple" => False,
                    "OnChange" => NULL,
                    "Value_Styles" => $this->ItemData($data,"Value_Styles"),
                ),
                $this->MyMod_Data_Field_Enum_Options($data,$tabindex,$item)
            );
    }
    
    //*
    //* Uses $this->ItemData[ $data ][ "Values" ] to obtain
    //* enum value of $data in $item.
    //* Implements also a ValuesMatrix, so that dependent of another
    //* ENUM entry, the actual values may change. Ex:
    //* Bibliography Area and Subarea.
    //* Substitutes enum nos with text values in $item, for. One enum.
    //* If $latex is true and $this->ItemData[ $data ] has 
    //* "Values_Latex" key, these are used instead of the the "Values" key.
    //* Also tests if $data"_Orig" key is set in $item.
    //* If it is, this means that Enums value has been substituted in
    //* $item, and so, the value to regenerate should be $data"_Orig" and
    //* not $data. Routines that substitutes enums, should set $data"_Orig".
    //*
    //* Data may be of type ENUM, SqlTable/Object  and Derived.
    //*
    //* Returns enum value.
    //*

    function MyMod_Data_Fields_Enums_Value($data,&$item,$latex=FALSE)
    {
        $type=$this->ItemData($data,"Sql");

        $value="";        
        if (!isset($item[ $data ]))
        {
            $empty=$this->MyMod_Data_Enum_Name_Empty($data);;
            if (!empty($empty))
            {
                $value=$empty;
            }

            return $value;
        }

        if ($this->LatexMode()) { $latex=TRUE; }


        $value=$item[ $data ];
        if ($this->MyMod_Data_Field_Is_Enum($data))
        {
            $values=array();
            if (
                  !empty($this->ItemData[ $data ][ "ValuesMatrix" ]) 
                  &&
                  is_array($this->ItemData[ $data ][ "ValuesMatrix" ]) 
                  &&
                  !empty($this->ItemData[ $data ][ "ValuesDependencyVar" ])
               )
            {
                $values=$this->GetDependentEnumValues($data,$item,$latex);
            }
            elseif ($latex && isset($this->ItemData[ $data ][ "Values_Latex" ]))
            {
                $values=$this->GetRealNameKey($this->ItemData[ $data ],"Values_Latex");
            }
            else
            {
                $values=$this->GetRealNameKey($this->ItemData[ $data ],"Values");
            }

            if (!isset($item[ $data."_Orig" ]) || $item[ $data."_Orig" ]=="")
            {
                if ($value && isset($values[ $value-1 ]))
                {
                    $value=$values[ $value-1 ];
                }
            }
            else
            {
                $value=$item[ $data ];
            }

            $empty=$this->MyMod_Data_Enum_Name_Empty($data);
            if (!empty($empty))
            {
                if (empty($value))
                {
                    $value=$empty;
                }
            } 
        }
        elseif ($this->MyMod_Data_Field_Is_Derived($data))
        {
            if ($this->ItemData[ $data ][ "SqlDerivedNamer" ]!="")
            {
                $ddata=$data."_".$this->ItemData[ $data ][ "SqlDerivedNamer" ];
                $value=$item[ $ddata ];
            }
            elseif ($this->ItemData[ $data ][ "Derived" ]!="" &&
                    preg_match('/#/',$this->ItemData[ $data ][ "DerivedFilter" ]))
            {
                $filter=$this->ItemData[ $data ][ "DerivedFilter" ];
                $value=$this->Filter($filter,$item);
            }
        }
        elseif ($this->MyMod_Data_Field_Is_Sql($data))
        {
            $subitem=
                $this->MyMod_Data_2Module($data)->Sql_Select_Hash
                (
                   array("ID" => $item[ $data ]),
                   $this->MyMod_Data_Fields_Module_Datas($data)
                );
            
            if (empty($subitem)) { $subitem=array(); }

            
            $value=
                $this->Filter
                (
                    $this->MyMod_Data_2ModuleKey($data,"SqlFilter"),
                    $subitem
                );

            foreach ($subitem as $rkey => $rvalue)
            {
                $item[ $data."__".$rkey ]=$rvalue;
            }
        }


        return $value;
    }
    
    //*
    //* Applies ENUM and SQL fields on $item.
    //*

    function MyMod_Data_Fields_Enums_ApplyAll($item=array(),$latex=FALSE,$datas=array(),$sqls=True)
    {
        if (empty($item)) { $item=$this->ItemHash; }
        if (empty($item)) { return $item; }
        if (empty($datas)) { $datas=$this->DatasRead; }

        if (empty($datas)) { $datas=array_keys($item); }

        $this->ItemData("ID");
        foreach ($datas as $no => $data)
        {
            $this->MyMod_Data_Field_Enum_Apply
            (
                $data,
                $item,$latex,$datas,$sqls
            );
        }

        return $item;
    }
    
    //*
    //* Applies ENUM and SQL fields on $item.
    //*

    function MyMod_Data_Field_Enum_Apply($data,&$item,$latex=FALSE,$datas=array(),$sqls=True)
    {
        if
            (
                $sqls
                &&
                $this->MyMod_Data_Field_Is_Sql($data)
            )
        {
            $this->MyMod_Data_Field_Enum_Apply_Sql
            (
                $data,$item,$latex,$datas
            );
        }
        elseif
            (
                $this->MyMod_Data_Field_Is_Enum($data)
                ||
                $this->MyMod_Data_Field_Is_Derived($data)
            )
        {
            $this->MyMod_Data_Field_Enum_Apply_Enum
            (
                $data,$item,$latex,$datas
            );
        }
        elseif ($this->MyMod_Data_Field_Is_Date($data))
        {
            $this->MyMod_Data_Field_Enum_Apply_Date
            (
                $data,$item,$latex,$datas
            );
        }
        elseif ($this->MyMod_Data_Field_Is_Time($data))
        {
            $this->MyMod_Data_Field_Enum_Apply_Time
            (
                $data,$item,$latex,$datas
            );
        }
    }

    //*
    //* 
    //*

    function MyMod_Data_Field_Enum_Apply_Sql($data,&$item,$latex=FALSE)
    {
        if (empty($item[ $data."_Orig" ]))
        {
            $value="";
            if (isset($item[ $data ])) { $value=$item[ $data ]; }
                    
            if (!empty($item[ $data ]))
            {
                $subitem=$this->MyMod_Data_Fields_Module_SubItem_Get($data,$item);
                if (is_array($subitem) && !empty($subitem))
                {
                    foreach ($subitem as $key => $val)
                    {
                        $item[ $data."_".$key ]=$val;
                    }
                            
                    $item[ $data."__ID" ]=$item[ $data."_ID" ];
                }
            }
                    
            $item[ $data ]=
                $this->MyMod_Data_Fields_Enums_Value($data,$item,$latex);
            $item[ $data."_Orig" ]=$value;

        }        
    }
    
    //*
    //* 
    //*

    function MyMod_Data_Field_Enum_Apply_Enum($data,&$item,$latex=FALSE)
    {
        if (empty($item[ $data."_Orig" ]))
        {
            $value="";
            if (isset($item[ $data ])) { $value=$item[ $data ]; }
            $item[ $data ]=
                $this->MyMod_Data_Fields_Enums_Value($data,$item,$latex);
            $item[ $data."_Orig" ]=$value;
        }
    }

    //*
    //* 
    //*

    function MyMod_Data_Field_Enum_Apply_Date($data,&$item,$latex=FALSE)
    {
        $value="";
        if (!empty($item[ $data ])) { $value=$item[ $data ]; }

        if (preg_match('/^(\d{4})(\d{2})(\d{2})$/',$value,$matches))
        {
            $item[ $data ]=
                $this->CreateDateShowField($data,$item,$value);
            
            $item[ $data."_Date"  ]=$matches[3];
            $item[ $data."_Month" ]=$matches[2];
            $item[ $data."_Year"  ]=$matches[1];

            $item[ $data."_Month_Name" ]=
                $this->MyTime_Month
                (
                    $item[ $data."_Month" ],
                    "Title"
                );

            //var_dump($item[ $data ],$matches);
            //exit();
        }
    }

    //*
    //* 
    //*

    function MyMod_Data_Field_Enum_Apply_Time($data,&$item,$latex=FALSE)
    {
        $value="";
        if (!empty($item[ $data ])) { $value=$item[ $data ]; }
                
        $item[ $data ]=$this->TimeStamp2Text($value);
    }


    //*
    //* Applies only ENUM fields on $item.
    //*

    function MyMod_Data_Item_Apply_Enums_Only($item=array(),$latex=FALSE,$datas=array())
    {
        if (empty($item)) { $item=$this->ItemHash; }
        if (empty($item)) { return $item; }
        if (empty($datas)) { $datas=array_keys($item); }

        if (empty($datas)) { $datas=array_keys($item); }

        $this->ItemData("ID");
        foreach ($datas as $no => $data)
        {
            if ($this->MyMod_Data_Field_Is_Enum($data))
            {
                if (!isset($item[ $data."_Orig" ]) || $item[ $data."_Orig" ]=="")
                {
                    $value="";
                    if (isset($item[ $data ])) { $value=$item[ $data ]; }
                    $item[ $data ]=$this->MyMod_Data_Fields_Enums_Value($data,$item,$latex);
                    $item[ $data."_Orig" ]=$value;
                }
                elseif (preg_match('/^[AMC]Time$/',$data) && preg_match('/^\d+$/',$item[ $data ]))
                {
                    $item[ $data ]=$this->TimeStamp2Text($item[ $data ]);
                }
            }
            elseif ($this->MyMod_Data_Field_Is_Date($data))
            {
                $this->MyMod_Data_Field_Enum_Apply_Date
                (
                    $data,$item,$latex,$datas
                );
            }
            elseif ($this->MyMod_Data_Field_Is_Time($data))
            {
                $this->MyMod_Data_Field_Enum_Apply_Time
                (
                    $data,$item,$latex,$datas
                );
            }
        }

        return $item;
    }


    //*
    //* Applies only ENUM fields on $items.
    //*

    function MyMod_Data_Items_Apply_Enums_Only($items=array(),$latex=FALSE,$datas=array())
    {
        if (empty($items)) { $items=$this->ItemHashes; }
        if (empty($items)) { return $items; }
        foreach (array_keys($items) as $id)
        {
            $items[ $id ]=
                $this->MyMod_Data_Item_Apply_Enums_Only($items[ $id ],$latex,$datas);
        }

        return $items;
    }

    
}

?>