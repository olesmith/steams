<?php

class Language_Messages_Messages extends Language_Messages_Profiles
{
    //*
    //* function Language_Messages_Update, Parameter list: 
    //*
    //* 

    function Language_Messages_Update()
    {
        $this->NItems=0;
        
        $this->ApplicationObj()->MyApp_Messages_Read();       
        return $this->Language_Messages_2_DB();
    }
    
    //*
    //* function Language_Messages_2_DB, Parameter list: 
    //*
    //* 

    function Language_Messages_2_DB()
    {
        $table=array();
        $n=1;
        
        foreach ($this->ApplicationObj()->Messages as $message_key => $message)
        {
            $table=
                array_merge
                (
                    $table,
                    $this->Language_Message_2_DB
                    (
                        $message_key,
                        $message,
                        $this->Language_Message_Type
                    )
                );
        }

        return
            array
            (
                $this->H(1,"Messages in Files"),
                $this->Htmls_Table("",$table),
            );
    }
    //*
    //* function Language_Messages_Handle, Parameter list: 
    //*
    //* 

    function Language_Message_2_DB($message_key,$message,$type,$n=0)
    {
        if (!isset($message[ "Name" ])) { return array(); }

        $messages=array();
        if (is_array($message[ "Name" ]))
        {
            $messages=
                $this->Language_Message_Array_DB($message_key,$message);
        }
        else
        {
            $messages=
                array_merge
                (
                    $messages,
                    $this->Language_Module_Item_Update_Rows
                    (
                        $module="",
                        $message[ "File" ],
                        $message_key,
                        $message,
                        $this->Language_Message_Type
                    )
                );
        }

        return $messages;
    }
    
    //*
    //* function Language_Messages_DB_Update, Parameter list: 
    //*
    //* 

    function Language_Message_Array_DB($message_key,$message)
    {
        $keys=
            preg_grep
            (
                '/^(Name|Title|ShortName)(_\S\S)?/',
                array_keys($message)
            );

        $messages=array();
        for ($n=0;$n<count($message[ "Name" ]);$n++)
        {
            $rmessage=array("File" => $message[ "File" ]);
            foreach ($keys as $key)
            {
                $rmessage[ $key ]=$message[ $key ][ $n ];
            }

            $messages=
                array_merge
                (
                    $messages,
                    $this->Language_Module_Item_Update_Rows
                    (
                        $module="",
                        $message[ "File" ],
                        $message_key,
                        $rmessage,
                        $this->Language_Array_Type
                    )
                );
        }

        return $messages;
    }
 }
?>