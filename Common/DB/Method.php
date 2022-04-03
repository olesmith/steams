<?php


trait DB_Method
{
    //Turns method names into db type names. Currently only MySql.

    //*
    //* function DB_Method, Parameter list: $method
    //*
    //* Returns DB_$type_$function, where $type is $this->DBHash[ "Type" ].
    //*

    function DB_Method($method,$arg1)
    {
        $type=NULL;
        if (is_array($arg1) && !empty($arg1[ "Type" ]))
        {
            $type=$arg1[ "Type" ];
        }
        else
        {
            $type=$this->DBHash("Type");
        }
        
        return "DB_".$type."_".$method;
    }

    //*
    //* function DB_Method_Call, Parameter list: $method,$arg1=null,$arg2=null,$arg3=null,$arg4=null,$arg5=null
    //*
    //* Returns DB_$type_$function, where $type is $this->DBHash[ "Type" ].
    //*

    function DB_Method_Call($method,$arg1=null,$arg2=null,$arg3=null,$arg4=null,$arg5=null)
    {
        $method=$this->DB_Method($method,$arg1);
        
        return $this->$method($arg1,$arg2,$arg3,$arg4,$arg5);
    }
}

?>