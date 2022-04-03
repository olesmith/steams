<?php

trait App_CLI_Messages_Inserts
{
    //*
    //* Messages to insert.
    //*

    function MyApp_CLI_Message_Inserts()
    {
        return
            array
            (
                array
                (
                    "Where" => array
                    (
                        "Message_Key" => "Application",
                        "Message_Type" => 1,
                    ),
                    "Data" => array
                    (
                        "Name_PT" => "SigaZ",
                    ),
                ),
                array
                (
                    "Where" => array
                    (
                        "Message_Key" => "ActiveNoYes",
                        "Message_Type" => 2,
                    ),
                    "Data" => array
                    (
                    ),
                    "Datas" => array
                    (
                        0 => array
                        (
                            "Name_PT" => "Inativo",
                            "Name_UK" => "Inactive",
                        ),
                        1 => array
                        (
                            "Name_PT" => "Ativo",
                            "Name_UK" => "Active",
                        ),
                    ),
                ),
                array
                (
                    "Where" => array
                    (
                        "Message_Key" => "Shifts",
                        "Message_Type" => 2,
                    ),
                    "Data" => array
                    (
                    ),
                    "Datas" => array
                    (
                        0 => array
                        (
                            "Name_PT" => "Matutino",
                            "Name_UK" => "Morning",
                        ),
                        1 => array
                        (
                            "Name_PT" => "Vespertino",
                            "Name_UK" => "Afternoon",
                        ),
                        2 => array
                        (
                            "Name_PT" => "Noturno",
                            "Name_UK" => "Night",
                        ),
                    ),
                ),
            );
    }
    
    //*
    //* Insert messages
    //*

    function MyApp_CLI_Message_Inserts_Do()
    {
        print "SigaZ Messages Inserts CLI\n";
        foreach ($this->MyApp_CLI_Message_Inserts() as $hash)
        {
            $this->MyApp_CLI_Message_Insert_Do($hash);
        }
    }
    
    //*
    //* Insert message
    //*

    function MyApp_CLI_Message_Insert_Do($hash)
    {
        $message=
            $this->LanguagesObj()->Sql_Select_Hash
            (
                $hash[ "Where" ],
                array("ID")
            );

        if (empty($message))
        {

            if (empty($hash[ "Datas" ]))
            {
                $message=
                    array_merge
                    (
                        $hash[ "Where" ],
                        $hash[ "Data" ]
                    );
                $this->LanguagesObj()->PostProcess_Defaults($message);

                print "Inserting message: ".$hash[ "Where" ][ "Message_Key" ]."\n";
                $this->LanguagesObj()->Sql_Insert_Item($message);
            }
            else
            {
                foreach ($hash[ "Datas" ] as $n => $rhash)
                {                    
                    $message=
                        array_merge
                        (
                            $hash[ "Where" ],
                            $hash[ "Data" ],
                            $rhash
                        );

                    $message[ "N" ]=$n;
                    $this->LanguagesObj()->PostProcess_Defaults($message);
                    $this->LanguagesObj()->Sql_Insert_Item($message);
                }
                
                print
                    "Inserting: ".
                    $hash[ "Where" ][ "Message_Key" ]." ".
                    count($hash[ "Datas" ])." ".
                    "messages\n";
            }
        }
    }
}
