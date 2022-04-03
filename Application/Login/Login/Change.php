<?php

class LoginLoginChange extends LoginLoginMail
{

    //*
    //* function ChangeLoginForm, Parameter list: $logindata
    //*
    //* Creates the change login (email) form.
    //*

    function ChangeLoginForm()
    {
        $newemail=$this->GetGETOrPOST("NewEmail");
        $code=$this->GetGETOrPOST("Code");

        $newemail=preg_replace('/\s/',"",$newemail);
        $code=preg_replace('/\s/',"",$code);

        $this->MyApp_Interface_Head();

        $this->Htmls_Echo
        (
            array
            (
                $this->H
                (
                    1,
                    $this->MyLanguage_GetMessage
                    (
                        "Update_Login_Title"
                    )
                ),
                $this->Htmls_Form
                (
                    1,
                    "NewLogin",
                    "",
                    $contents=
                    array
                    (
                        
                        $this->ChangeLoginTable($newemail,$code),
                        $this->CGI_MakeHiddenFields(),
                    ),
                    $args=array
                    (
                        "Buttons" => $this->Button("submit","Enviar"),
                        "Hiddens" => array
                        (
                            "Update" => 1,
                        ),
                    )
                )
            )
        );

        if ($this->CGI_POSTint("Update")==1)
        {
            if (empty($code))
            {
                $this->UpdateChangeLogin($newemail);
            }
            else
            {
                $this->UpdateChangeCode($newemail,$code);
            }
        }

        exit();

    }

    //*
    //* function TestNewEmail, Parameter list: $newemail
    //*
    //* Returns true/false, whether $newemail is valid and different from current.
    //*

    function TestNewEmail($newemail)
    {
        if ($this->LoginData[ "Email" ]==$newemail) { return FALSE; }

        $items=
            $this->FriendsObj()->Sql_Select_Hashes
            (
                array("Email" => $newemail),
                array("ID")
            );
        
        if (count($items)>0) { return FALSE; }

        return $this->MyEmail_Address_Valid($newemail);
    }


    //*
    //* function ChangeLoginTable, Parameter list: $newemail,$code
    //*
    //* Creates the change password table.
    //*

    function ChangeLoginTable($newemail,$code)
    {
        $table=
            array
            (
               array
               (
                  $this->B
                  (
                      $this->MyLanguage_GetMessage
                      (
                          "Login_Name"
                      ).
                      ":"
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
                      ).
                      ":"
                  ),
                  $this->LoginData[ "Email" ]
               ),
               array
               (
                  $this->B
                  (
                      $this->MyLanguage_GetMessage
                      (
                          "Login_NewEmail"
                      ).
                      ":"
                  ),
                  $this->MakeInput("NewEmail",$newemail,20)
               ),
            );

        if (!$this->TestNewEmail($newemail))
        {
            array_push
            (
               $table,
               array
               (
                  $this->B
                  (
                      $this->MyLanguage_GetMessage
                      (
                          "Login_NewEmailInvalid"
                      )
                  ),
               )
            );
        }
        else
        {
            array_push
            (
               $table,
               array
               (
                  $this->B
                  (
                      $this->MyLanguage_GetMessage
                      (
                          "Login_Code"
                      ).
                      ":"
                  ),
                  $this->MakeInput("Code",$code,20)
               )
           );
        }

        return
            array
            (
                $this->H
                (
                    2,
                    $this->MyLanguage_GetMessage
                    (
                        "Update_Login_Msg"
                    )
                ),
                $this->Htmls_Table("",$table)//,array(),array(),array(),TRUE,TRUE);
            );
    }

    //*
    //* function UpdateChangeLogin, Parameter list: $newemail
    //*
    //* Updates the change password table.
    //*

    function UpdateChangeLogin($newemail)
    {
        if (!$this->TestNewEmail($newemail)) { return FALSE; }

        $this->AddRecoverEntry($this->LoginData);

        $this->SendChangeLoginMail($newemail,$this->LoginData);

        echo 
            $this->H
            (
                3,
                $this->MyLanguage_GetMessage
                (
                    "Recover_Login_Mail_Message"
                )
            );
    }

    //*
    //* function UpdateChangeCode, Parameter list: $newemail,$code
    //*
    //* Checks code and does alteration of match.
    //*

    function UpdateChangeCode($newemail,$code)
    {
        if (!$this->TestNewEmail($newemail)) { return FALSE; }

        $dtime=time()-$this->LoginData[ "RecoverMTime" ];

        if (
              strlen($code>=18)
              &&
              $code==$this->LoginData[ "RecoverCode" ]
              &&
              $dtime<$this->RecoverPasswordTTL
           )
        {
            $oldemail=$this->LoginData[ "Email" ];

            $this->LoginData[ "Email" ]=$newemail;
            $this->LoginData[ "RecoverCode" ]="";
            $this->LoginData[ "RecoverMTime" ]=0;

            $this->Sql_Update_Item_Values_Set
            (
                array("Email","RecoverCode","RecoverMTime"),
                $this->LoginData,
                $this->AuthHash[ "Table" ]
            );

            $this->Sql_Update_Item_Value_Set
            (
                $this->LoginData[ "ID" ],
                "Login",
                $this->LoginData[ "Email" ],
                "LoginID",
                $this->SessionsTable
            );
  
            $this->SendChangedLoginMail($oldemail,$this->LoginData);

            echo 
                $this->H
                (
                    3,
                    $this->MyLanguage_GetMessage
                    (
                        "Recovered_Login_Mail_Message"
                    )
                );
        }
        else
        {
            echo 
                $this->H
                (
                    3,
                    $this->MyLanguage_GetMessage
                    (
                        "Recovered_Login_Error"
                    )
                );
        }
    }
}



?>