<?php

trait MyApp_Login_Headers
{
    //*
    //* function MyApp_Login_Form_Headers, Parameter list:
    //*
    //* Sends necessary headers for login form.
    //*

    function MyApp_Login_Headers_Send()
    {
        if ($this->HeadersSend==0)
        {
            $this->LoginType="Public";
            $this->LogMessage("LoginForm","-");

            $this->MakeCGI_Cookie_Set("SID","",time()-$this->CookieTTL);
            $this->MakeCGI_Cookie_Set("Admin","",time()-$this->CookieTTL);
            $this->MakeCGI_Cookie_Set("ModuleName","",time()-$this->CookieTTL);

            /* $this->MyApp_Profile_Cookie_Send($profile="",-$this->CookieTTL); */
            $this->MakeCGI_Cookies_Reset();

            $this->MyApp_Interface_Head();
        }
    }
}

?>