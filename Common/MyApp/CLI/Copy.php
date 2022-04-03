<?php


trait MyApp_CLI_Copy
{
    function MyApp_CLI_Copy($args)
    {
        if
            (
                count($args)<4
                ||
                !preg_match('/^Copy$/',$args[1])
            )
        {
            print "Omitting MyApp_CLI_Copy\n".count($args);
            return;
            
        }
        
        $messages=$this->LanguagesObj()->Sql_Select_Hashes();

        $other_method=$args[2]."Obj";
        $other_table=$args[3];

        $other_obj=$this->$other_method();

        $rmessages=
            $other_obj->Sql_Select_Hashes
            (
                array(),array(),"",FALSE,
                $other_table
            );
       
        if (count($rmessages)>0)
        {
            print
                "MyApp_CLI_Copy: Destination table '".
                $other_table.
                "' not empty - nothing copied ".
                count($rmessages).
                "\n";

            return;
        }
        
        print
            "MyApp_CLI_Copy: ".count($messages).
            " source, ".
            count($rmessages).
            " destination messages ($other_table)\n";

        $ninserted=0;
        foreach ($messages as $message)
        {
            var_dump($other_obj->Sql_Insert_Item_Query($message,$other_table,True));
            unset($message[ "ID" ]);
            $res=$other_obj->Sql_Insert_Item($message,$other_table,True);
            $ninserted++;
            
            var_dump($res);
        }

        print $ninserted." messages copied to $other_table\n";
    }
    
    function MyApp_CLI_Compare($args)
    {
        if
            (
                count($args)<4
                ||
                !preg_match('/^Compare$/',$args[1])
            )
        {
            print "Omitting MyApp_CLI_Compare\n";
            return;
            
        }

        $status=">";
        if (count($args)>4)
        {
            $status=$args[4];
            
        }

        $languages=array("PT","ES","UK");

        $type_format="%-30s";
        $module_format="%-30s";
        $empty="-------";
        
        
        $messages=$this->LanguagesObj()->Sql_Select_Hashes();

        $other_method=$args[2]."Obj";
        $other_table=$args[3];

        $other_obj=$this->$other_method();

        $rmessages=
            $other_obj->Sql_Select_Hashes_ByID
            (
                array(),array(),"ID","",FALSE,
                $other_table
            );
       

        print
            "MyApp_CLI_Compare: ".
             $this->LanguagesObj()->SqlTableName().
             " ".
             count($messages).
             " source, ".
             $other_table.
             " ".
             count($rmessages).
             " destination messages";


        $titles=
            array
            (
                "ID",
                "Type",
                sprintf($type_format,"Key"),
                sprintf($module_format,"Module"),
            );
        $rtitles=
            array
            (
                $empty,
                $empty,
                sprintf($type_format,$empty),
                sprintf($module_format,$empty),
            );
            
        foreach ($languages as $language)
        {
            $titles=
                array_merge
                (
                    $titles,
                    array
                    (
                        "  ".$language." 1",
                        "",
                        "  Diff",
                        "  ".$language." 2",
                        "",
                    )
                );
            
            array_push
            (
                $rtitles,
                $empty,
                $empty,
                $empty
            );
        }

        $update_messages=array();

        $titles_every=10;
        $n=0;
        foreach ($messages as $message)
        {
            if ( ($n % $titles_every)==0)
            {
                print
                    "\n".
                    join("\t",$titles)."\n".
                    join("\t",$rtitles)."\n".
                    "";
            }

            
            $n++;
            
            $other_message=array();
            if (empty($rmessages[ $message[ "ID" ] ]))
            {
                print "\t".$message[ "ID" ]." omitterd\n";
            }

            
            $other_message=$rmessages[ $message[ "ID" ] ];
            
            $update_datas=array();
            $update_other_datas=array();

            $module="-";
            if (!empty($message[ "Module" ]))
            {
                $module=$message[ "Module" ];
            }
            $row=
                array
                (
                    $message[ "ID" ],
                    $message[ "Message_Type" ],
                    sprintf($type_format,$message[ "Message_Key" ]),
                    sprintf($module_format,$module),
                );

            $update_languages=array();

            foreach ($languages as $language)
            {
                $mtime_key="MTime_".$language;

                if (empty($message[ $mtime_key ]))
                {
                    $message[ $mtime_key ]=$message[ "MTime" ];
                    array_push($update_datas,$mtime_key);
                    
                }

                if (empty($other_message[ $mtime_key ]))
                {
                    $other_message[ $mtime_key ]=$other_message[ "MTime" ];
                    array_push($update_other_datas,$mtime_key);
                    
                }

                $rstatus="=";
                if ($status==">")
                {
                    if ($message[ $mtime_key ]>$other_message[ $mtime_key ])
                    {
                        $rstatus=">";
                    }
                }
                elseif ($status=="<")
                {
                    if ($message[ $mtime_key ]<$other_message[ $mtime_key ])
                    {
                        $rstatus="<";
                    }
                }
                elseif ($status=="=")
                {
                    if ($message[ $mtime_key ]==$other_message[ $mtime_key ])
                    {
                        $rstatus="=";
                    }
                }
                
                array_push
                (
                    $row,
                    $message[ $mtime_key ],
                    "   ".$rstatus,
                    $other_message[ $mtime_key ]
                );
                

                if ($rstatus==$status)
                {
                    array_push
                    (
                        $update_languages,
                        $language
                    );
                }

                
            }

            if (count($update_languages)>0)
            {
                array_push
                (
                    $update_messages,
                    array
                    (
                        $message,
                        $other_message,
                        $update_languages,
                        $update_datas,
                        $update_other_datas
                    )
                );
            }
            
            print join("\t",$row)."\n";
            
        }

        $this->MyApp_CLI_Compare_Update_Messages($args,$status,$update_messages);
    }

    
    function MyApp_CLI_Compare_Update_Messages($args,$status,$update_messages)
    {
        $other_method=$args[2]."Obj";
        $other_table=$args[3];

        $other_obj=$this->$other_method();

        print count($update_messages)." messages to update, ".$status."\n";
        
        $queries=array();
        foreach ($update_messages as $update_message)
        {
            $queries=
                array_merge
                (
                    $queries,
                    $this->MyApp_CLI_Compare_Update_Message($args,$status,$update_message)
                );
        }

        print "\n".join("\n",$queries)."\n";

        print
            "Source Table: ".
            $this->LanguagesObj()->SqlTableName().
            " ".
            $this->LanguagesObj()->Sql_Select_NHashes().
            " entries\n".
            "Destination Table: ".
            $other_table.
            " ".
            $other_obj->Sql_Select_NHashes
            (
                array(),
                $other_table
            ).
            " entries\n";
    }
    
    function MyApp_CLI_Compare_Update_Message($args,$status,$update_message)
    {
        $other_method=$args[2]."Obj";
        $other_table=$args[3];

        $other_obj=$this->$other_method();

        
        $message=$update_message[0];
        $other_message=$update_message[1];
        $update_languages=$update_message[2];

        $update_datas=$update_message[3];
        $update_other_datas=$update_message[4];

        $queries=array();
        foreach ($update_languages as $update_language)
        {
            foreach (array("MTime","Name","Title","ShortName") as $data)
            {
                $rdata=$data."_".$update_language;

                if ($status=="<")
                {
                    array_push($update_datas,$rdata);
                    $message[ $rdata ]=$other_message[ $rdata ];
                }
                else //>=
                {
                    array_push($update_other_datas,$rdata);
                    $other_message[ $rdata ]=$message[ $rdata ];
                }
            }
        }

        $pretend=False;

        $queries=array();
        
        if (count($update_datas)>0)
        {
            $update_datas=$this->MyHash_List_Unique($update_datas);
            
            array_push
            (
                $queries,
                $this->LanguagesObj()->Sql_Update_Item
                (
                    $message,
                    array("ID" => $message[ "ID" ]),
                    $update_datas,
                    $this->LanguagesObj()->SqlTableName(),
                    $force=True,
                    $pretend
                ).";"
            );
        }
        
        if (count($update_other_datas)>0)
        {
            $update_other_datas=$this->MyHash_List_Unique($update_other_datas);
            
            array_push
            (
                $queries,
                $other_obj->Sql_Update_Item
                (
                    $other_message,
                    array("ID" => $other_message[ "ID" ]),
                    $update_other_datas,
                    $other_table,
                    $force=True,
                    $pretend
                ).";"
            );
        }

        return $queries;
    }
}

?>