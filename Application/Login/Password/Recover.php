<?php

include_once("Recover/Forms.php");
include_once("Recover/Mail.php");

class LoginPasswordRecover extends LoginPasswordRecoverMail
{ 
    //*
    //* Creates recovery code and inserts record in auth sql table.
    //*

    function AddRecoverEntry(&$user)
    {
        $user[ "RecoverCode" ]=rand().rand();
        $user[ "RecoverMTime" ]=time();

        $this->Sql_Update_Item_Values_Set
        (
           array("RecoverCode","RecoverMTime"),
           $user,
           $this->AuthHash[ "Table" ]
        );
    }

    //*
    //* Retrieves recovery code from auth sql table.
    //*

    function Email2RecoverEntry($email)
    {
        return
            $this->SelectUniqueHash
            (
                $this->AuthHash[ "Table" ],
                array("Email" => $email),
                TRUE,
                array("RecoverCode","RecoverMTime")
            );
    }


    //*
    //* Creates recovery entry and sends mail.
    //*

    function Login_Password_Recovery_Start()
    {
        $user=$this->SelectUniqueHash
        (
           $this->AuthHash[ "Table" ],
           array
           (
              "Email" => $this->GetPOST("Recover_Login")
           ),
           TRUE
        );

        if (
              preg_match('/^\d+$/',$user[ "ID" ])
              &&
              $user[ "ID" ]>0
           )
        {
            $this->AddRecoverEntry($user);
            $this->Login_Password_Mail_Recover($user);
        }

        echo 
            $this->H(3,$this->GetMessage($this->LoginMessages,"Recover_Password_Mail_Message"));
    }

    //*
    //* Handles reset password procedure.
    //*

    function Login_Password_Recover_Has_Login()
    {
        $login=$this->CGI_GETOrPOST("Login");
        if (!empty($login) && preg_match('/^\S+\@\S+$/',$login))
        {
            return True;
        }

        return False;
    }

    //*
    //* Handles reset password procedure.
    //*

    function Login_Password_Recover_Has_Code()
    {
        $code=$this->CGI_GETOrPOST("Code");
        if (!empty($code) && preg_match('/^[0-9]+$/',$code))
        {
            return True;;
        }

        return False;
    }
    
    //*
    //* Handles reset password procedure.
    //*

    function Login_Password_Recover_Handle()
    {
        $this->MyApp_Interface_Head();

        if
            (
                ($this->CGI_GETOrPOSTint("Update")!=1)
                ||
                $this->CGI_GETOrPOST("Recover_Login")==""
            )
        {
            if
                (
                    $this->Login_Password_Recover_Has_Login()
                    &&
                    $this->Login_Password_Recover_Has_Code()
                )
            {
                $this->Login_Password_Recovery_Form_Final();
            }
            else
            {
                $this->Login_Password_Recovery_Form_Init();
            }
        }
        else
        {
            $this->Login_Password_Recovery_Start();
        }

        $this->Htmls_Echo
        (
            $this->Login_Password_Messages()
        );
        exit();

    }
    
    //*
    //* Generates post login messages.
    //*

    function Login_Password_Messages()
    {
        return
            array
            (
                $this->Login_Password_Messages_NonStudents_Only(),
                $this->Login_Password_Messages_Emails(),
            );
    }
    
    //*
    //* Generates post login messages.
    //*

    function Login_Password_Messages_Emails()
    {
        $html=array();
        for ($n=1;$n<=3;$n++)
        {
            array_push
            (
                $html,
                $this->MyLanguage_GetMessage("Email_Message_".$n),
                $this->HR()
            );
        }

        return
            $this->Login_Password_Message
            (
                $html
            );
    }
    
    //*
    //* Generates post login messages.
    //*

    function Login_Password_Messages_NonStudents_Only()
    {
        return
            $this->Login_Password_Message
            (
                $this->MyLanguage_GetMessage("Students_Only_Reset_Message")
            );
    }
    //*
    //* Generates post login messages.
    //*

    function Login_Password_Message($msg)
    {
        return
            $this->Htmls_DIV
            (
                $this->Htmls_DIV
                (

                    $msg,
                    array
                    (
                        "CLASS" => 'postloginmsg message-body',
                    )
                ),
                array
                (
                    "CLASS" => 'message is-warning',
                )
            );
    }
}


?>