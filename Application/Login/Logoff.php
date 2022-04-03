<?php

class LoginLogoff extends LoginForm
{
    //*
    //* function DoLogoff, Parameter list: $logindata
    //*
    //* Does logoff, that is, resets the SID cookie and other cookies,
    //* writes a messgae containing link to login and exits.
    //*

    function DoLogoff()
    {
        $this->LoginType="Public";
        $this->LogMessage("Logoff","Logged off");
        $this->CookieTTL=time()-60*60; //in the past to disable

        $unit=$this->GetCGIVarValue("Unit");

        $this->MakeCGI_Cookie_Set("SID","",time()-$this->CookieTTL);
        $this->MakeCGI_Cookie_Set("Admin","",time()-$this->CookieTTL);
        $this->MakeCGI_Cookie_Set("ModuleName","",time()-$this->CookieTTL);

        /* $this->MyApp_Profile_Cookie_Send($profile="",-$this->CookieTTL); */
        
       //Delete entry en session table
        if (isset($this->SessionData[ "SID" ]))
        {
            $this->MyApp_Session_SID_Delete($this->SessionData[ "SID" ]);
        }

        $this->MakeCGI_Cookies_Reset();

        $this->LoginType="Public";
        $this->__Profile__="Public";

        $args=$this->CGI_Query2Hash();
        $args=$this->CGI_Hidden2Hash($args);
        $query=$this->CGI_Hash2Query($args);

        $this->CGI_CommonArgs_Add($args);
        $args[ "Action" ]="Start";

        $this->MyApp_CGI_Reload_Try($args);

        //Shouldn't get here!!
        exit();
    }
}


?>