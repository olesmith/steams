<?php


trait MyApp_Session_Auth_Authenticate
{
    //*
    //* 
    //*

    function MyApp_Session_Auth_Authenticate($login)
    {
        $logindata=$this->MyApp_Login_Retrieve_Data($login);
        if (count($logindata)>0)
        {
           $rlogin=$logindata[ "Login" ];
            if (strtolower($rlogin)==strtolower($login))
            {
                $given_password=$this->CGI_POST("Password");

                if
                    (
                        $this->MyApp_Auth_Password_Verify
                        (
                            $rlogin,
                            $given_password,
                            $logindata[ "Password" ]
                        )
                    )
                {
                    $this->MyApp_Login_SetData($logindata);
                    $this->Authenticated=TRUE;

                    return TRUE;
                }
                else
                {
                    $this->Auth_Message=
                        $this->MyLanguage_GetMessage("Error_PasswordMismatch");         
                }
                var_dump("Logon",$this->Auth_Message);
             }
        }

        $this->Authenticated=FALSE;

        //Invalid login, if we are still here!
        $this->MyApp_Session_Auth_InvalidLogin($login);
    }

}

?>