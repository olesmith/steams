<?php

include_once("Fields/Access.php");
include_once("Fields/Is.php");
include_once("Fields/Show.php");
include_once("Fields/Edit.php");
include_once("Fields/File.php");
include_once("Fields/Password.php");
include_once("Fields/Hour.php");
include_once("Fields/Date.php");
include_once("Fields/Text.php");
include_once("Fields/Test.php");
include_once("Fields/Color.php");
include_once("Fields/Barcode.php");
include_once("Fields/Module.php");
include_once("Fields/Enums.php");
include_once("Fields/Derived.php");
include_once("Fields/Sql.php");
include_once("Fields/Crypt.php");

trait MyMod_Data_Fields
{
    use 
        MyMod_Data_Fields_Access,
        MyMod_Data_Fields_Is,
        MyMod_Data_Fields_Show,
        MyMod_Data_Fields_Edit,
        MyMod_Data_Fields_File,
        MyMod_Data_Fields_Password,
        MyMod_Data_Fields_Hour,
        MyMod_Data_Fields_Date,
        MyMod_Data_Fields_Text,
        MyMod_Data_Fields_Test,
        MyMod_Data_Fields_Color,
        MyMod_Data_Fields_Barcode,
        MyMod_Data_Fields_Module,
        MyMod_Data_Fields_Enums,
        MyMod_Data_Fields_Derived,
        MyMod_Data_Fields_Crypt,
        MyMod_Data_Fields_Sql;

    //*
    //* Generates data field.
    //*

    function MyMod_Data_Fields
        (
            $edit,$item,$datas,
            $plural=FALSE,$tabindex="",$rdatas="",$even=TRUE,$class="",
            $callmethod=TRUE,$links=TRUE,$iconify=TRUE
        )
    {
        if (!is_array($datas))
        {
            $datas=array($datas);
        }

        if (!is_array($rdatas)) { $rdatas=array($rdatas); }
        
        $cells=array();
        $count=1;
        foreach ($datas as $data)
        {
            $rdata=array_shift($rdatas);

            array_push
            (
                $cells,
                $this->MyMod_Data_Field
                (
                    $edit,$item,$data,$plural,$tabindex,
                    $rdata,
                    $even,
                    $class,
                    $callmethod,$links,$iconify
                )
            );
            
            if ($count<count($datas))
            {
                array_push($cells,$this->BR());
            }
        }
         

        if (count($cells)==1) { $cells=array_pop($cells); }

        return $cells;
    }
    
    //*
    //* Generates data field.
    //*

    function MyMod_Data_Field
        (
            $edit,$item,$data,$plural=FALSE,
            $tabindex="",$rdata="",$even=TRUE,$class="",
            $callmethod=TRUE,$links=TRUE,$iconify=TRUE
        )
    {
        $access=$this->MyMod_Data_Access($data,$item);
        
        $value="";
        if (isset($item[ $data ])) { $value=$item[ $data ]; }

        if ($this->ItemData($data,"Type")=="TEXT")
        {
            return "";
        }
        
        if (!empty($this->ItemData[ $data ][ "Info" ]))
        {
            return $this->MyMod_Data_Field_Info($data);
        }

        $field="";
        if ($edit==1 && $access==2 && isset($this->ItemData[ $data ]))
        {
            if (empty($tabindex) && !empty($this->ItemData[ $data ][ "TabIndex" ]))
            {
                $tabindex-$this->ItemData[ $data ][ "TabIndex" ];
            }
            
            $field=
                $this->MyMod_Data_Fields_Edit
                (
                    $data,
                    $item,
                    $value,
                    $tabindex,
                    $plural,
                    $links,
                    $callmethod,
                    $rdata,
                    $links,$callmethod
                );
        }
        elseif ($access>0)
        {
            $field=
                $this->MyMod_Data_Fields_Show
                (
                    $data,
                    $item,
                    $plural,
                    
                    $iconify,$callmethod
                );
        }
        elseif (isset($this->Actions[ $data ]))
        {
            if ($this->MyAction_Allowed($data,$item))
            {
                $field=
                    $this->MyActions_Entry_Gen
                    (
                        $data,
                        $item,
                        $noicons=0,
                        $this->MyMod_EvenOdd_Class($even),
                        $rargs=array(),
                        $noargs=array(),
                        $icon=""
                    );
            }
            else
            {
                if (!empty($this->Actions[ $data ][ "AltAction" ]))
                {
                    return
                        $this->MyActions_Entry_Gen
                        (
                            $this->Actions[ $data ][ "AltAction" ],
                            $item,
                            $noicons=0,
                            $this->MyMod_EvenOdd_Class($even),
                            $rargs=array(),
                            $noargs=array(),
                            $icon=""
                        );
                }
            }
        }
        elseif (method_exists($this,$data))
        {
            if (!empty($this->CellMethods[ $data ]))
            {
                $field=$this->$data($edit,$item,$data,$plural,$tabindex,$rdata,$even);
            }
            else
            {
                var_dump
                (
                    "CellMethod ".
                    $data.
                    " exists, but CellMethods key not true: ".
                    "(\$edit,\$item,\$data,\$plural,".
                    "\$tabindex=\"\",\$rdata=\"\",\$even=True)".
                    ""
                );
            }
        }
        
        $field=
            $this->MyMod_Data_Field_Comment_Pre_Method_Apply
            (
                $edit,$access,$data,$item,$field
            );
        
        $field=
            $this->MyMod_Data_Field_Comment_Method_Apply
            (
                $edit,$access,$data,$item,$field,$plural
            );
        
        
        if
            (
                $edit==1
                &&
                !empty($this->ItemData[ $data ][ "Class" ])
            )
        {
            $field=
                $this->Htmls_Span
                (
                    $field,                    
                    array
                    (
                        "Class" => $this->ItemData[ $data ][ "Class" ],
                    )
                );
        }


        
        return $field;
    }
    
    //*
    //* 
    //*

    function MyMod_Data_Field_DIV_Class($edit,$access,$data,$item,$field)
    {
        return
            array
            (
                "Class" => $this->ItemData[ $data ][ "Class" ],
            );
    }
    

    //*
    //* Applies Pre_Comment_Method, if set.
    //*

    function MyMod_Data_Field_Comment_Pre_Method_Apply($edit,$access,$data,$item,$field)
    {
        if
            (
                !empty($method=$this->ItemData($data,"Pre_Comment_Method"))
            )
        {
            if (method_exists($this,$method))
            {
                $field=
                    array
                    (
                        $this->$method
                        (
                            $this->Min($edit,$access-1),
                            $data,
                            $item
                        ),
                        $field
                    );
            }
        }

        return $field;
    }
      //*
    //* Applies Comment_Method, if set.
    //*

    function MyMod_Data_Field_Comment_Method_Apply($edit,$access,$data,$item,$field,$plural)
    {
        if (!empty($this->ItemData[ $data ][ "Comment_Method" ]))
        {
            $method=$this->ItemData[ $data ][ "Comment_Method" ];
            if (method_exists($this,$method))
            {
                $field=
                    $this->$method
                    (
                        $this->Min($edit,$access-1),
                        $data,
                        $item,
                        $field,
                        $plural
                    );
            }
            else
            {
                var_dump
                (
                    "Invalid item data ".
                    $data.
                    " comment method (Comment_Method): ".
                    "\n".                    $method.
                    "(\$edit,\$data,\$item,\$value,\$plural)"
                );
            }
        }

        return $field;
    }

    //*
    //* function MyMod_Data_Field_CGIName, Parameter list: $data
    //*
    //* Detects $data CGIName from ItemData. 
    //*

    function MyMod_Data_Field_CGIName($item,$data,$plural,$prepost="")
    {
        $rdata=$data;
        if (!empty($this->ItemData[ $data ][ "CGIName" ]) && !$plural)
        {
            $rdata=$this->ItemData[ $data ][ "CGIName" ];
        }

        if ($plural)      { $rdata=$item[ "ID" ]."_".$rdata; }
        elseif ($prepost) { $rdata=$prepost.$rdata; }

        return $rdata;
    }


    //*
    //* function MyMod_Data_Fields_Method, Parameter list: $item,$data
    //*
    //* Returns name of field method to apply - or NULL.
    //*

    function MyMod_Data_Fields_Method($item,$data,$rdata="")
    {
        if (empty($rdata)) { $rdata=$data; }
    
        $fieldmethod=NULL;
        if (!empty($this->ItemData[ $data ][ "FieldMethod" ]))
        {
            $fieldmethod=$this->ItemData[ $data ][ "FieldMethod" ];
        }

        if (!empty($this->ItemData[ $data ][ "EditFieldMethod" ]))
        {
            $fieldmethod=$this->ItemData[ $data ][ "EditFieldMethod" ];
        }

        if ($fieldmethod!="" && !method_exists($this,$fieldmethod))
        {
            $this->DoDie("MyMod_Data_Fields_Method: $data: $fieldmethod<BR>Args: \$data,\$item,\$edit,\$rdata=''");
        }

        return $fieldmethod;
    }
    
    //*
    //* function MyMod_Data_Field_Logo, Parameter list: $item,$data
    //*
    //* Creates file data entry, as a logo field.
    //*

    function MyMod_Data_Field_Logo($item,$data,$height="",$width="")
    {
        $access=$this->MyMod_Data_Access($data,$item);

        if ($access<1) { return "Not allowed"; }

        $img="";
        if (!empty($item[ $data ]))
        {
            $icon=$item[ $data ];
            $args=array
            (
               "Unit" => $this->Unit("ID"),
               "Event" => $this->Event("ID"),
               "ModuleName" => $this->ModuleName,
               "Action" => "Download",
               "Data" => $data,
            );
            

            $href="?".$this->CGI_Hash2URI($args);
            if (!empty($item[ "HtmlLogoHeight" ])) { $height=$item[ "HtmlLogoHeight" ]; }
            if (!empty($item[ "HtmlLogoWidth" ]))  { $width=$item[ "HtmlLogoWidth" ]; }

            $img=$this->Img($href,$this->ModuleName." logo",$height,$width);
        }

        return $img;
    }
    //*
    //* function MyMod_Data_Field_Text, Parameter list: $edit,$item,$data,$plural=FALSE,$tabindex="",$rdata=""
    //*
    //* Generates data field as text (not array). Joins what comes back from MyMod_Data_Field.
    //*

    function MyMod_Data_Field_Text($edit,$item,$data,$plural=FALSE,$tabindex="",$rdata="")
    {
        return join(" ",$this->MyMod_Data_Field($edit,$item,$data,$plural,$tabindex,$rdata));
    }
    
}

?>