<?php

trait Bank_Invoice_Code_Digits
{
    //*
    //* 
    //*

    function Bank_Invoice_Code_Digit_1($code)
    {
        if (is_array($code)) { $code=join("",$code); }
        
        $code=preg_replace('/[^\d]/',"",$code);
        
        $codes=str_split($code);
        
        $weights=array(2,1,2,1,2,1,2,1,2);

        $dot=$this->Dot_Product($codes,$weights);

        $mult=intval(ceil($dot/10)*10);
        

        $diff=$mult-$dot;
        
        //var_dump($dot,$mult,$diff,$code,join("",$weights));
        return $diff;
    }

    //*
    //* 
    //*

    function Bank_Invoice_Code_Digit_2($code)
    {
        if (is_array($code)) { $code=join("",$code); }
        
        $code=preg_replace('/[^\d]/',"",$code);
        
        $codes=str_split($code);
        
        $weights=array(1,2,1,2,1,2,1,2,1,2);

        $dot=$this->Dot_Product($codes,$weights);

        $mult=intval(ceil($dot/10)*10);
        

        $diff=$mult-$dot;
        
        //var_dump($dot,$mult,$diff,$code,join("",$weights));
        return $diff;
    }
    
    
    //*
    //* 
    //*

    function Bank_Invoice_Code_Digit_3($code)
    {
        if (is_array($code)) { $code=join("",$code); }
        
        $code=preg_replace('/[^\d]/',"",$code);
        
        $codes=str_split($code);
        
        $weights=array(1,2,1,2,1,2,1,2,1,2);

        $dot=$this->Dot_Product($codes,$weights);

        $mult=intval(ceil($dot/10)*10);
        

        $diff=$mult-$dot;
        
        //var_dump($dot,$mult,$diff,$code,join("",$weights));
        return $diff;
    }
    
    //*
    //* 
    //*

    function Bank_Invoice_Code_Digit_Calc($code,$mod=11,$ww="23456789")
    {
        $code=preg_replace('/[^\d]/',"",$code);
        //var_dump($code);
        $code=strrev($code);
        
        $weights="";
        while (strlen($weights)<strlen($code))
        {
            $weights.=$ww;
        }

        $v1=str_split($code);
        $v2=str_split($weights);

        $dot=0;
        for ($n=0;$n<strlen($code);$n++)
        {
            $dot+=intval($v1[ $n ])*intval($v2[ $n ]);            
        }

        $div=intval(floor($dot/$mod));
        $rest=$dot-$mod*$div;

        $digit=$mod-$rest;
        if ($rest==0 || $rest==1 || $rest>9)
        {
            $digit=1;
        }

        //var_dump(strlen($code),$weights.": Rest $rest, $digit");

        return $digit;        
    }
    
    //*
    //* 
    //*

    function Bank_Invoice_Code_Digit_General($hash)
    {
        $code=$this->Bank_Invoice_Code($hash);
        
        return $this->Bank_Invoice_Code_Digit_Calc($code);
    }


    //*
    //* 
    //*

    function Bank_Invoice_Code_Digit_Free($hash)
    {
        $weights="98765432"."98765432"."98765432";

        $code=
            $hash[ "Register" ].
            $hash[ "Cart" ].
            $hash[ "YY" ].
            $hash[ "Byte" ].
            sprintf("%05d",$hash[ "Number" ]).
            $this->Bank_Invoice_Code_Digit_OurNumber($hash).
            sprintf("%04d",$this->Bank_Invoice_Code_Hash_Agency($hash)).
            $hash[ "Operation" ].
            sprintf("%05d",$hash[ "Account" ]).
            "10";

        //$code="110720000310165020062310";

        $v1=str_split($code);
        $v2=str_split($weights);

        $dot=0;
        for ($n=0;$n<strlen($weights);$n++)
        {
            $dot+=intval($v1[ $n ])*intval($v2[ $n ]);            
        }

        $div=intval(floor($dot/11));

        $rest=$dot % 11;
        $digit=11-$rest;
        //var_dump( "$code: $dot dig $digit");
        return $digit;
    }
    
    //*
    //* 
    //*

    function Bank_Invoice_Code_Digit_OurNumber($hash)
    {
        $weights="432"."98765432"."98765432";

        $code=
            $this->Bank_Invoice_Code_Hash_Agency($hash).
            $hash[ "Operation" ].
            $hash[ "Account" ].
            $hash[ "YY" ].
            $hash[ "Byte" ].
            $this->Bank_Invoice_Code_Hash_OurNumber($hash).
            "";

        $v1=str_split($code);
        $v2=str_split($weights);

        $dot=0;
        for ($n=0;$n<strlen($weights);$n++)
        {
            $dot+=intval($v1[ $n ])*intval($v2[ $n ]);            
        }

        $div=intval(floor($dot/11));

        $rest=$dot-$div*11;
        $minus=11-$rest;

        $digit=$minus;
        if ($digit>10) { $digit=0; }
        
        //var_dump($weights,$code,$div,$rest,$minus,$digit);
        return $digit;
    }
}
?>