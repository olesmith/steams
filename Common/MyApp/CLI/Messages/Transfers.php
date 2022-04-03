<?php

trait App_CLI_Messages_Transfers
{
    //*
    //* Messages to insert.
    //*

    function MyApp_CLI_Message_Transfers()
    {
        return
            $this->ReadPHPArray
            (
                $this->MyApp_Setup_Root().
                "/Common/System/Transfers/Messages.php"
            );
    }
    
    //*
    //* Transfer messages
    //*

    function MyApp_CLI_Message_Transfers_Do()
    {
        print "MyApp Messages Transfers CLI\n";
        foreach ($this->MyApp_CLI_Message_Transfers() as $hash)
        {
            $this->MyApp_CLI_Message_Transfer_Do($hash);
        }
    }
    
    //*
    //* Transfers message
    //*

    function MyApp_CLI_Message_Transfer_Do($hash)
    {
        $datas=array_keys($this->LanguagesObj()->ItemData);
        
        $messages=
            $this->LanguagesObj()->Sql_Select_Hashes
            (
                $hash[ "Where" ],
                $datas,
                "N,ID"
            );

        if (empty($messages))
        {
            $rmessages=
                $this->LanguagesObj()->Sql_Select_Hashes
                (
                    $hash[ "Where" ],
                    $datas,
                    "N,ID",
                    $postprocess=False,
                    $hash[  "App" ]."_Messages"
                );

            foreach ($rmessages as $rmessage)
            {
                unset($rmessage[ "ID" ]);
                $this->LanguagesObj()->Sql_Insert_Item($rmessage);
            }
            
            print
                "Transfered: ".$hash[ "Where" ][ "Message_Key" ].
                ": ".
                count($messages)." -> ".
                count($rmessages)." ".
                "messages\n";

            print 
                $this->LanguagesObj()->Sql_Select_Hashes_Query
                (
                    $hash[ "Where" ],
                    $datas,
                    "N,ID"
                )."\n";
            print 
                $this->LanguagesObj()->Sql_Select_Hashes_Query
                (
                    $hash[ "Where" ],
                    $datas,
                    "N,ID",
                    $hash[  "App" ]."_Messages"
                )."\n";
        }
    }
}
