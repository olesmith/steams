<?php

include_once("JSON/Query.php");
include_once("JSON/Parse.php");
include_once("JSON/Read.php");


trait JSON
{
    use
        JSON_Query,
        JSON_Parse,
        JSON_Read;
    
    var $JSON_Limit="100";
    var $JSON_Name="";
    
    ##! 
    ##! Name of JSON ID field.
    ##!
        
    function JSON_Content_Type_Send($file="")
    {
        if (empty($file))
        {
            $file=$this->ModuleName.".".$this->MTime2FName().".json";
        }
        
        $this->MyMod_Doc_Header_Send("json",$file,"utf-8");
    }
    
    ##! 
    ##! Name of JSON ID field.
    ##!
        
    function JSON_ID_Field($module="")
    {
        if (empty($module)) { $module=$this->ModuleName; }

        $setup=$this->ApplicationObj()->App_Sigaa_Module_Setup($module);
        return $setup[ "ID_Field" ];
    }
    

    ##! 
    ##! Formats $json code for printing.
    ##!
        
    function JSON_Text($json,$indent="")
    {
        foreach ($json as $key => $value)
        {
            if (is_array($value))
            {
                print $indent.$key.":\n";
                $this->JSON_Text($value,$indent."   ");
            }
            else
            {
                print $indent.$key.": ".$value."\n";
            }
        }
    }

    ##! 
    ##! Formats $json code for printing.
    ##!
        
    function JSON_Show($json)
    {
        return
            $this->DIV
            (
                preg_replace
                (
                    '/\s/',
                    "&nbsp;",
                    join
                    (
                        $this->BR(),
                        $json
                    )
                ).
                $this->BR(),
                array("WIDTH" => '200px')
            );

    }
    
    ##! 
    ##! Formats $json code for printing.
    ##!
        
    function JSON_Quote($value)
    {
        $value=preg_replace('/"/','\"',$value);
        $value=preg_replace('/\//','\/',$value);
        $value=preg_replace('/<P>/i','<P >',$value);
        $value=preg_replace('/\n/',' ',$value);
        return '"'.$value.'"';

    }
    
    ##! 
    ##! Formats $json code for printing.
    ##!
        
    function JSON_Key_Value($key,$value)
    {
        return
            $this->JSON_Quote($key).
            ": ".
            $this->JSON_Quote($value);

    }
    
}
?>