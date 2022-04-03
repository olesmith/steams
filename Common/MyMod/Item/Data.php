<?php



trait MyMod_Item_Data
{
    //*
    //* Creates item data cell.
    //*

    function MyMod_Item_Data_Cell($edit,$item,$data,$plural=FALSE,$rdata="")
    {
        $dagger=$this->SPAN("*",array("CLASS" => "errors"));
        if ($edit==0)
        {
            $ldata=$this->MyLanguage_GetLanguagedKey($data);
            if ($ldata!=$data && !empty($item[ $ldata ]))
            {
                $data=$ldata;
            }
        }

        $value=$this->MyMod_Data_Fields($edit,$item,$data,$plural,$tabindex="",$rdata);
        if  ($edit==1 && $this->MyMod_Data_Field_Is_Date($data))
        {
            $title="DD/MM/YYYY";
            if ($plural)
            {
                $value=
                    $this->Htmls_SPAN
                    (
                        $value,
                        array("TITLE" => $title)
                    );
            }
            else
            {
                #$value.=" ".$title;
            }
        }
        
        if ($edit==1)
        {
            if (
                isset($item[ $data."_Message" ])
                && $item[ $data."_Message" ]!=""
                && $this->LoginType!="Public"
            )
            {
                $value=
                    array
                    (
                        $value,
                        $this->Htmls_SPAN
                        (
                            $item[ $data."_Message" ],
                            array("CLASS" => 'errors')
                        )
                    );
            }
            elseif
                (
                    !empty($this->ItemData[ $data ][ "Compulsory" ])
                    &&
                    empty($item[ $data ])
                )
            {
                $value=
                    array
                    (
                        $value,
                        $this->Htmls_SPAN
                        (
                            "***",
                            array
                            (
                                "CLASS" => 'errors',
                                "TITLE" => $this->MyLanguage_GetMessage("Compulsory_Message"),
                            )
                        )
                    );
            }
        }

        if (!$this->LatexMode())
        {
            $value=
                $this->Htmls_SPAN
                (
                    $value,
                    array
                    (
                        "ID" => $this->MyMod_Item_Data_Cell_ID
                        (
                            $edit,$item,$data,$rdata
                        ),
                        "CLASS" => $this->MyMod_Item_Data_Cell_Classes
                        (
                            $edit,$item,$data,$rdata
                        ),
                    )
                );
        }

        return $value;
    }
   
    //*
    //* Class to associate with element
    //*

    function MyMod_Item_Data_Cell_ID($edit,$item,$data,$rdata="")
    {
        $id="";
        if (!empty($item[ "ID" ]))
        {
            $id=$item[ "ID" ];
        }
        
        $class='data';
        if ($edit) { $class='editdata'; }
            
        return
            join
            (
                "_",
                array
                (
                    $this->ModuleName,
                    $id,
                    $class,
                    $data
                )
            );
    }
    //*
    //* Class to associate with element
    //*

    function MyMod_Item_Data_Cell_Classes($edit,$item,$data,$rdata="")
    {
        $id="";
        if (!empty($item[ "ID" ]))
        {
            $id=$item[ "ID" ];
        }
        
        $class='data';
        if ($edit) { $class='editdata'; }
            
        
        return
            array
            (
                $this->ModuleName,
                $id,
                $class,
                $data
            );
    }
    
    //*
    //* Creates item table title cell
    //*

    function MyMod_Item_Data_Cell_Title($data,$item=array(),$addcolon=FALSE,$options=array(),$addmsg=TRUE)
    {
        if (empty($this->ItemData[ $data ])) { return ""; }
        
        $dagger=$this->SPAN("*",array("CLASS" => "errors"));

        $name="";
        if (!empty($this->ItemData[ $data ][ "NameFieldMethod" ]))
        {
            $method=$this->ItemData[ $data ][ "NameFieldMethod" ];
            $name=$this->$method($data,$item);
        }
        else
        {
            $name=
                $this->LanguagesObj()->Language_Data_Name_Get
                (
                    $this,
                    $data,
                    array($this->TitleKeyName)
                );
        }
        
        if (!empty($this->ItemData[ $data ][ "TitleFieldMethod" ]))
        {
            $method=$this->ItemData[ $data ][ "TitleFieldMethod" ];
            $title=$this->$method($data,$item);
        }
        else
        {
            $title=
                $this->LanguagesObj()->Language_Data_Title_Get
                (
                    $this,
                    $data,
                    array($this->TitleKeyTitle)
                );
        }
        
        if (
              preg_match('/^([^_]+)_(.+)/',$data,$matches)
              &&
              isset($this->ItemData[ $matches[1] ])
              &&
              !empty($this->ItemData[ $matches[1] ][ "SqlObject" ])
           )
        {
            $object=$this->ItemData[ $matches[1] ][ "SqlObject" ];

            if (isset($this->$object->ItemData[ $matches[2] ]))
            {
                $name=$this->LanguagesObj()->Language_Data_Name_Get($this,$data);
            }
        }
        else
        {
            $longname=
                $this->LanguagesObj()->Language_Data_Get_If_Defined
                (
                    $this,
                    $data,"Long"
                );
        
            if (!empty($longname))
            {
                $name=$longname;
            }
        }

        if (empty($title)) { $title=$name; }
        if ($addcolon)     { $name.=":"; }
        
        $add="";
        if ($addmsg && $this->MyMod_Data_Field_Compulsory($data))
        {
            $add=$dagger;
            if (
                   $this->LoginType!="Public"
                   &&
                   empty($item[ $data ])
                )
             {
                 $title.=
                     " - ".
                     $this->MyLanguage_GetMessage("CompulsoryFieldTag").
                     "!";
             }
        }

        if (!empty($this->ItemData[ $data ][ "Title_Info_Method" ]))
        {
            $method=$this->ItemData[ $data ][ "Title_Info_Method" ];
            $add.=
                $this->BR().
                $this->$method($data);
        }
        
        $options[ "TITLE" ]=$title;
        return
            $this->Htmls_Span
            (
                array
                (
                    $this->LanguagesObj()->Message_Debug_Pre
                    (
                        $this->LanguagesObj()->Language_Data_Type,
                        $data,
                        array
                        (
                            "Module" => $this->ModuleName,
                        )
                    ),
                    $this->B($name),
                    $add
                ),
                $options
            );
    }

    
    //*
    //* function MyMod_Item_Data_Set, Parameter list: &$item,$data,$value
    //*
    //* Make sure Item $data has been set.
    //*

    function MyMod_Item_Data_Set(&$item,$data,$value)
    {
        $rdata="";
        if (empty($item[ $data ]) || $item[ $data ]!=$value)
        {
            $item[ $data ]=$value;
            $rdata=$data;
        }

        return $rdata;
    }
}

?>