<?php


trait MyApp_Handle_Logon
{
    //*
    //* function MyApp_Handle_Logon, Parameter list:
    //*
    //* The Start Handler. Should display some basic info.
    //* If LastAction is in CGI_URI2Hash, do Login and reload with this action.
    //* Otherwise relaod with action Start.
    //*

    function MyApp_Handle_Logon()
    {
        if ($this->LoginType=="Public")
        {
            if ($this->CGI_GETOrPOSTint("Logon")==1)
            {
                $this->MyApp_Session_Init();

                if ($this->Authenticated)
                {
                    $args=$this->CGI_URI2Hash();

                    //Default action
                    $args[ "Action" ]="Start";
                    
                    //LastAction GET arg appended in Login_Form.
                    if (!empty($args[ "LastAction" ]))
                    {
                        if ($args[ "LastAction" ]!="Logon")
                        {
                            $args[ "Action" ]=$args[ "LastAction" ];
                            unset($args[ "LastAction" ]);
                        }
                        
                        unset($args[ "Login" ]);
                    }

                    $this->CGI_Redirect($args);
                    $this->DoExit();
                }
            }

            $this->MyApp_Login_Form();

            //$this->DoExit();
        }
        else
        {
            $this->MyApp_Handle_Start();
        }
    }

    //*
    //* function MyApp_Handle_Logoff, Parameter list: 
    //*
    //* Carries out logoff, ie: Calls DoLogoff and exits.
    //*

    function MyApp_Handle_Logoff()
    {
        $this->DoLogoff();
        $this->DoExit();
    }
    
    //*
    //* function MyApp_Handle_Password_Change, Parameter list: 
    //*
    //* Handles password change.
    //*

    function MyApp_Handle_Password_Change()
    {
        $this->MyApp_Login_Password_Change_Form();
        exit();
    }
}

?>