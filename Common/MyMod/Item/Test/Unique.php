<?php


trait MyMod_Item_Test_Unique
{
    //* 
    //* Tests if $data unicity is satisfied.
    //*

    function MyMod_Item_Test_Unique_Data(&$item,$data,&$messages)
    {
        $error=0;
        if (!empty($this->ItemData[ $data ][ "Unique" ]))
        {
            if (!$this->MyMod_Item_Test_Unique_Data_Is($item,$data))
            {
                array_push
                (
                    $messages,
                    $item[ $data."_Message" ]
                );
                    
                $error++;
            }
        }
        
        return $error;        
    }

    
    //*
    //* Tests whether $item[ $data ] is unique.
    //*

    function MyMod_Item_Test_Unique_Data_Is(&$item,$data)
    {
        $res=True;
        if (!empty($item[ $data ]) && empty($this->ItemData[ $data ][ "Derived" ]))
        {
            if
                (
                    $this->Sql_Select_NHashes
                    (
                        array
                        (
                            $data => $item[ $data ],
                        )
                    )>1
                )
            {
                if (!array($this->HtmlStatus))
                {
                    $this->HtmlStatus=array($this->HtmlStatus);
                }

                $item[ $data."_Message" ]=
                    $this->MyMod_Data_Title($data).
                    ", ".
                    "'".$item[ $data ]."'".
                    ": ".
                    $this->MyLanguage_GetMessage("Not_Unique").
                    "";
                
                array_push
                (
                    $this->HtmlStatus,
                    $item[ $data."_Message" ]
                );
                
                $res=FALSE; 
            }
        }

        return $res;
    }
}

?>