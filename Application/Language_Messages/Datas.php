<?php

include_once("Datas/Read.php");
include_once("Datas/Defaults.php");
include_once("Datas/Names.php");
include_once("Datas/Titles.php");
include_once("Datas/Update.php");
include_once("Datas/Extras.php");

class Language_Messages_Datas extends Language_Messages_Actions
{
    use
        Language_Messages_Datas_Read,
        Language_Messages_Datas_Defaults,
        Language_Messages_Datas_Names,
        Language_Messages_Datas_Titles,
        Language_Messages_Datas_Update,
        Language_Messages_Datas_Extras;
    
    
    //*
    //* function Language_Data_Key_Get_If_Defined, Parameter list: $module,$data,$key
    //*
    //* Retrieve the Item Key associated with data. If not defined, return "". 
    //*

    function Language_Data_Get_If_Defined($moduleobj,$data,$key)
    {
        if (is_array($key))
        {
            #We have a list. Call until first nonempty
            foreach ($key as $rkey)
            {
                $value=
                    $this->LanguagesObj()->Language_Data_Name_Get
                    (
                        $this,
                        $data."_".$rkey
                    );
                
                if (!empty($value)) { return $value; }
            }
        }
        
        $value=
            $this->LanguagesObj()->Language_Data_Name_Get
            (
                $this,
                $data."_".$key
            );
        
        if (preg_match('/^undef/',$value)) { $value=""; }

        return $value;
    }
}
?>