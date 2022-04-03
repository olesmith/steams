<?php

trait MyApp_Login_Password
{
    //*
    //* function MyApp_Login_Password_Valid_Is, Parameter list: $password,&$message
    //*
    //* Tests whether $password is considered a valid password.
    //*

    function MyApp_Login_Password_Valid_Is($password,&$message)
    {
        $res=8;
        if (strlen($password)<8)
        {
            $message="Error_PasswordNotAccepted";
            $res=FALSE;
        }

        return $res;
    }

    
    //*
    //* function MyApp_Login_Password_Change_Table, Parameter list: 
    //*
    //* Creates the Change password table.
    //*

    function MyApp_Login_Password_Change_Table()
    {
        return
            array
            (
                array
                (
                    $this->B
                    (
                        $this->MyLanguage_GetMessage
                        (
                            "Login_Name"
                        ).":"
                    ),
                    $this->LoginData[ "Name" ]
                ),
                array
                (
                    $this->B
                    (
                        $this->MyLanguage_GetMessage
                        (
                            "Login_User"
                        ).":"
                    ),
                    $this->LoginData[ "Email" ]
                ),
                array
                (
                    $this->B
                    (
                        $this->MyLanguage_GetMessage
                        (
                            "Login_OldPassword"
                        ).":"
                    ),
                    $this->Htmls_Input_Password("Password","")
                    //$this->MakePassword("Password","",10)
                ),
                array
                (
                    $this->B
                    (
                        $this->MyLanguage_GetMessage
                        (
                            "Login_Password1"
                        ).":"
                    ),
                    $this->Htmls_Input_Password("Password1","")
                    //$this->MakePassword("Password1","",10)
                ),
                array
                (
                    $this->B
                    (
                        $this->MyLanguage_GetMessage
                        (
                            "Login_Password2"                            
                        ).":"
                    ),
                    $this->Htmls_Input_Password("Password2","")
                    //$this->MakePassword("Password2","",10)
                ),
            );
    }

    
    //*
    //* function MyApp_Login_Password_Change_Form, Parameter list: 
    //*
    //* Creates the Change password form.
    //*

    function MyApp_Login_Password_Change_Form()
    {
        $password=$this->CGI_POST("Password");

        $message="";
        $sendmail=False;
        if ($this->GetPOST("Update")==1 && !empty($password))
        {
            $logindata=$this->LoginData;
            if (count($this->LoginData)>0)
            {
                $rlogin=$this->LoginData[ $this->AuthHash[ "LoginField" ] ];
                $rpassword=$this->LoginData[ $this->AuthHash[ "PasswordField" ] ];

                if ($this->MyApp_Auth_Password_Verify($rlogin,$password,$rpassword))
                {
                    $pwd1=$this->CGI_POST("Password1");
                    $pwd2=$this->CGI_POST("Password2");
                    if ($pwd1==$pwd2)
                    {
                        if ($this->MyApp_Login_Password_Valid_Is($pwd1,$message)>=8)
                        {
                            $this->Sql_Update_Item_Value_Set
                            (
                                $this->LoginData[ "ID" ],
                                $this->AuthHash[ "PasswordField" ],
                                $this->MyApp_Auth_Crypt_Password_Crypt($pwd1),
                                $this->AuthHash[ "IDField" ],
                                $this->SqlTableName($this->AuthHash[ "Table" ])
                            );

                            $sendmail=True;
                            $message="Password_Updated"; 
                        }
                    }
                    else
                    {
                        $message="Error_PasswordNotAccepted";
                    }
                }
                else
                {
                    $message="Error_LoginIvalid1";
                }
            }
            else
            {
                $message="Error_LoginIvalid2";
            }
        }
        elseif ( $password!="")
        {
            $message="Error_NoPassword";
        }

        if ($message)
        {
            $message=
                $this->H
                (
                    4,
                    $this->MyLanguage_GetMessage($message)
                );
        }

        
        $this->MyApp_Interface_Head();

        if ($sendmail)
        {
            $this->Send_Password_Changed_Email($this->LoginData);
        }
        
        $this->Htmls_Echo
        (
            array
            (
                $this->Htmls_Form
                (
                    1,
                    "NewPassword",
                    $action="",
                    
                    //$contents=
                    array
                    (
                        $this->H
                        (
                            1,
                            $this->MyLanguage_GetMessage
                            (
                                "Update_Password_Title"
                            )
                        ),
                        $message,
                        $this->H
                        (
                            2,
                            $this->MyLanguage_GetMessage
                            (
                                "Update_Password_Msg"
                            )
                        ),
                        $this->Htmls_Table
                        (
                            "",
                            $this->MyApp_Login_Password_Change_Table()
                        ),
                    ),
                    
                    //$args=
                    array
                    (
                        "Buttons" => $this->Buttons(),
                        "Hiddens" => array
                        (
                            "Update" => 1,
                        )
                    )
                ),
            )
        );


        exit();
    }

    
    //*
    //* Sends password changed email.
    //*

    function Send_Password_Changed_Email($friend)
    {
        $args=$this->CGI_URI2Hash();
        $args[ "Action" ]="Login";
        $args[ "Email" ]=$friend[ "Email" ];
        
        $rargs=$args;
        $rargs[ "Action" ]="Recover";
        $mailtype="Password_Changed";

        $this->MyMod_Mail_Typed_Send
        (
           $mailtype,
           $friend,
           $this->Unit(),
           array
           (
              "LoginLink" => $this->CGI_Script_Exec
              (
                 $this->CGI_Hash2URI($args)
              ),
              "RecoverLink" => $this->CGI_Script_Exec
              (
                 $this->CGI_Hash2URI($rargs)
              ),
           )
        );
    }
}

?>