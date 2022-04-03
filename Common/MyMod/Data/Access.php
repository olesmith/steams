<?php

trait MyMod_Data_Access
{
    var $Data_Permissions_DB=True;
    
    //*
    //* function MyMod_Data_Permissions_Get, Parameter list: $data
    //*
    //* Generates data field.
    //*

    function MyMod_Data_Permissions_Get($data)
    {
        $perms=array();
        if ($this->Data_Permissions_DB)
        {
            $perms=
                $this->LanguagesObj()->Permissions_Get
                (
                    $this->LanguagesObj()->Language_Data_Type,
                    $data,
                    $this->ItemData($data),
                    $this->ModuleName
                );
        }

        $fixed=$this->ItemData($data,"Perms_Fixed");
        if (!empty($fixed))
        {
           $perms[ $this->Profile() ]=$fixed;
           $perms[ $this->LoginType() ]=$fixed;
        }
        
        /* if (!isset($perms[ $rdata ])) */
        /* { */
        /*     var_dump("Empty data permissions, ".$this->ModuleName.", data: ".$rdata,$perms); */
        /* } */
        
        return $perms;
    }

    
    //*
    //* function MyMod_Data_Access, Parameter list: $data,$item=array()
    //*
    //* Generates data field.
    //*

    function MyMod_Data_Access($data,$item=array(),$callmethod=TRUE)
    {
        $itemdata=$this->ItemData($data);
        if (empty($itemdata)) { return 0; }

        $perms=$this->MyMod_Data_Permissions_Get($data);


        $lres=$perms[ $this->LoginType() ];
        $pres=$perms[ $this->Profile() ];

        $res=$this->Max($lres,$pres);

        if ($data=="ID") { $res=$this->Min($res,1); }
            
        if ($res==2)
        {
            if ($this->ReadOnly) 
            {
                $res=1;
            }
            elseif (!empty($itemdata[ "ReadOnly" ]))
            {
                $res=1;
            }
            elseif (!empty($itemdata[ $this->LoginType."ReadOnly" ]))
            {
                
                $res=1;
            }
            elseif (!empty($item[ $data."_ReadOnly" ]))
            {
                $res=1;
            }
        }

        if
            (
                $res==2
                &&
                !empty($itemdata[ "PermsMethod" ])
                &&
                $callmethod
            )
        {
            $method=$itemdata[ "PermsMethod" ];
            return $this->$method($data,$item,$res);
        }

        

        return $res;
    }
}

?>