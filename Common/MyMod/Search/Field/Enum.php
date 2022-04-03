<?php


trait MyMod_Search_Field_Enum
{
    //*
    //* function MyMod_Search_Field_Enum, Parameter list: $data,$rdata,$rval
    //*
    //* Creates enum type search field.
    //*

    function MyMod_Search_Field_Enum($data,$rdata,$rval)
    {
        if ($this->ItemData[ $data ][ "GETSearchVarName" ])
        {
            $getvalue=$this->GetGET($this->ItemData[ $data ][ "GETSearchVarName" ]);
            if (!empty($getvalue))
            {
                //return $this->Values[ $getvalue-1 ];
                if (empty($rval))
                {
                    $rval=$getvalue;
                }
            }
        }
        
        $item=array();
        if (
              is_array($this->ItemData[ $data ][ "ValuesMatrix" ]) &&
              $this->ItemData[ $data ][ "ValuesDependencyVar" ]!=""
           )
        {
            $item[ $this->ItemData[ $data ][ "ValuesDependencyVar" ] ]=
                $this->MyMod_Search_CGI_Value($this->ItemData[ $data ][ "ValuesDependencyVar" ]);
        }

        $checkbox=FALSE;
        if (!empty($this->ItemData[ $data ][ "SearchCheckBox" ]))
        {
            $checkbox=1;
        }
        elseif (!empty($this->ItemData[ $data ][ "SearchRadioSet" ]))
        {
            $checkbox=2;
        }

        //Need to change ItemData NoSort - why?
        $tmp=$this->ItemData[ $data ][ "NoSort" ];

        if (!empty($this->ItemData[ $data ][ "NoSelectSort" ]))
        {
            $this->ItemData[ $data ][ "NoSort" ]=$this->ItemData[ $data ][ "NoSelectSort" ];
        }

        $value=
           $this->MyMod_Data_Field_Enum_Edit
           (
              $data,
              $item,
              $rval,
              0,//tabindex
              False, //plural,
              "", //links
              0,//callmethod,
              $rdata,
              True
           );

        //Restore ItemData NoSort
        $this->ItemData[ $data ][ "NoSort" ]=$tmp;

        return $value;
   }
}

?>