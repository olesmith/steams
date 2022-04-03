<?php

trait MyApp_Login_Form
{
    var $MyApp_Login_Form_Send=False;
    
    //*
    //* Creates login form.
    //*

    function MyApp_Login_Form($msg1="",$msg2="")
    {
        /* if ($this->Caller()!="LoginForm" && method_exists($this,"LoginForm")) */
        /* { */
        /*     $this->LoginForm(); */

        /*     return; */
        /* } */

        if ($this->HeadersSend==0)
        {
            $this->MyApp_Login_Headers_Send();
        }

        if ($this->MyApp_Login_Form_Send) { return; }
        $this->MyApp_Login_Form_Send=True;
        
        $this->Htmls_Echo
        (
            $this->Htmls_Comment_Section
            (
                "Login Form",
                array
                (
                    $this->MyApp_Login_Form_Pre_Messages(),
                    $msg1,$msg2,
                    $this->Htmls_Form
                    (
                        1,
                        $this->MyApp_Login_Form_ID(),
                            
                        "Logon",
                        
                        $this->MyApp_Login_Html($msg1),
                        
                        $this->MyApp_Login_Form_Args(),
                        
                        $options=array()
                    ),
                    $this->MyApp_Login_Form_Trailer($msg2),
                )
            )
        );
    }
    //*
    //* Login Form ID. Might be overwritten.
    //*

    function MyApp_Login_Form_ID()
    {
        return "Login_Form";
    }

    //*
    //* 
    //*

    function MyApp_Login_Form_Trailer($msg)
    {
        return
            array
            (
                $this->H(3,$msg),
                $this->Htmls_Tag
                (
                    "DIV",
                    $this->Auth_Message,
                    array("CLASS" => 'errors center')
                ),
                $this->MyApp_Login_Form_Post_Messages(),
                $this->BR().$this->BR(),
            );
    }
    
    //*
    //* 
    //*

    function MyApp_Login_Form_Args()
    {
        return
            array
            (
                "Hiddens" => array
                (
                    "Logon" => 1,
                ),
                "Buttons" =>$this->Htmls_Buttons
                (
                    $this->GetMessage
                    (
                        $this->LoginMessages,"LoginSendButton"
                    )
                ),
                "Method" => "post",
                "No_OnSubmit" => True,
                "Uploads" => False,
                "CGI_Args" => $this->MyApp_Login_Form_URI(),
            );
    }
    
    //*
    //* Figures out FORM URI, based on current URI.
    //* Adds current Action as LastAction.
    //* Logon procedure will redirect back to LastAction (if given).
    //*

    function MyApp_Login_Form_URI()
    {
        $uri=
            array_merge
            (
                $this->CGI_URI2Hash(),
                array
                (
                    "ModuleName" => $this->CGI_GET("ModuleName"),
                    "Action"     => "Logon",
                    //store last action
                    "LastAction" => $this->CGI_GET("Action"),
                    "Login"      => 1,
                )
            );

        foreach (array("RAW","Menu","HorMenu","NoHorMenu") as $key)
        {
            if (isset($uri[ $key ])) { unset($uri[ $key ]); }
        }

        return $uri;
    }
    
    //*
    //* Returns post message to Login form.
    //*

    function MyApp_Login_PostMessage()
    {
        return
            $this->Htmls_Text
            (
                $this->MyApp_Login_Form_Post_Messages()
            );
    }
    
    //*
    //* Returns login form post message.
    //*

    function MyApp_Login_Form_Post_Messages()
    {
        $msgs=
            array
            (
                $this->Htmls_DIVS_Message
                (
                    $this->GetMessage
                    (
                        $this->LoginMessages,
                        "LoginPostMessage"
                    ),
                    'postloginmsg'
                )
            );

        $unitmsg=$this->Unit("Login_Message");
        if (preg_match('/\S/',$unitmsg))
        {
            array_push
            (
                $msgs,
                $this->Htmls_DIVS_Message
                (
                    $unitmsg,
                    'postloginmsg'
                )
            );
        }

        
        return $msgs;
    }

    
    //*
    //* function MyApp_Login_Form_Pre_Message, Parameter list:
    //*
    //* Returns login form pre message.
    //*

    function MyApp_Login_Form_Pre_Messages()
    {
        $premsg=array();
        if ($this->LoginPreMessage!="")
        {
            if (method_exists($this,$this->LoginPreMessage))
            {
                $method=$this->LoginPreMessage;
                $premsg=$this->$method();
            }
            else
            {

                $premsg=$this->H(2,$this->LoginPreMessage);
            }
        }

        return $premsg;
    }
}

?>