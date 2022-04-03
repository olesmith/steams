<?php


trait MyMod_Data_Fields_Text
{
    //*
    //* function MyMod_Data_Fields_Text_Edit, Parameter list: $data,$item,$value="",$tabindex="",$plural=FALSE,$links=TRUE,$callmethod=TRUE,$options=array(),$rdata=""
    //*
    //* Creates TEXT AREA inout field.
    //*

    function MyMod_Data_Fields_Text_Edit($data,$item,$value="",$tabindex="",$plural=FALSE,$options=array(),$rdata="")
    {
        if (empty($rdata)) { $rdata=$data; }
        
        $size=$this->ItemData[ $data ][ "Size" ];
        if ($plural && $this->ItemData[ $data ][ "TableSize" ]!="")
        {
            $size=$this->ItemData[ $data ][ "TableSize" ];
        }

        $size=preg_split('/\s*x\s*/',$size);

        if (!empty($this->ItemData[ $data ][ "Input_Class" ]))
        {
            if (empty($options[ "CLASS" ])) { $options[ "CLASS" ]=array(); }
            if (!is_array($options[ "CLASS" ])) { $options[ "CLASS" ]=array($options[ "CLASS" ]); }

            array_push
            (
                $options[ "CLASS" ],
                $this->ItemData[ $data ][ "Input_Class" ]
            );
        }

        $options[ "ID"]=
            join
            (
                "_",
                $this->MyMod_Data_Field_Enum_Classes($data,$item)
            );
        
        $rows=50;
        if (count($size)>0) { $rows=$size[0]; }
        
        $cols=5;
        if (count($size)>1) { $cols=$size[1]; }

        $value=preg_replace('/^\s+/',"",$value);
        $value=preg_replace('/\s+$/',"",$value);

        if ($cols>1)
        {
            $value=
                $this->Htmls_Input_Text_Area
                (
                    $rdata,
                    $cols,
                    $rows,
                    $value,
                    $options
                );
        }
        else
        {
            $options[ "SIZE" ]=$rows;
            $value=
                $this->Htmls_Input_Text
                (
                    $rdata,$value,$options
                );
        }

        return $value;
    }
    
    //*
    //* function MyMod_Data_Fields_Text_Show, Parameter list: $data,$item,$value="",$tabindex="",$plural=FALSE,$links=TRUE,$callmethod=TRUE,$options=array(),$rdata=""
    //*
    //* Creates TEXT AREA input field.
    //*

    function MyMod_Data_Fields_Text_Show($data,$item,$value="",$options=array())
    {
        if (empty($value) && isset($item[ $data ]))
        {
            $value=$item[ $data ];
        }
        
        if (empty($options[ "NoBR" ]))
        {
            $value=preg_replace('/\n/',$this->BR(),$value);
        }
        
        //Remove leading and trailing white space
        $value=preg_replace('/^\s+/',"",$value);
        $value=preg_replace('/\s+$/',"",$value);


        return $value;
    }
    
 }

?>