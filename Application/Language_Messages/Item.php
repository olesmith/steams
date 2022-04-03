<?php

include_once("Item/Language.php");
include_once("Item/Data.php");

class Language_Messages_Item extends Language_Messages_Item_Data
{
    //* function Language_Message_Item_Datas, Parameter list: 
    //*
    //* Datas to read: current $language and $this->ApplicationObj()->Language_Default.
    //* 

    function Language_Message_Item_Datas($subkeys,$language="")
    {
        $datas=array();
        foreach ($subkeys as $subkey)
        {
            foreach ($this->Language_Message_Item_Languages($language) as $rlanguage)
            {
                array_push($datas,$subkey."_".$rlanguage);
            }
        }

        return $datas;
    }
    
    //* function Language_Message_Item_Get, Parameter list:
    //*
    //* Reads message item.
    //*

    function Language_Message_Item_Get($type,$message_key,$subkeys,$language="",$where=array())
    {
        #var_dump($this->Language_Message_Item_Where($type,$message_key,$where));
        $message=
            $this->Sql_Select_Hash
            (
                $this->Language_Message_Item_Where($type,$message_key,$where),
                $this->Language_Message_Item_Datas($subkeys,$language)
            );
        
        $datas=$this->Language_Message_Item_Datas($subkeys,$language);
        $data=$datas[0];

        if (!empty($message[ "ID" ]) && empty($message[ $data ]))
        {
            $this->Language_Message_Default
            (
                $message,
                $type,$message_key,$subkeys,$language
            );
        }
        
        return $message;
    }
    
    //*
    //* function Language_Message_Item_Where, Parameter list: 
    //*
    //* SQL where clause for retrieveing message item.
    //* 

    function Language_Message_Item_Where($type,$message_key,$where=array())
    {
        return
            array_merge
            (
                $where,
                array
                (
                    "Message_Type" => $type,
                    "Message_Key"  => $message_key,
                )
            );
    }
    
    
    //*
    //* 
    //*

    function Language_Message_Item_All_Datas()
    {
        return array_keys($this->ItemData);
    }
    
    //*
    //* Makes extra rows for Basic ItemGroup.
    //*

    function Language_Message_Item_Rows($edit,&$item,$n,$datas,$subdatas,$even,$last,$nrowsindent=6)
    {
        $group=
            $this->MyMod_Data_Group_Actual_Get();

        $rows=
            array
            (
                $this->MyMod_Items_Table_Row
                (
                    $edit,$n,
                    $item,
                    $this->Language_Messages_Group_Datas(),
                    True,
                    $item[ "ID" ]."_"
                ),
            );

        if ($group=="Basic")
        {
            $rows=
                array_merge
                (
                    $rows,
                    array
                    (
                        $this->Htmls_Table
                        (
                            "",
                            $this->Language_Message_Item_Datas_Rows
                            (
                                $edit,$n,$item,0
                            ),
                            array("WIDTH" => "100%")
                        ),
                    ),
                    array(array($this->HR()))
                );
        }

        return $rows;
    }
    
    

    

}
?>