<?php

trait MyApp_Handle_SU_Do
{
    //*
    //* function ShiftUser, Parameter list: $user
    //*
    //* Attempt to shift user in Session table.
    //*

    function MyApp_Handle_SU_Do($doit=FALSE,$unset=FALSE)
    {
        if (!$doit && $this->GetPOST("Shift")!=1) { return; }
        $person=$this->MyApp_Handle_SU_User_Read();

        if ($person[ "Profile_Admin" ]==2)
        {
            die("SU to Admin not allowed...");
        }

        $profiles=$this->MyApp_Profile_User_Profiles($person);
        
        $user=$person[ "Email" ];
        var_dump($user);
        $logindata=$this->MyApp_Login_Retrieve_Data($user);
        var_dump($logindata);
        $profile="";
        foreach ($this->MyApp_Profile_User_Profiles($person) as $rprofile)
        {
            if
                (
                    !empty($logindata[ "Profile_".$rprofile ])
                    &&
                    $logindata[ "Profile_".$rprofile ]==2
                )
            {
                $profile=$rprofile;
                break;
            }
        }
        
        if (empty($profile))
        {
            $this->ApplicationObj()->MyApp_Interface_Message_Add("No suitable profile.");
        }

        if (!is_array($logindata))
        {
            $this->ApplicationObj()->MyApp_Interface_Message_Add("Unable to retrieve Login Data.");
        }

        if (empty($logindata))
        {
            $this->ApplicationObj()->MyApp_Interface_Message_Add("No Login Data");
        }

        
        if
            (
                !empty($profile)
                &&
                is_array($logindata)
                &&
                count($logindata)>0
            )
        {
            $session=$this->SessionData;

            if ($unset)
            {
                $session[ "SULoginID" ]=$this->LoginData[ "ID" ];
            }
            else
            {
                $session[ "SULoginID" ]=0;
            }

            $session[ "LoginID" ]=$logindata[ "ID" ];
            $session[ "Login" ]=$user;
            $session[ "LoginName" ]=$logindata[ "Name" ];
            $session[ "Profile" ]=$profile;

            $this->Sql_Update_Item
            (
               $session,
               array
               (
                   "SID" => $session[ "SID" ],
               ),
               array(),
               $this->MyApp_Session_Table_Get()
            );

            $this->ConstantCookieVars=
                preg_grep
                (
                    '/^Profile$/',
                    $this->ConstantCookieVars,
                    PREG_GREP_INVERT
                );

            array_push($this->ConstantCookieVars,"SID");
            $this->MakeCGI_Cookies_Reset();

            $args=$this->CGI_Query2Hash();
            $args=$this->CGI_Hidden2Hash($args);
            $query=$this->CGI_Hash2Query($args);

            $this->CGI_CommonArgs_Add($args);
            $args[ "Action" ]="Start";

            
            //Reload
            $this->MyApp_CGI_Reload_Try($args);
            exit();
        }
        
    }
}

?>