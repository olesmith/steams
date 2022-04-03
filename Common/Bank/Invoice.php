<?php

include_once("Invoice/Code.php");

trait Bank_Invoice
{
    use
        Bank_Invoice_Code;
    
    var $Bank_Invoice_Currency=9;
    var $Bank_Invoice_Register=1;
    var $Bank_Invoice_Cart=1;
    var $Bank_Invoice_Byte=1;
    var $Bank_Invoice_Without=1;
    var $Bank_Invoice_Fixed=0;
    var $Bank_Invoice_Free=1;

        
    //*
    //* 
    //*

    function Dot_Product($v1,$v2)
    {
        if (count($v1)!=count($v2))
        {
            $this->ApplicationObj()->MyApp_Interface_Message_Add
            (
                "Not same number of eklements in vectors: ".
                join("",$v1).
                " - ".
                join("",$v2)
            );
        }

        $nmax=min(count($v1),count($v2));
        
        $dot=0;
        for ($n=0;$n<$nmax;$n++)
        {
            $val=intval($v1[ $n ])*intval($v2[ $n ]);

            
            if ($val>9)
            {
                $val=1+($val%10);
            }

            $dot+=$val;            
        }
        

        return $dot;
    }
    
}
?>