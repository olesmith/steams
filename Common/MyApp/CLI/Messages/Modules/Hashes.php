<?php

trait App_CLI_Messages_Modules_Hashes
{
    //*
    //* Insert action message
    //*

    function MyApp_CLI_Message_Hash_Do($hash,$message_key,$message_type,$new_message)
    {
        if (empty($hash[ "Module" ]))
        {
            var_dump($hash,$message_key,$message_type,$new_message);
            // exit();
        }
        
        $where=
            array
            (
                "Module" => $hash[ "Module" ],
                "Message_Key" => $message_key,
                "Message_Type" => $message_type,
            );
            
        $message=
            $this->LanguagesObj()->Sql_Select_Hash
            (
                $where,
                array("ID")
            );

        $added=0;
        if (empty($message))
        {
            foreach (array("Name","Title","ShortName") as $key)
            {
                $rkey=$key;
                if (empty($new_message[ $key ])) { $rkey="Name"; }

                if (empty($new_message[ $key."_PT" ]) && !empty($new_message[ $rkey ]))
                {
                    $new_message[ $key."_PT" ]=$new_message[ $rkey ];
                }
            }
                
            $rmessage=$where;
            foreach (array_keys($this->LanguagesObj()->ItemData) as $data)
            {
                if (!empty($new_message[ $data ]))
                {
                    $rmessage[ $data ]=$new_message[ $data ];
                }
                elseif (empty($rmessage[ $data ]))
                {
                    $rmessage[ $data ]="";
                }
            }

            $this->LanguagesObj()->Sql_Insert_Item($rmessage);
            $added=1;

            print "\t".$message_key.":  added!"."\n";
        }

        return $added;
    }
}
