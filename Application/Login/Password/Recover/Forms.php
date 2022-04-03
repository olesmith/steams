<?php

class LoginPasswordRecoverForms extends LoginPasswordChange
{
    //*
    //* function Login_Password_Recovery_Form_Init, Parameter list: $logindata
    //*
    //* Creates solicitation of reset pássword form.
    //*

    function Login_Password_Recovery_Form_Init()
    {
        $login=$this->CGI_GET("Recover_Login");
        if (empty($login)) { $login=$this->GetGET("Login"); }

        $this->Htmls_Echo
        (
            array
            (
                $this->Htmls_Form
                (
                    1,
                    "Recover_Password",
                    "",

                    //$contents=
                    array
                    (
                        $this->Htmls_H
                        (
                            2,
                            $this->MyLanguage_GetMessage("Recover_Password_Title")
                        ),
                        $this->Htmls_H
                        (
                            3,
                            array
                            (
                                $this->MyLanguage_GetMessage("Recover_Password_SubTitle"),
                                $this->MakeInput
                                (
                                    "Recover_Login",
                                    $login,
                                    25,
                                    array
                                    (
                                        "PLACEHOLDER" => "Email"
                                    )
                                ),
                            )
                        ),
                    ),
                    
                    //$args=
                    array
                    (
                        "Buttons" => $this->MakeButton
                        (
                            "submit",
                            $this->MyLanguage_GetMessage("Recover_Password_Button")
                        ),
                        "Hiddens" => array
                        (
                            "Update" => 1,
                        ),
                    )
                ),//array
                $this->Htmls_H
                (
                    3,
                    $this->MyLanguage_GetMessage("Recover_Password_Info")
                ),
            )
        );
    }

    //*
    //* function Login_Password_Recovery_Form_Final, Parameter list:
    //*
    //* Final recover password dialogue. Tests if Login and Code are given,
    //* and if they are, prints the newpassword and repeat password fields.
    //* If Update is set, and passwords match, changes the password and resets
    //* the access code.
    //*

    function Login_Password_Recovery_Form_Final()
    {
        $changed=FALSE;
        $message="";

        $login=$this->CGI_GETOrPOST("Login");
        $code=$this->CGI_GETOrPOST("Code");

        if
            (
                $this->CGI_POSTint("Update")==1
                &&
                $login!="" //only POST, should com from form hidden fields
                &&
                preg_match('/^\S+\@\S+$/',$login)
                &&
                $code!=""
                &&
                preg_match('/^\d+$/',$code)
            )
        {
            $user=
                $this->MySqlItemValues
                (
                    $this->AuthHash[ "Table" ],
                    $this->AuthHash[ "LoginField" ],
                    $login,
                    array
                    (
                        "ID",
                        $this->AuthHash[ "LoginField" ],
                        "Name",
                        "RecoverCode",
                        "RecoverMTime"
                    ) 
                );

            $dtime=time()-$user[ "RecoverMTime" ];
            if
                (
                    preg_match('/^\d+$/',$user[ "ID" ])
                    &&
                    $user[ "ID" ]>0
                    &&
                    $code==$user[ "RecoverCode" ]
                    &&
                    $dtime>0
                    &&
                    $dtime<$this->RecoverPasswordTTL
                )
            {
                $pwd1=$this->GetPOST("Password1");
                $pwd2=$this->GetPOST("Password2");
                if ($pwd1==$pwd2)
                {
                    if ($this->MyApp_Login_Password_Valid_Is($pwd1,$message)>=8)
                    {
                        $user[ "NewPassword" ]="*****************";
                        $user[ $this->AuthHash[ "PasswordField" ] ]=
                            $this->MyApp_Auth_Crypt_Password_Crypt($pwd1);
                        $user[ "RecoverCode" ]=0;
                        $user[ "RecoverMTime" ]=0;

                        $this->Sql_Update_Item_Values_Set
                        (
                            array
                            (
                                $this->AuthHash[ "PasswordField" ],
                                "RecoverCode",
                                "RecoverMTime"
                            ),
                            $user,
                            $this->AuthHash[ "Table" ]
                        );
 
                        $this->Login_Password_Mail_Recovered($user);

                        echo
                            $this->H
                            (
                                4,
                                $this->MyLanguage_GetMessage("Password_Updated")
                            );

                        exit();
                    }
                    else
                    {
                        $message=
                            $this->MyLanguage_GetMessage("Error_PasswordNotAccepted");
                    }
                }
                else
                {
                    $message=$this->MyLanguage_GetMessage("Error_PasswordMismatch");
                }
            }
            else
            {
                $message=$this->MyLanguage_GetMessage("Error_InvalidCode");
            }
        }

        $unit=$this->Unit;
        if (is_array($unit) && !empty($unit[ "ID" ])) { $unit=$unit[ "ID" ]; }


        $this->Htmls_Echo
        (
            array
            (
                $this->Htmls_Form
                (
                    1,
                    "Update_Password",
                    "",

                    $contents=
                    array
                    (
                        $this->H
                        (
                            1,
                            $this->MyLanguage_GetMessage("Update_Password_Title")
                        ),
                        $this->H(4,$message),
                        $this->H
                        (
                            2,
                            $this->MyLanguage_GetMessage("Update_Password_Msg")
                        ),
                        $this->Htmls_Table
                        (
                            "",
                            array
                            (
                                array
                                (
                                    $this->B
                                    (
                                        $this->MyLanguage_GetMessage("Login_User").
                                        ":"
                                    ),
                                    $this->CGI_GETOrPOST("Login")
                                ),
                                array
                                (
                                    $this->B
                                    (
                                        $this->MyLanguage_GetMessage("Login_Password1").
                                        ":"
                                    ),
                                    $this->MakePassword("Password1","",10)
                                ),
                                array
                                (
                                    $this->B
                                    (
                                        $this->MyLanguage_GetMessage("Login_Password2").
                                        ":"
                                    ),
                                    $this->MakePassword("Password2","",10)
                                ),
                            )
                        ),
                    ),

                    $args=
                    array
                    (
                        "Buttons" => $this->Buttons(),
                        "Hiddens" => array
                        (
                            "Login"  => $this->CGI_GETOrPOST("Login"),
                            "Unit"   => $unit,
                            "Code"   => $this->CGI_GETOrPOST("Code"),
                            "Update" => 1,
                        ),
                    )
                )
            )
        );


        exit();

    }
    
 
}


?>