<?php

include_once("Messages/Inserts.php");
include_once("Messages/Transfers.php");
include_once("Messages/Profiles.php");
include_once("Messages/Modules.php");
include_once("Messages/LeftMenues.php");

trait MyApp_CLI_Messages
{
    use
        App_CLI_Messages_Inserts,
        App_CLI_Messages_Transfers,
        App_CLI_Messages_Profiles,
        App_CLI_Messages_Modules,
        App_CLI_Messages_LeftMenues;
    //*
    //* Runs CLI commands for Messages table: remove ancient actions and create default
    //* actions, item data and groups.
    //*

    function MyApp_CLI_Messages($args)
    {
        if
            (
                count($args)<2
                ||
                !preg_match('/Messages/i',$args[1])
            )
        {
            print "Omitting Language_Messages_CLI\n";
            return;
        }

        $nstart=$this->LanguagesObj()->Sql_Select_NHashes();
        print "MyApp Messages CLI: ".$nstart."\n";

        if (count($args)>2)
        {
            $action=$args[2];

            if (preg_match('/^(All|Inserts?)$/',$action))
            {
                $this->MyApp_CLI_Message_Inserts_Do();
            }
            
            if (preg_match('/^(All|Transfers?)$/',$action))
            {
                $this->MyApp_CLI_Message_Transfers_Do();
            }

            if (preg_match('/^(All|Profiles)$/',$action))
            {
                $this->MyApp_CLI_Message_Profiles();
            }

            if (preg_match('/^(All|LeftMenues)$/',$action))
            {
                $this->MyApp_CLI_Message_LeftMenues_Do();
            }

            if (preg_match('/^(All|Modules)$/',$action))
            {
                $this->MyApp_CLI_Message_Modules_Do();
            }
            
            if (preg_match('/^(All|Actions)$/',$action))
            {
                $this->Actions();
        
                $this->MyApp_CLI_Message_Actions_Do
                (
                    $this->Actions(),
                    "",
                    "_Actions_"
                );
            }
        }
        
        $nend=$this->LanguagesObj()->Sql_Select_NHashes();
        print "MyApp Messages CLI done: ".$nend.", ".($nend-$nstart)." created\n";

        $this->MyApp_CLI_Message_Take_Skew();
    }

     
    //*
    //* 
    //*

    function MyApp_CLI_Message_Take_Skew()
    {
        $ids=
            $this->LanguagesObj()->Sql_Select_Unique_Col_Values
            (
                "ID"
            );


        foreach ($ids as $id)
        {
            $message=$this->LanguagesObj()->Sql_Select_Hash(array("ID" => $id));

            $updatedatas=array();
            foreach (array("Name","Title") as $key)
            {
                $rkey=$key."_UK";
                if (empty($message[ $rkey ]))
                {
                    $message[ $rkey ]=
                        $message[ "Message_Key" ];

                    array_push($updatedatas,$rkey);
                }
                
                $rkey=$key."_ES";
                $pkey=$key."_PT";
                if (empty($message[ $rkey ]) && !empty($message[ $pkey ]))
                {
                    $message[ $rkey ]=
                        $message[ $pkey ];

                    array_push($updatedatas,$rkey);
                }
            }

            if (count($updatedatas)>0)
            {
                var_dump($message[ "Message_Key" ],$updatedatas);
                $this->LanguagesObj()->Sql_Update_Item_Values_Set
                (
                    $updatedatas,
                    $message
                );
            }
        }
    }
    
     //*
    //* 
    //*

    function MyApp_CLI_Message_Wheres()
    {
        return
            array
            (
                array
                (
                    "Message_Key" => $this->Language_Array_Type,
                    
                ),
            );
    }
}
