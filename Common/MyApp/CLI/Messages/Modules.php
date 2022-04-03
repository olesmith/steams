<?php

include_once("Modules/Hashes.php");
include_once("Modules/Actions.php");
include_once("Modules/Datas.php");
include_once("Modules/Groups.php");

trait App_CLI_Messages_Modules
{
    use
        App_CLI_Messages_Modules_Hashes,
        App_CLI_Messages_Modules_Datas,
        App_CLI_Messages_Modules_Groups,
        App_CLI_Messages_Modules_Actions;
    //*
    //* Messages to insert.
    //*

    function MyApp_CLI_Message_Modules()
    {
        return
            array
            (
                array
                (
                    "App" => "Sivent2",
                    "Module" => "Languages",
                    "Data_Permissions" => array
                    (
                        "Admin" => 2,
                        "Distributor" => 2,
                        "Coordinator" => 1,
                        "Person" => 0,
                        "Public" => 0,
                    ),
                ),
            );
    }
    
    //*
    //* Insert messages
    //*

    function MyApp_CLI_Message_Modules_Do()
    {
        $this->LanguagesObj()->ItemData();
        print "SigaZ Messages Modules CLI\n";
        foreach ($this->MyApp_CLI_Message_Modules() as $hash)
        {
            $this->MyApp_CLI_Message_Module_Do($hash);
        }

        
        foreach ($this->MyApp_CLI_Message_Modules() as $hash)
        {
            $this->MyApp_CLI_Message_Module_Entities_Do($hash);
        }
    }
    
    //*
    //* Insert message
    //*

    function MyApp_CLI_Message_Module_Do($hash)
    {
        print "SigaZ Messages Module CLI: ".$hash[ "Module" ]."\n";
        $module_method=$hash[ "Module" ]."Obj";

        if (!method_exists($this,$module_method))
        {
            return;
        }
        
        $this->$module_method()->ItemData();
        
        foreach (array("ItemName","ItemsName") as $key)
        {
            $where=
                array
                (
                    "Module" => $hash[ "Module" ],
                    "Message_Key" => $key,
                    "Message_Type" => $this->LanguagesObj()->Language_Module_Type,
                );
            
            $message=
                $this->LanguagesObj()->Sql_Select_Hash
                (
                    $where,
                    array("ID")
                );

            $ninserted=0;
            $rmessage=array();
            if (empty($message))
            {
                if (!empty( $hash[  "App" ]))
                {
                    $rmessage=
                        $this->LanguagesObj()->Sql_Select_Hash
                        (
                            $where,
                            array(),
                            $noecho=False,
                            $hash[  "App" ]."_Messages"
                        );
                }
                else
                {
                    $rmessage=
                        array_merge
                        (
                            $hash[ $key ],
                            $where,
                            array("ID" => "")
                        );

                    $this->LanguagesObj()->PostProcess_Defaults($rmessage);
                }
            
                if (!empty($rmessage))
                {
                    $ninserted++;
                    unset($rmessage[ "ID" ]);
                    $this->LanguagesObj()->Sql_Insert_Item($rmessage);
                }
                
                
                print
                    "Inserted: ".$hash[ "Module" ].
                    " $key: ".
                    $ninserted." ".
                    "messages\n";
            }
        }
    }

    //*
    //* Insert message
    //*

    function MyApp_CLI_Message_Module_Entities_Do($hash)
    {
        $module_method=$hash[ "Module" ]."Obj";
        $module=$hash[ "Module" ];
        $this->MyApp_CLI_Message_Actions_Do($hash,$module_method,$module);
        $this->MyApp_CLI_Message_Datas_Do($hash,$module_method);
        $this->MyApp_CLI_Message_Groups_Do($hash,$module_method);
        $this->MyApp_CLI_Message_SGroups_Do($hash,$module_method);
    }
}
