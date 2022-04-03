<?php


trait MyMod_Item_Test_Compulsory
{
    //* 
    //* Tests if compulsory $data is defined.
    //*

    function MyMod_Item_Test_Compulsory_Data(&$item,$data,&$messages)
    {
        $error=0;
        
        if (!empty($this->ItemData[ $data ][ "Compulsory" ]))
        {
            if
                (
                    !empty($this->ItemData[ $data ][ "Default" ])
                    &&
                    empty($item[ $data ])
                )
            {
                $item[ $data ]=
                    $this->ItemData[ $data ][ "Default" ];
            }
            
            $value=$item[ $data ];

            if
                (
                    (
                        preg_match('/^ENUM/',$this->ItemData[ $data ][ "Sql" ])
                        &&
                        $value=="0"
                    )
                    ||
                    (
                        isset($this->ItemData[ $data ][ "SqlClass" ])
                        &&
                        $value=="0"
                    )
                    ||
                    $value==""
                )
            {
                $vmarker=$this->MyLanguage_GetMessage("CompulsoryFieldTag");
                
                $text=$this->GetRealNameKey($this->ItemData[ $data ],"CompulsoryText");
                if ($text)
                {
                    $vmarker=$text;
                }

                $item[ $data."_Message" ]=
                    "<SPAN CLASS='errors'> ".$vmarker."</SPAN>";
                
                array_push
                (
                    $messages,
                    $this->MyMod_Data_Title($data).
                    " ".
                    "'".$item[ $data ]."'".
                    ": undef. ".
                    $item[ $data."_Message" ]
                );
                
                $error++;
            }
        }

        return $error;        
    }
    
}

?>