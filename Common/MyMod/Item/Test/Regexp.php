<?php


trait MyMod_Item_Test_Regexp
{
    //* 
    //* Tests if regex is satisfied.
    //*

    function MyMod_Item_Test_Regex_Data(&$item,$data,&$messages)
    {
        $error=0;
        
        if
            (
                !empty($item[ $data ])
                &&
                isset($this->ItemData[ $data ][ "Regexp" ])
                &&
                !preg_match
                (
                    '/'.$this->ItemData[ $data ][ "Regexp" ].'/',
                    $item[ $data ]
                )
            )
         {
             $this->MyMod_Item_Test_Regex_Data_Message($item,$data);

             array_push
             (
                 $messages,
                 
                 $this->MyMod_Data_Title($data).
                 " ".
                 "'".$item[ $data ]."'".
                 ": ".
                 $item[ $data."_Message" ]
             );
             
             $error++;
         }

        return $error;
    }

    //* 
    //* Retrieves Regexp message.
    //*

    function MyMod_Item_Test_Regex_Data_Message(&$item,$data)
    {
        if (isset($this->ItemData[ $data ][ "RegexpText" ]))
        {
            $item[ $data."_Message" ]=
                $this->MyMod_Data_Title($data).
                ": ".
                $this->GetRealNameKey($this->ItemData[ $data ],"RegexpText");
        }
        else
        {
            $item[ $data."_Message" ]=
                $this->MyMod_Data_Title($data).
                ", ".
                $this->MyLanguage_GetMessage("Regexp_Unsatisfied").
                ": ".
                $this->ItemData[ $data ][ "Regexp" ];
        }

        return $item[ $data."_Message" ];
    }
}

?>