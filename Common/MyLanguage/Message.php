<?php

trait MyLanguage_Message
{
    var $Message_Tables=array();
    
    //*
    //* function MyLanguage_GetMessage_DB, Parameter list: 
    //*
    //* Retrieves message $key => $subkey from DB.
    //*

    function MyLanguage_GetMessage_DB($key,$subkey="Name",$langkey="",$type=-1,$n=0)
    {
        $this->LanguagesObj()->Sql_Table_Structure_Update();
        
        $res=$this->LanguagesObj()->App_Init();
        
        if ($type<0) { $type=$this->LanguagesObj()->Language_Message_Type; }
        
        if (empty($langkey))
        {
            $langkey=$this->ApplicationObj()->Language;
        }
        
        
        if (empty($this->ApplicationObj()->Messages[ $key ]))
        {
            $this->ApplicationObj()->Messages[ $key ]=
                $this->LanguagesObj()->Sql_Select_Hash
                (
                    $this->LanguagesObj()->Language_Message_Where($key,$type,$n),
                    $this->MyLanguage_GetMessage_DB_Datas($key,$subkey,$langkey)
                );
            if (empty($this->ApplicationObj()->Messages[ $key ]))
            {
                $this->ApplicationObj()->MyApp_Interface_Message_Add
                (
                    array
                    (
                        $this->ModuleName." Message not found: ".$key,
                        
                        $this->CallStack_Caller_Info(3),
                        $this->CallStack_Caller_Info(4),
                        $this->CallStack_Caller_Info(5),
                    )
                );

                $this->MyLanguage_GetMessage_Locate_Try($type,$key);
                //$this->MyLanguage_Message_Try_To_Find($key,$subkey,$langkey,$type,$n);

                //exit();

                return $key;
            }            
        }
        else
        {
            ##Trying to get message of language not previously read.
            #Read just that key.
            if
                (
                    !empty($this->ApplicationObj()->Messages[ $key ][ "ID" ])
                    &&
                    empty($this->ApplicationObj()->Messages[ $key ][ $subkey."_".$langkey ])
                )
            {
                $this->ApplicationObj()->Messages[ $key ][ $subkey."_".$langkey ]=
                    $this->LanguagesObj()->Sql_Select_Hash_Value
                    (
                        $this->ApplicationObj()->Messages[ $key ][ "ID" ],
                        $subkey."_".$langkey
                    );
            }
        }

        $message=$this->MyLanguage_Message_Get($key,$subkey."_".$langkey);
          
        if (empty($message))
        {
            //Should do nothing!
        }

        $message=preg_replace('/^\s+/',"",$message);
        $message=preg_replace('/\s+$/',"",$message);

        return $message;
    }

    //*
    //* All Message tables in same DB as App Message Table.
    //*

    function MyLanguage_Message_Tables()
    {
        return $this->Message_Tables;
        return $this->LanguagesObj()->Sql_Table_Names($regexp="Messages");
    }
    
    //*
    //* Tries to locate message in other Message tables.
    //*

    function MyLanguage_Message_Try_To_Find($key,$subkey,$langkey,$type,$n)
    {
        foreach ($this->MyLanguage_Message_Tables() as $sql_table)
        {
            $message=
                $this->LanguagesObj()->Sql_Select_Hash
                (
                    $this->LanguagesObj()->Language_Message_Where($key,$type,$n),
                    $this->MyLanguage_GetMessage_DB_Datas($key,$subkey,$langkey),
                    FALSE,
                    $sql_table
                );

            if (!empty($message))
            {
                unset($message[ "ID" ]);
                $this->LanguagesObj()->Sql_Insert_Item($message);
                var_dump("Imported Message ".$message[ "Message_Key" ]." from $sql_table");

                return;
            }
          
        }
    }
    //*
    //* 
    //*

    function MyLanguage_Message_Get($key,$subkey,$langkey="")
    {
        if (empty($langkey))
        {
            $langkey=$this->ApplicationObj()->MyLanguage_GetLanguageKey();
        }

        //Languaged subkey
        $subkey=$subkey."_".$langkey;
       
        if
            (
                !empty($this->ApplicationObj()->Messages[ $key ])
                &&
                isset($this->ApplicationObj()->Messages[ $key ][ $subkey ])
            )
        {
            if
                (
                    !empty($this->ApplicationObj()->Messages[ $key ][ "Message_Type" ])
                    &&
                    (
                        $this->ApplicationObj()->Messages[ $key ][ "Message_Type" ]
                        ==
                        $this->LanguagesObj()->Language_Message_Type
                    )
                )
            {
                return
                    $this->Htmls_Text
                    //join
                    (
                        array
                        (
                            $this->LanguagesObj()->Message_Debug_Pre
                            (
                                $this->LanguagesObj()->Language_Message_Type,
                                $key
                            ),
                            $this->ApplicationObj()->Messages[ $key ][ $subkey ],
                        ),
                        False
                    );                
            }


            return
                $this->ApplicationObj()->Messages[ $key ][ $subkey ];
        }

        return False;
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

    function MyLanguage_GetMessage($key,$subkey="Name",$langkey="",$croak=TRUE)
    {
        if (is_array($key))
        {
            $messages=array();
            foreach ($key as $rkey)
            {
                array_push
                (
                    $messages,
                    $this->MyLanguage_GetMessage($rkey,$subkey,$langkey,$croak)
                );
            }

            return join(" ",$messages);
        }
        
        if (empty($langkey)) { $langkey=$this->ApplicationObj()->Language; }
        
        $message=$this->MyLanguage_GetMessage_DB($key,$subkey,$langkey);

        if ($message!=False)
        {
            return $this->MyHash_Html_Entities_Decode($message);
        }

        if (!empty($this->ApplicationObj()->Messages[ $key ]))
        {
            $message=
                $this->MyLanguage_Message_Get
                (
                    $key,
                    $subkey,
                    $langkey,
                    $this->LanguagesObj()->Language_Message_Type
                );
            
            if ($message) { return $message; }
        }

        $this->Language_Message_Auto_Create(1,$key);
        
        /* //Still here, create and croak! */
        /* $this->Language_Message_Auto_Create */
        /* ( */
        /*     $this->LanguagesObj()->Language_Message_Type, */
        /*     $key */
        /* ); */
        
        if (FALSE) //$croak)
        {
            $this->Warn
            (
                "Unable to retrieve system message: ".
                $this->LanguagesObj()->DBHash("DB")."#".
                $this->LanguagesObj()->SqlTableName().", key: ".
                $key,//$subkey,$langkey,
                $this->LanguagesObj()->Sql_Select_Hash_Query
                (
                    $this->LanguagesObj()->Language_Message_Where
                    (
                        $key,
                        $this->LanguagesObj()->Language_Message_Type
                    )
                )
            );
        }
    }
    
    function MyLanguage_GetMessage_Titled($key,$subkey="Name",$titlekey="Title",$langkey="")
    {
        $message=
            $this->MyLanguage_GetMessage($key,$subkey);

        if (!empty($message))
        {
            $title=$message;
            if ($titlekey!=$subkey)
            {
                $title=
                    $this->MyLanguage_GetMessage
                    (
                        $key,
                        $titlekey,
                        $langkey
                    );
            }

            if ($message!=$title)
            {
                $message=
                    $this->SPAN
                    (
                        $message,
                        array("TITLE" => $title)
                    );
            }
        }

        return $message;
    }

    
    //*
    //* Creates new Message entry in SQL table.
    //*

    function Language_Message_Auto_Create($type,$key,$module="")
    {
        return;
        $newitem=
            array
            (
                "Message_Type" => $type,
                "Message_Key" => $key,
                "Module" => $module,
            );
       $item=
           $this->LanguagesObj()->Sql_Select_Hash
           (
               $newitem,
               array
               (
                   "ID","Message_Type","Message_Key","Module",
                   "Name_".$this->ApplicationObj()->Language,
               )
           );

       if (empty($item[ "ID" ]))
       {
           $this->LanguagesObj()->Sql_Insert_Item($newitem);
       }
       else { $newitem=$item; }

       if (!empty($newitem[ "ID" ]))
       {
           echo
               $this->Htmls_Text
               (
                   $this->LanguagesObj()->MyActions_Entry("Edit",$newitem)
               );
       }
    }
    
    //*
    //* function Language_Message, Parameter list: $key,$subkey="Name"
    //*
    //* Retrieves message $key => $subkey. 
    //* If $subkey is Name, returns spanned Name => Title field.
    //* 
    //*

    function Language_Message($key,$subkey="Name")
    {
        $message=$this->MyLanguage_GetMessage($key,$subkey);
        
        if ($subkey=="Name")
        {
            $title=$this->MyLanguage_GetMessage($key,"Title","",FALSE);
            if ($title!=$message && !empty($title))
            {
                $message=$this->Span($message,array("TITLE" => $title));
            }
        }

        return $message;
    }
    
    //*
    //* Try to locate message in another message SQL table.
    //*

    function MyLanguage_GetMessage_Locate_Try($type,$key,$where=array())
    {
        foreach ($this->LanguagesObj()->Message_Tables as $table)
        {
            $msgs=
                $this->LanguagesObj()->Sql_Select_Hashes
                (
                    array_merge
                    (
                        $where,
                        array
                        (
                            "Message_Type" => $type,
                            "Message_Key"  => $key,
                        )
                    ),
                    array(),
                    "ID",
                    False,
                    $table
                );

            foreach ($msgs as $msg)
            {
                unset($msg[ "ID" ]);
                $this->LanguagesObj()->Sql_Insert_Item($msg);
                var_dump
                (
                    "Message $key Imported: ".
                    $table,
                    $msg
                );

            }
        }
    }
}
?>