<?php

trait MyApp_Login_Table
{
    //*
    //* Creates login form table.
    //*

    function MyApp_Login_Table()
    {
        $login=$this->CGI_POST("Login");
        if (empty($login))
        {
            $login=$this->CGI_GET("Email");
        }
 
        return
            array
            (
                array
                (
                    $this->B
                    (
                        $this->MyLanguage_GetMessage("LoginDataTitle").
                        ":"
                    ),
                    $this->Htmls_Input_Text
                    (
                        "Login",
                        $login,
                        array
                        (
                            "ID"   => "Login",
                            "SIZE" => 25,
                        )
                    )
                ),
                array
                (
                    $this->B
                    (
                        $this->MyLanguage_GetMessage("PasswordDataTitle").
                        ":"
                    ),
                    $this->Htmls_Input_Password
                    (
                        "Password",
                        "",
                        array
                        (
                            "ID"   => "Email",
                            "SIZE" => 25,
                        )
                    )
                ),
            );

    }
}

?>