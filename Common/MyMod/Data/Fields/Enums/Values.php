<?php

trait MyMod_Data_Fields_Enums_Values
{
    //*
    //* Returns TITLEs to display in SELECT field.
    //*

    function MyMod_Data_Field_Enum_Values($data)
    {
        $values=array();
        if (
            is_array($this->ItemData[ $data ][ "ValuesMatrix" ]) &&
            $this->ItemData[ $data ][ "ValuesDependencyVar" ]!=""
           )
        {
            $val=$item[ $this->ItemData[ $data ][ "ValuesDependencyVar" ] ];
            if ($val!="" && $val>0)
            {
                $values=$this->GetDependentEnumValues($data,$item,FALSE);
            }
        }
        else
        {
            $values=$this->GetRealNameKey($this->ItemData[ $data ],"Values");
            if (!is_array($values) || count($values)==0)
            {
                if (!empty($this->ItemData[ $data ][ "SqlClass" ]))
                {
                    $values=array();
                    $this->ReadSubItemValues($data,$item);
                }
                else
                {
                    $this->Debug=1;
                    $this->AddMsg("ENUM data $data has no values set");
                    $values=array();
                }
            }
        }

        $n=0;
        $keys=array_keys($values);
        if (count($keys)>0)
        {
            //Values is array, we need only the keys
            if (is_array($values[ $keys[0] ]))
            {
                $values=$keys;
            }
        }

        $sorteds=array();
        $rvalues=array();
        foreach ($values as $val)
        {
            $sorteds[ $val ]=$n;
            array_push($rvalues,$val);

            $n++;
        }

        if
            (
                !$this->ItemData[ $data ][ "NoSort" ]
                &&
                !$this->ItemData[ $data ][ "NoSelectSort" ]
            )
        {
            sort($rvalues,SORT_STRING);
        }
        

        $values=array(0);

        $n=1;
        foreach ($rvalues as $val)
        {
            array_push($values,$sorteds[ $val ]+1);
            $n++;
        }
        
        return $values;
    }    
}

?>