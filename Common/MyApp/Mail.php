<?php

trait MyApp_Mail
{
    //*
    //* Sends email calling ApplicationObj::MyApp_Mail_Info_Get.
    //* Add trailer msg and inserts MailInfo vars into $mailhash.
    //*

    function  MyApp_Email_Send($user,$mailhash,$filters=array(),$attachments=array())
    {
        if (!is_array($attachments)) { $attachments=array($attachments); }

        $mailhash=
            $this->MyApp_Email_Hash_Get
            (
                $user,
                $mailhash,
                $filters
            );

        //var_dump($user);
        $this->EmailStatus=FALSE;
        if (!empty($this->DBHash[ "MailDebug" ]))
        {
            foreach (array("To","CC","BCC","ReplyTo") as $key)
            {
                if (!is_array($mailhash[ $key ]))
                {
                    $mailhash[ $key ]=array($mailhash[ $key ]);
                }
            }

            $html=array();
            if (!empty($attachments))
            {
                $html=
                    array
                    (
                        "Attachments:"
                    );

                foreach ($attachments as $attachment)
                {
                    array_push
                    (
                        $html,
                        $attachment[ "File" ],
                        file_exists($attachment[ "File" ]),
                        $this->BR()
                    );
                }
            }
           
            $this->Htmls_Echo
            (
                array
                (
                    "Fake sending...",
                    $this->BR(),
                    $this->Htmls_Tag
                    (
                        "PRE",
                        array
                        (
                            "TO: ".
                            join(", ",$mailhash[ "To" ]),
                            "CC: ".
                            join(",<BR>",$mailhash[ "CC" ]),
                            "BCC: ".
                            join(",<BR>",$mailhash[ "BCC" ]),
                            "ReplyTo: ".
                            join(",<BR>",$mailhash[ "ReplyTo" ]),
                            "Subject: ".$mailhash[ "Subject" ],
                            "Body: ".preg_replace('/\n/',"<BR>",$mailhash[ "Body" ]),
                            "",
                            $this->MyApp_Email_Attachments
                            (
                                $user,$mailhash,$attachments
                            ),
                        )
                    ),
                    $this->BR(),
                    $html
                )
            );

            $this->EmailStatus=TRUE;
        }
        else
        {
            if
                (
                    $this->MyEmail_Email_Send
                    (
                        $this->MyApp_Mail_Info_Get(),
                        $mailhash,$attachments
                    )
                )
            {
                $this->EmailStatus=TRUE;
            }
            else
            {
                $this->EmailStatusMessage=
                    "Erro enviando email: ".
                    $this->Email_PHPMailer->ErrorInfo;
                
                $this->EmailStatus=FALSE;  
            }


            $this->Htmls_Echo
            (
                $this->EmailStatusMessage($mailhash,$attachments)
            );
        }

        return $this->EmailStatus;
    }

    
    //*
    //* function MyApp_Mail_Init, Parameter list: 
    //*
    //* Initializes mailing, if no.
    //*

    function MyApp_Mail_Init()
    {
        if ($this->Mail)
        {
            $this->MailInfo=
                $this->ReadPHPArray
                (
                    $this->MyApp_Setup_Path().
                    "/".
                    $this->MailSetup
                );
            $unit=$this->Unit();
            if (!empty($unit[ "ID" ]))
            {
                foreach ($this->Unit2MailInfo as $key)
                {
                    if (empty($this->MailInfo[ $key ])) { $this->MailInfo[ $key ]=""; }
                    
                    if (!empty($unit[ $key ]))
                    {
                        $this->MailInfo[ $key ]=$unit[ $key ];
                    }
                }
            }
            $event=array();
            if ($this->CGI_GETint("Event")>0)
            {
                $event=$this->Event();
            }

            if (!empty($event[ "ID" ]))
            {
                foreach ($this->Event2MailInfo as $key)
                {
                    if (empty($this->MailInfo[ $key ])) { $this->MailInfo[ $key ]=""; }
                    
                    if (!empty($event[ $key ]))
                    {
                        $this->MailInfo[ $key ]=$event[ $key ];
                    }
                }
            }
        }
    }

        
    //*
    //* function MyApp_Mail_Init, Parameter list: $key=""
    //*
    //* Initializes mailing, if no.
    //*

    function MyApp_Mail_Info_Get($key="")
    {
        if (empty($this->MailInfo))
        {
            $this->MyApp_Mail_Init();
        }

        if (!empty($key))
        {
            if (!empty($this->MailInfo[ $key ]))
            {
                return $this->MailInfo[ $key ];
            }
            else
            {
                return $key;
            }
        }

        return $this->MailInfo;
    }

    
    //*
    //* function MyApp_Email_Hash_Get, Parameter list: $user,$mailhash,$filters=array()
    //*
    //* Sends email calling ApplicationObj::MyApp_Mail_Info_Get.
    //* Add trailer msg and inserts MailInfo vars into $mailhash.
    //*

    function  MyApp_Email_Hash_Get($user,$mailhash,$filters=array())
    {
        $mailhash=$this->MyEmail_Recipients_2_Hash($mailhash);

        if (!empty($user))
        {
            $mailhash[ "To" ]=array($user[ "Email" ]);
            if (empty($user[ "Email" ]) && !empty($user[ "CondEmail" ]))
            {
                $mailhash[ "To" ]=array($user[ "CondEmail" ]);
            }
        }

        $mailinfo=$this->ApplicationObj()->MyApp_Mail_Info_Get();
        foreach
            (
                array
                (
                    "Auth" => "Auth",
                    "Secure" => "Secure",
                    "Port" => "Port",
                    "Host" => "Host",
                    "User" => "User",
                    "Password" => "Password",
                    "ReplyTo" => "ReplyTo",
                    "CCEmail" => "CC",
                    "BCCEmail" => "BCC",
                    "FromEmail" => "FromEmail",
                    "FromName" => "FromName",
                ) as $data => $key
            )
        {
            if (!empty($mailinfo[ $data ]))
            {
                if (empty($mailhash[ $key ]))
                {
                    $mailhash[ $key ]=$mailinfo[ $data ];
                }
            }
        }
        
        $mailhash[ "Body" ].=
            "\n-----\n".
            "####################################################################################\n".
            preg_replace
            (
                '/#ApplicationName/',
                $this->ApplicationObj()->MyApp_Name(),
                preg_replace
                (
                    '/#ApplicationTitle/',
                    $this->ApplicationObj()->MyApp_Title(),
                    $this->MyLanguage_GetMessage("MailTrailer")
                )
            )."\n".
            "####################################################################################";


        $mailhash=
            $this->MyEmail_Hash_Filters
            (
                $mailhash,
                array("Body","Subject"),
                array_merge
                (
                    array($user),
                    $filters
                )
            );

        
        return $mailhash;
     }

    
    //*

    function  MyApp_Email_Attachments($attachments)
    {
        if (empty($attachments)) { return ""; }
        
        $files=array();
        foreach ($attachments as $attachment)
        {
            array_push
            (
                $files,
                $attachment[ "File" ],
                file_exists($attachment[ "File" ])
            );
        }

        return
            $this->MyLanguage_GetMessage("Attachments").
            " ".
            join($this->BR(),$files);
    }
    
}

?>