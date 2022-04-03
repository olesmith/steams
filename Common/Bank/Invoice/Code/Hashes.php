<?php

trait Bank_Invoice_Code_Hashes
{
    //*
    //* 
    //* 

    function Bank_Invoice_Code_Hash_1(&$hash)
    {        
        $year=
            sprintf
            (
                "%02d",
                $this->PeriodsObj()->Sql_Select_Hash_Value
                (
                    $hash[ "Period" ],
                    "Year"
                )-2000
            );

        $hash[ "Bank" ]=$this->School("Bank");
        $hash[ "YY" ]=$year;
        $hash[ "Currency" ]=$this->Bank_Invoice_Currency;
        $hash[ "Register" ]=$this->Bank_Invoice_Register;
        $hash[ "Cart" ]=$this->Bank_Invoice_Cart;
        $hash[ "Byte" ]=$this->Bank_Invoice_Byte;
        
        $codes=
            array
            (
                $hash[ "Bank" ],
                $hash[ "Currency" ],
                $hash[ "Register" ],
                ".",
                $hash[ "Cart" ],
                $hash[ "YY" ],
                $hash[ "Byte" ],
            );

        $hash[ "Digit_1" ]=
            $this->Bank_Invoice_Code_Digit_1($codes);
        
        array_push
        (
            $codes,
            $hash[ "Digit_1" ]
        );
        
        return join("",$codes);       
    }

    //*
    //* 
    //*

    function Bank_Invoice_Code_Hash_Agency(&$hash)
    {
        return
            sprintf("%04d",$this->School("Bank_Agency"));
    }
    
    //*
    //* 
    //*

    function Bank_Invoice_Code_Hash_OurNumber(&$hash)
    {
        return
            sprintf("%05d",$this->Payment_Number($hash));
    }
    
    //*
    //* 
    //*

    function Bank_Invoice_Code_Hash_2(&$hash)
    {
        $ournumber=
            $this->Payment_Number($hash);

        
        $hash[ "OurNumber" ]=
            $this->Bank_Invoice_Code_Hash_OurNumber($hash);
        
        $hash[ "OurNumber_Digit" ]=
            $this->Bank_Invoice_Code_Digit_OurNumber($hash);
        
        $hash[ "Agency" ]=
            $this->Bank_Invoice_Code_Hash_Agency($hash);
        
        $codes=
            array
            (
                $hash[ "OurNumber" ],
                ".",
                $hash[ "OurNumber_Digit" ],
                $hash[ "Agency" ],
            );

        $hash[ "Digit_2" ]=$this->Bank_Invoice_Code_Digit_2($codes);
        
        array_push
        (
            $codes,
            $hash[ "Digit_2" ]
        );

        return join("",$codes);
    }
    
    //*
    //* 
    //*

    function Bank_Invoice_Code_Hash_3(&$hash)
    {
        $account=
            sprintf("%05d",$this->School("Bank_Account"));

        $hash[ "Operation" ]=
            sprintf("%02d",$this->School("Bank_Operation"))
            ;
        $hash[ "Account" ]=
            sprintf("%05d",$this->School("Bank_Account"));
        
        $hash[ "Account_1" ]=
            substr($hash[ "Account" ],0,3);
        
        $hash[ "Account_2" ]=
            substr($hash[ "Account" ],3,2);
        
        $hash[ "Without" ]=$this->Bank_Invoice_Without;
        $hash[ "Fixed" ]=$this->Bank_Invoice_Fixed;
        
        $hash[ "Free" ]=
            $this->Bank_Invoice_Code_Digit_Free($hash);
        
        $codes=
            array
            (
                $hash[ "Operation" ],
                $hash[ "Account_1" ],
                ".",
                $hash[ "Account_2" ],
                $hash[ "Without" ],
                $hash[ "Fixed" ],
                $hash[ "Free" ]
            );


        $hash[ "Digit_3" ]=
            $this->Bank_Invoice_Code_Digit_3($codes);

        array_push
        (
            $codes,
            $hash[ "Digit_3" ]
        );

        return join("",$codes);
    }


    //*
    //* 
    //*

    function Bank_Invoice_Code_Hash_4(&$hash,$codes)
    {
        $hash[ "Digit_4" ]=
            $this->Bank_Invoice_Code_Digit_General($hash);

        return $hash[ "Digit_4" ];
    }

    //*
    //* 
    //*

    function Bank_Invoice_Code_Hash_5(&$hash)
    {
        $datetime1 = date_create($hash[ "Due" ]);
        $datetime2 = date_create("20000703");
        
        $diff=date_diff($datetime1,$datetime2);

        $hash[ "Date_Weight" ]=
            $diff->format("%a")+1000;
        
        $value=$this->Payment_Calculate_Amount($hash);        
        $value=100*$value;
        $value=floor($value);
        $hash[ "Value" ]=sprintf("%010d",$value);
        
        $comps=
            array
            (
                $hash[ "Date_Weight" ],
                $hash[ "Value" ]
            );

        return join("",$comps);
    }
}
?>