<?php

include_once("Code/Hashes.php");
include_once("Code/Digits.php");
include_once("Code/Decorate.php");

trait Bank_Invoice_Code
{
    use
        Bank_Invoice_Code_Decorate,
        Bank_Invoice_Code_Hashes,
        Bank_Invoice_Code_Digits;
    
    //*
    //* Generate (full) code as string.
    //* 

    function Bank_Invoice_Code_Line(&$hash,$sep=" ")
    {
        return
            join
            (
                $sep,
                $this->Bank_Invoice_Codes($hash)
            );
    }

    //*
    //* Generate (full) code as string.
    //* 

    function Bank_Invoice_Code_With_Digit(&$hash)
    {
        $code=$this->Bank_Invoice_Code($hash);

        $hash[ "Digit_4" ]=
            $this->Bank_Invoice_Code_Digit_Calc($code);

        $code1=substr($code,0,4);
        $code2=preg_replace('/^'.$code1.'/',"",$code);

        
        return
            $code1.
            $hash[ "Digit_4" ].
            $code2;        
    }
    
    
    //*
    //* Generate (full) code as string.
    //* 

    function Bank_Invoice_Code(&$hash)
    {
        return
            $hash[ "Bank" ].
            $hash[ "Currency" ].
            $hash[ "Date_Weight" ].
            $hash[ "Value" ].
            
            $hash[ 'Register' ].
            $hash[ 'Cart' ].
            //"-".
            $hash[ 'YY' ].
            $hash[ 'Byte' ].
            $hash[ 'OurNumber' ].
            //"-".
            $hash[ 'OurNumber_Digit' ].
            //"-".
            $hash[ 'Agency' ].
            $hash[ 'Operation' ].
            $hash[ 'Account' ].
            "10".
            $this->Bank_Invoice_Code_Digit_Free($hash).
            "";
    }


    //*
    //* Generates code as list of 5 codes.
    //* 

    function Bank_Invoice_Codes(&$hash)
    {
        $code1=$this->Bank_Invoice_Code_Hash_1($hash);
        $code3=$this->Bank_Invoice_Code_Hash_3($hash);

        $codes=
            array
            (
                $code1,
                $this->Bank_Invoice_Code_Hash_2($hash),
                $code3,
                "", //fill in last
                $this->Bank_Invoice_Code_Hash_5($hash),
            );

       $codes[3]=
            $this->Bank_Invoice_Code_Hash_4($hash,$codes);

        return $codes;
    }

    
   /* //\* */
   /*  //\* Tests full code. */
   /*  //\*  */

   /*  function Bank_Invoice_Codes_Test($codes) */
   /*  { */
   /*      $html=array(); */
   /*      foreach ($codes as $code) */
   /*      { */
   /*          $html= */
   /*              array_merge */
   /*              ( */
   /*                  $html, */
   /*                  $this->Bank_Invoice_Code_Test($code) */
   /*              ); */
   /*      } */

   /*      return $html; */
   /*  } */
    
   /*  //\* */
   /*  //\* Tests full code. */
   /*  //\*  */

   /*  function Bank_Invoice_Code_Test($code) */
   /*  { */
   /*      $codes=$code; */
   /*      if (is_string($code)) */
   /*      { */
   /*          $codes=preg_split('/\s+/',$codes); */
   /*      } */
        
   /*      $html=array(array(),$this->BR(),array(),$this->BR(),); */

   /*      //1st field (9 digits) */
   /*      $texts=$this->Bank_Invoice_Code_Test_N($codes[0],1); */

   /*      array_push($html[0],$texts[0]); */
   /*      array_push($html[2],$texts[1]); */

        
   /*      //2nd field (9 digits) */
   /*      $texts=$this->Bank_Invoice_Code_Test_N($codes[1],2); */
        
   /*      array_push($html[0],$texts[0]); */
   /*      array_push($html[2],$texts[1]); */

        
   /*      //3rd field (9 digits) */
   /*      $texts=$this->Bank_Invoice_Code_Test_N($codes[2],2); */

   /*      array_push($html[0],$texts[0]); */
   /*      array_push($html[2],$texts[1]); */
        
        
   /*      //4th field: General digit */
   /*      $texts=$this->Bank_Invoice_Code_Test_General($codes); */
        
   /*      array_push($html[0],$texts[0]); */
   /*      array_push($html[2],$texts[1]); */

        
   /*      //5th field: date and value */
   /*      array_push($html[0],$codes[4]); */
   /*      array_push($html[2],$codes[4]); */


   /*      $this->Bank_Invoice_Code_Test_OurNumber($codes); */
        
   /*      return $html; */
   /*  } */

   /*  //\* */
   /*  //\* Tests $nth code: generates digit and compares. */
   /*  //\*  */

   /*  function Bank_Invoice_Code_Test_N($code,$n) */
   /*  { */
   /*      $rcode=$code; */
   /*      $code=preg_replace('/[^\d]/',"",$code); */
   /*      $rdigit=substr($code,strlen($code)-1,strlen($code)); */

   /*      $code=substr($code,0,strlen($code)-1); */

   /*      $method="Bank_Invoice_Code_Digit_".$n; */
   /*      $digit= */
   /*          $this->$method($code); */

   /*      $color='green'; */
   /*      if ($digit!=$rdigit) */
   /*      { */
   /*          $color='red'; */
   /*      } */

   /*      return */
   /*          array */
   /*          ( */
   /*              $rcode.$rdigit, */
   /*              $rcode. */
   /*              $this->Html_Color */
   /*              ( */
   /*                  $color, */
   /*                  $digit */
   /*              ), */
   /*          ); */
   /*  } */

   /*  //\* */
   /*  //\* Tests $nth code: generates digit and compares. */
   /*  //\*  */

   /*  function Bank_Invoice_Code_Test_OurNumber($codes) */
   /*  { */
   /*      $code1=preg_replace('/[^\d]/',"",$codes[0]); */
   /*      $code2=preg_replace('/[^\d]/',"",$codes[1]); */
   /*      $code3=preg_replace('/[^\d]/',"",$codes[2]); */

   /*      $digit=substr($code2,5,1); */
        
   /*      $code= */
   /*          substr($code2,6,4).//agency */
   /*          substr($code3,0,2).//operator */
   /*          substr($code3,2,5).//account */
   /*          substr($code1,6,2).//yy */
   /*          substr($code1,8,1).//byte? */
   /*          substr($code2,0,5).//ournumber */
   /*          "";             */

   /*      $weights="4329876543298765432"; */
        
   /*      $code=str_split($code); */
   /*      $weights=str_split($weights); */

   /*      $dot=0; */
   /*      for ($n=0;$n<19;$n++) */
   /*      { */
   /*          $dot+=intval($code[$n])*intval($weights[$n]); */
            
   /*      } */

   /*      $div=$dot%11; */
   /*      $diff=11-$div; */

   /*      $rdigit=$diff; */
   /*      if ($diff==10|| $diff==11) */
   /*      { */
   /*          $rdigit=0; */
   /*      } */
        
   /*      var_dump(join("",$code),substr($code1,8,1), */
   /*      $digit,$rdigit); */
            
   /*  } */
    
   /*  //\* */
   /*  //\* Tests $nth code: generates digit and compares. */
   /*  //\*  */

   /*  function Bank_Invoice_Code_Test_General($codes) */
   /*  { */
   /*      $digit=$codes[3]; */


   /*      $rdigit= */
   /*          $this->Bank_Invoice_Code_Digit_General($codes); */


   /*      $color='green'; */
   /*      if ($digit!=$rdigit) */
   /*      { */
   /*          $color='red'; */
   /*      } */

   /*      return */
   /*          array */
   /*          ( */
   /*              $rdigit, */
   /*              $this->Html_Color */
   /*              ( */
   /*                  $color, */
   /*                  $digit */
   /*              ), */
   /*          );        */
   /*  } */
}
?>