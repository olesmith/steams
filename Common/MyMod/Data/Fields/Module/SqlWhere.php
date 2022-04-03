<?php


trait MyMod_Data_Fields_Module_SqlWhere
{
    //*
    //* Generates $data object select field.
    //*

    function MyMod_Data_Fields_Module_SqlWhere($data,$item)
    {
        $where="";
        if (!empty($this->ItemData[ $data ][ "SqlWhere_Method" ]))
        {
            $method=$this->ItemData[ $data ][ "SqlWhere_Method" ];

            if (method_exists($this,$method))
            {
                $where=$this->$method($data,$item);
            }
            else
            {
                var_dump("MyMod_Data_Fields_Module: MyMod_Data_Fields_Module_SqlWhere");
                var_dump("No such Where Clause method: ".$method);
                var_dump($method."(\$data,\$item): array()");
            }
        }
        elseif (!empty($this->ItemData[ $data ][ "SqlWhere" ]))
        {
            $where=$this->ItemData[ $data ][ "SqlWhere" ];
        }
        elseif (!empty($this->ItemData[ $data ][ "SqlWhere".$this->Profile() ]))
        {
            $where=$this->ItemData[ $data ][ "SqlWhere".$this->Profile() ];
        }
        elseif (!empty($this->ItemData[ $data ][ "SqlWhere".$this->LoginType() ]))
        {
            $where=$this->ItemData[ $data ][ "SqlWhere".$this->LoginType() ];
        }
        else
        {
            $module=$this->ItemData[ $data ][ "SqlClass" ]."Obj";
            if (method_exists($this->$module(),"SqlWhere"))
            {
                $where=
                    $this->$module()->SqlWhere
                    (
                        array("ID" => $item[ $data ])
                    );
            }
        }

        if (is_array($where))
        {
            $where=$this->Hash2SqlWhere($where);
        }

        return
            $this->ApplicationObj->FilterObject
            (
                $this->FilterHash
                (
                    $this->FilterHash($where,$this->LoginData),
                    $item
                )
            );

        return $where;
    }
}

?>
