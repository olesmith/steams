<?php

trait MyLanguage_Messages
{    
    //*
    //* Retrieves message $key => $subkey from DB.
    //*

    function MyLanguage_GetMessage_DB_Datas($key,$subkey="Name",$langkey="")
    {
        $datas=array("ID","N","Message_Key","Message_Type","MTime_PT");
        if ($langkey!=$this->ApplicationObj()->Language_Default)
        {
            array_push($datas,$subkey."_".$this->ApplicationObj()->Language_Default);
        }

        $subkeys=
            array
            (
                "Name" => True,
                "Title" => True,
            );

        $subkeys[ $subkey ]=True;
        foreach ($subkeys as $subkey => $dummy)
        {
            $rsubkey=$subkey."_".$langkey;
            array_push($datas,$rsubkey);
        }

        return $datas;
    }

    //*
    //* Retrieves message $key => $subkey from DB.
    //*

    function MyLanguage_GetMessages_DB($key,$subkey="Name",$langkey="",$type=-1,$n=0)
    {
        if ($type<0) { $type=$this->LanguagesObj()->Language_Message_Type; }
        
        if (empty($langkey))
        {
            $langkey=$this->ApplicationObj()->Language;
        }
        
        if (empty($this->ApplicationObj()->Messages[ $key ]))
        {
            $messages=
                $this->LanguagesObj()->Sql_Select_Hashes
                (
                    #2 as we want to read an array
                    $this->LanguagesObj()->Language_Messages_Where
                    (
                        $key,
                        $this->LanguagesObj()->Language_Array_Type
                    ),
                    $this->MyLanguage_GetMessage_DB_Datas($key,$subkey,$langkey),
                    "N"
                );
           //we must order messages numerically!
            $rmessages=array();
            foreach ($messages as $message)
            {
                $index=sprintf("%06d",$message[ "N" ]);
                $rmessages[ $index ]=$message;
            }

            $indices=array_keys($rmessages);
            sort($indices);

            $messages=array();
            foreach ($indices as $index)
            {
                $message=$rmessages[ $index ];
                $messages[ $message[ "N" ] ]=$rmessages[ $index ];
            }

            foreach ($messages as $message)
            {
                foreach (array("Name","Title") as $rsubkey)
                {
                    $lsubkey=$rsubkey."_".$langkey;
                    if
                        (
                            empty($this->ApplicationObj()->Messages[ $key ][ $lsubkey ])
                        )
                    {
                        $this->ApplicationObj()->Messages[ $key ][ $lsubkey ]=array();
                    }
                    
                    if (empty($message[ "N" ])) { $message[ "N" ]=0; }

                
                    $this->ApplicationObj()->Messages
                        [ $key ][ $lsubkey ]
                        [ $message[ "N" ] ]=
                        $message[ $lsubkey ];
                }
            }
            
            if (empty($this->ApplicationObj()->Messages[ $key ]))
            {
                return False;
            }

        }

        return
            $this->MyLanguage_Message_Get($key,$subkey,$langkey);
    }
    

    //*
    //* Retrieves message $key => $subkey from file $file.
    //* Files are read in full as needed, maintaining result in memory
    //* to be used by future calls to GetMessage.
    //* Read message files, are store in $this->Messages hash:
    //* 
    //*   $this->Messages[ $file ][ $key ][ $subkey ]
    //*
    //* $subkey is subject to language iteration.
    //*

    function MyLanguage_GetMessages($key,$subkey="Name",$langkey="",$croak=TRUE)
    {
        $message=$this->MyLanguage_GetMessages_DB($key,$subkey,$langkey);
        
        if ($message!=False) { return $message; }

        $langkey=$this->ApplicationObj()->MyLanguage_GetLanguageKey();

        if (!$this->Message_Files_Read)
        {
            $this->ApplicationObj()->MyApp_Interface_Message_Add
            (
                "Messages not found: ".$key
            );
            

            
            $this->ApplicationObj()->MyApp_Messages_Read();
            $this->Message_Files_Read=True;
        }

        if (!empty($this->ApplicationObj()->Messages[ $key ]))
        {
            $message=$this->MyLanguage_Message_Get($key,$subkey,$langkey);
            if ($message) { return $message; }
        }
        
        //Still here, create and warnwarn!
        $this->Language_Message_Auto_Create
        (
            $this->LanguagesObj()->Language_Array_Type,
            $key
        );

        if ($croak)
        {
            $this->MyLanguage_GetMessage_Locate_Try(2,$key);
            
            $this->Warn
            (
                "Unable to retrieve system messages, $key: $subkey",
                $langkey,
                $this->LanguagesObj()->Language_Messages_Where
                (
                    $key,
                    $this->LanguagesObj()->Language_Array_Type
                ),
                $this->LanguagesObj()->Sql_Select_Hashes
                (
                    #2 as we want to read an array
                    $this->LanguagesObj()->Language_Messages_Where
                    (
                        $key,
                        $this->LanguagesObj()->Language_Array_Type
                    ),
                    $this->MyLanguage_GetMessage_DB_Datas($key,$subkey,$langkey),
                    "N"
                ),
                $this->LanguagesObj()->Sql_Select_Hashes_Query
                (
                    #2 as we want to read an array
                    $this->LanguagesObj()->Language_Messages_Where
                    (
                        $key,
                        $this->LanguagesObj()->Language_Array_Type
                    ),
                    $this->MyLanguage_GetMessage_DB_Datas($key,$subkey,$langkey),
                    "N"
                )
                
            );
        }
    }
}
?>