<?php

trait Bank_Invoice_Code_Decorate
{
    var $Bank_Invoice_Code_Decorate_Colors=
        array
        (
            "Bank"      => "grey",
            "Currency"  => "magenta",
            "Register"  => "black",
            
            "Bank"      => "black",
            "Cart"      => "black",
            "YY"        => "blue",
            "Byte"      => "grey",
            "Digit_1"   => "green",
            
            "OurNumber"       => "orange",
            "OurNumber_Digit" => "orange",
            
            "Agency"    => "blue",
            "Digit_2"   => "green",

            
            "Operation" => "grey",
            
            "Account"   => "blue",
            "Account_1" => "blue",            
            "Account_2" => "blue",
            
            "Without"   => "grey",
            "Fixed"     => "grey",
            "Free"      => "red",
            
            "Digit_3"   => "green",
            "Digit_4"   => "brown",
            
            "Date_Weight" => "blue",
            "Value"       => "red",
        );
    //*
    //* 
    //* 

    function Bank_Invoice_Code_Decorate($hash)
    {
        $code=$this->Bank_Invoice_Code($hash);

        return
            join
            (
                "",
                array
                (
                    $this->Bank_Invoice_Code_Decorate_Keys
                    (
                        $hash,
                        array
                        (
                            "Bank",
                            "Currency",
                            "Digit_4",
                            "Date_Weight",
                            "Value",
                            "Register",
                            "Cart",
                            "YY",
                            "Byte",
                            "OurNumber",
                            "OurNumber_Digit",
                            "Agency",
                            "Operation",
                            "Account",
                        )
                    ),
                    "10",
                    $this->Bank_Invoice_Code_Decorate_Key($hash,"Free"),
                )
            );
    }
    
    //*
    //* 
    //* 

    function Bank_Invoice_Code_Line_Decorate($hash)
    {
        $code=$this->Bank_Invoice_Code_Line($hash);
        
        return
            join
            (
                "&nbsp;",
                array
                (
                    $this->Bank_Invoice_Code_Decorate_Datas
                    (
                        $hash,
                        array
                        (
                            "Bank",
                            "Currency",
                            "Register",
                        ),
                        array
                        (
                            "Cart",
                            "YY",
                            "Byte",
                            "Digit_1"
                        )
                    ),
                    $this->Bank_Invoice_Code_Decorate_Datas
                    (
                        $hash,
                        array
                        (
                            "OurNumber",
                        ),
                        array
                        (
                            "OurNumber_Digit",
                            "Agency",
                            "Digit_2"
                        )
                    ),
                    
                    $this->Bank_Invoice_Code_Decorate_Datas
                    (
                        $hash,
                        array
                        (
                            "Operation",
                            "Account_1",
                        ),
                        array
                        (
                            "Account_2",
                            "Without",
                            "Fixed",
                            "Free",
                            "Digit_3"
                        )
                    ),
                    $this->Bank_Invoice_Code_Decorate_Key
                    (
                        $hash,"Digit_4"
                    ),
                    $this->Bank_Invoice_Code_Decorate_Keys
                    (
                        $hash,
                        array
                        (
                            "Date_Weight",
                            "Value"
                        )
                    )
                )
            );
    }

    
     //*
    //* 
    //* 

    function Bank_Invoice_Code_Decorate_Datas($hash,$keys1,$keys2)
    {
        return
            join
            (
                ".",
                array
                (
                    $this->Bank_Invoice_Code_Decorate_Keys
                    (
                        $hash,
                        $keys1
                    ),
                    $this->Bank_Invoice_Code_Decorate_Keys
                    (
                        $hash,
                        $keys2
                    ),
                )
            );
    }
    
    //*
    //* 
    //* 

    function Bank_Invoice_Code_Decorate_Keys($hash,$keys)
    {
        $rkeys=array();
        foreach ($keys as $key)
        {
            array_push
            (
                $rkeys,
                $this->Bank_Invoice_Code_Decorate_Key($hash,$key)
            );
            
        }
        
        return join("",$rkeys);
    }
    
    //*
    //* 
    //* 

    function Bank_Invoice_Code_Decorate_Key($hash,$key)
    {
        return
            $this->Html_Color
            (
                $this->Bank_Invoice_Code_Decorate_Colors[ $key ],
                $hash[ $key ]
            );            
    }
}