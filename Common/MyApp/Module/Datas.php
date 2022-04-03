<?php

trait MyApp_Module_Datas
{
    //*
    //* function MyApp_Module_Data_Get, Parameter list: $module,$item,$data,$key=""
    //*
    //* Submodules read get acessor.
    //*

    function MyApp_Module_Data_Get($module,$item,$data,$key="")
    {
        $res=False;
        if (!empty($item[ $data ]))
        {
            $value=$item[ $data ];
            if (!empty($this->__Datas__[ $data ]))
            {
                if (!empty($key))
                {
                    if (isset($this->__Datas__[ $data ][ $value ][ $key ]))
                    {
                        $res=$this->__Datas__[ $data ][ $value ][ $key ];
                    }
                    else
                    {
                        var_dump
                        (
                            "Warningggg! MyApp_Module_Data_Get #1: ".
                            "Module ".$module.", ".
                            "No data=".$data." ".
                            "value=".$value." ".
                            "key=".$key.
                            "",
                            $this->__Datas__[ $data ]
                        );

                        exit();
                    }
                            
                }
                else
                {
                    
                    $res=$this->__Datas__[ $data ][ $value ];
                }
            }
            else
            {
                var_dump
                (
                    "Warning! MyApp_Module_Data_Get #2:".
                    "Module ".$module.", ".
                    "No ".$data." ".
                    "key in __Datas__".
                    "",
                    array_keys($this->__Datas__)
                );
            }
        }
        else
        {
            var_dump
            (
                "Warning! MyApp_Module_Data_Get #3:".
                "Module ".$module.", ".
                "Item data=".$data." ".
                "empty".
                ""
            );
        }

        return $res;
    }
    
    //*
    //* function MyApp_Module_Data_Set, Parameter list: $module,$item,$value,$data,$key=""
    //*
    //* Submodules read set acessor.
    //*

    function MyApp_Module_Data_Set($module,$item,$value,$data,$key="")
    {
        $res=False;
        if (!empty($item[ $data ]))
        {
            $rvalue=$item[ $data ];
            if (!empty($this->__Datas__[ $data ]))
            {
                if (!empty($key))
                {
                    $this->__Datas__[ $data ][ $rvalue ][ $key ]=$value;
                    $res=True;
                }
                else
                {
                    
                    $this->__Datas__[ $data ][ $rvalue ]=$value;
                    $res=True;
                }
            }
            else
            {
                var_dump
                (
                    "MyApp_Module_Data_Set #:".
                    "Module ".$module.
                    $data." not in __Datas__"
                );
            }
        }
        else
        {
            var_dump
            (
                "MyApp_Module_Data_Set #2: ".
                "Module ".$module.
                "Item has no key $data",
                array_keys($this->__Datas__)
            );
        }

        return $res;
    }
    
}

?>