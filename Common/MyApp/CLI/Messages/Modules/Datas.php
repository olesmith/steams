<?php

trait App_CLI_Messages_Modules_Datas
{
    //*
    //* Insert message
    //*

    function MyApp_CLI_Message_Datas_Do($hash,$module_method)
    {
        print "SigaZ Messages Module ItemDatas CLI\n";
        $itemdatas=
            $this->ReadPHPArray
            (
                $this->MyApp_Setup_Root().
                "/Common/System/Data.Defaults.php"
            );

        $permissions=$hash[ "Data_Permissions" ];

        

        $ndatas=0;
        $naddeds=0;
        foreach ($itemdatas as $data => $rhash)
        {
            $rhash=array_merge($rhash,$permissions);
            if (!empty($rhash[ "Name" ]))
            {
                $rhash[ "Name_PT" ]=$rhash[ "Name" ];
            }
            
            if (empty($rhash[ "Name_PT" ]))
            {
                $rhash[ "Name_PT" ]=$data;
            }

            $naddeds+=
                $this->MyApp_CLI_Message_Hash_Do
                (
                    $hash,
                    $data,
                    $this->LanguagesObj()->Language_Data_Type,
                    $rhash
                );
            $ndatas++;
        }
        
        foreach ($this->$module_method()->ItemData() as $data => $rhash)
        {
            $itemdata=$this->$module_method()->ItemData($data);
            if (!empty($itemdata[ "SqlClass" ]))
            {
                $module=$itemdata[ "SqlClass" ];
                $where=
                    array
                    (
                        "Module" => $module,
                        "Message_Key" => "ItemName",
                        "Message_Type" => $this->LanguagesObj()->Language_Module_Type,
                    );
                
                $message=
                    $this->LanguagesObj()->Sql_Select_Hash
                    (
                        $where                        
                    );

                if (!is_array($message))
                {
                    var_dump
                    (
                        "Module $module, ItemName message is not an array:",
                        $hash,$where
                    );
                    exit();
                }
                
                unset($message[ "ID" ]);
                $rhash=
                    array_merge
                    (
                        $message,
                        array
                        (
                            "Module" => $hash[ "Module" ],
                            "Message_Key" => $data,
                            "Message_Type" => $this->LanguagesObj()->Language_Data_Type,
                        ),
                        $permissions
                    );

                print "\t".$hash[ "Module" ].": ".$data." SQL!\n";
            }

            if (!empty($rhash[ "Name" ]))
            {
                $rhash[ "Name_PT" ]=$rhash[ "Name" ];
            }
            
            if (empty($rhash[ "Name_PT" ]))
            {
                $rhash[ "Name_PT" ]=$data;
            }
            
            $ndatas++;
            $naddeds+=
                $this->MyApp_CLI_Message_Hash_Do
                (
                    $hash,
                    $data,
                    $this->LanguagesObj()->Language_Data_Type,
                    $rhash
                );
        }
        
        print $hash[ "Module" ].": ".$ndatas." ItemData, ".$naddeds." added\n";        
    }
}
