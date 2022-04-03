<?php

include_once("Auth/Authenticate.php");

trait MyApp_Session_Auth
{
    use
        MyApp_Session_Auth_Authenticate;
    
    //*
    //* Testes authentication
    //*

    function AuthHash($key="")
    {
        if (empty($this->AuthHash))
        {
            $this->AuthHash=
                $this->ReadPHPArray
                (
                    $this->MyApp_Setup_Path().
                    "/".
                    $this->AuthHashFile
                );

            $this->AuthHash[ 'LoginData' ]=
                preg_split
                (
                    '/\s*,\s*/',
                    $this->AuthHash[ 'LoginData' ]
                );
        }

        if (!empty($key))
        {
            if (empty($this->AuthHash[ $key ]))
            {
                return "";
            }
            
            return $this->AuthHash[ $key ];
        }
        return $this->AuthHash;
    }

    //*
    //* Returns paswword Cryptification scheme: MD5 or BlowFish.
    //*

    function MyApp_Session_Cryptification()
    {
        $crypt=$this->AuthHash("Crypt");
        if (empty($crypt)) { $crypt="MD5"; }
        
        return $crypt;
    }
    
    //*
    //* Returns true if cryptificartion is MD5
    //*

    function MyApp_Auth_MD5()
    {
        $crypt=$this->MyApp_Session_Cryptification();

        $res=False;
        if ($crypt=="MD5") { $res=True; }
        
        return $res;
    }
    
    //*
    //* Returns true if cryptification os BlowFish
    //*

    function MyApp_Auth_BlowFish()
    {
        $crypt=$this->MyApp_Session_Cryptification();

        $res=False;
        if ($crypt=="BlowFish") { $res=True; }
        
        return $res;
    }
    
    //*
    //* Testes authentication
    //*

    function MyApp_Session_Auth()
    {
        $login=strtolower($this->CGI_POST("Login"));
        $login=preg_replace('/\s+/',"",$login);

        if (!empty($login))
        {
            $sessions=
                $this->Sql_Select_Hashes
                (
                    array
                    (
                        "Login" => $login,
                    ),
                    array(),"",False,
                    $this->MyApp_Session_Table_Get()
                );

            
            $session=NULL;
            if (count($sessions)>=1)
            {
                //Take latest if doubt...
                $session=array_pop($sessions);
            }

            if (
                  is_array($session) && 
                  $session[ "NAuthenticationAttempts" ]>=$this->MaxLoginAttempts
               )
            {
                $this->MyApp_Session_Auth_TooManyAttempts();
            }
            elseif (count($sessions)>1)
            {
                $this->MyApp_Session_Auth_TooManySessions();
            }

            return $this->MyApp_Session_Auth_Authenticate($login);
        }

        return 0;
    }

    //*
    //* Generates Application bcrypt salt.
    //*

    function MyApp_Auth_Crypt_Password_Salt()
    {
        //$salt = mcrypt_create_iv(22, MCRYPT_DEV_URANDOM);
        $salt = random_bytes(22);
        $salt = base64_encode($salt);
        $salt = str_replace('+', '.', $salt);

        return $salt;
    }
    
    //*
    //* Cryptify using MD5.
    //*

    function MyApp_Auth_Crypt_Password_MD5($newvalue)
    {
        return md5($newvalue);
    }
    
    //*
    //* Cryptify using BlowFish.
    //*

    function MyApp_Auth_Crypt_Password_BlowFish($newvalue)
    {
        return
            password_hash
            (
                $newvalue,
                PASSWORD_BCRYPT,
                array
                (
                    'cost' => 12,
                    'salt' => $this->MyApp_Auth_Crypt_Password_Salt(),
                )
            );
    }
    
    //*
    //* Cryptify using BlowFish.
    //*

    function MyApp_Auth_Crypt_Password_Crypt($value)
    {
        $crypt_value="";
        if ($this->MyApp_Auth_MD5())
        {
            $crypt_value=$this->MyApp_Auth_Crypt_Password_MD5($value);
        }
        elseif ($this->MyApp_Auth_BlowFish())
        {
            $crypt_value=$this->MyApp_Auth_Crypt_Password_BlowFish($value);
        }

        return $crypt_value;
    }
    
    //*
    //* function MyApp_Session_Auth_Password_Verify, Parameter list: $login,$given_password,$stored_password
    //*
    //* Actually verifies the password.
    //*

    function MyApp_Auth_Password_Verify($login,$given_password,$stored_password)
    {
        $crypt=$this->MyApp_Session_Cryptification();

        $res=False;
        if ($crypt=="MD5")
        {
            $crypted_password=$this->MyApp_Auth_Crypt_Password_Crypt($given_password);
            if ($crypted_password==$stored_password)
            {
                $res=True;
            }
        }
        elseif ($crypt=="BlowFish")
        {
            if (password_verify($given_password,$stored_password))
            {
                $res=True;
            }
            elseif (!preg_match('/\$2y\$/',$stored_password))
            {
                
                #Test if password is MD5'ed
                $md5_password=$this->MyApp_Auth_Crypt_Password_MD5($given_password);

                if ($md5_password==$stored_password)
                {
                    $logindata=
                        $this->MyApp_Login_Retrieve_Data
                        (
                            $this->CGI_POST("Login")
                        );
                    
                    #MD5 password match and is not blowfish style, authenticate and update password.

                    $password=$this->MyApp_Auth_Crypt_Password_Crypt($given_password);
                    $this->Sql_Update_Item_Value_Set
                    (
                        $logindata[ "ID" ],
                        $this->AuthHash[ "PasswordField" ],
                        $password,
                        $this->AuthHash[ "IDField" ],
                        $this->SqlTableName($this->AuthHash[ "Table" ])
                    );

                    $res=True;
                }
            }
        }

        return $res;
     }


    //*
    //* function MyApp_Session_Auth_TooManyAttempts, Parameter list:
    //*
    //* Hhandles too any attempts.
    //*

    function MyApp_Session_Auth_TooManyAttempts()
    {
        $this->MyApp_Interface_Head();

        $msg1=
            $this->MyLanguage_GetMessage
            (
                "Session_Blocked_1"
            );
        $msg2=
            $this->MyLanguage_GetMessage
            (
                "Session_Blocked_2"
            );

        $msg1=preg_replace('/#MaxLoginAttempts/',$this->MaxLoginAttempts,$msg1);
        $msg2=preg_replace('/#MaxLoginAttempts/',$this->MaxLoginAttempts,$msg2);
        $this->RegisterBadLogon();

        echo
            $this->H(2,$msg1).
            $this->H(3,$msg2);

        $this->LogMessage("Auth",$msg1);

        $this->DoDie("Ciao....");;
    }


    //*
    //* function MyApp_Session_Auth_TooManySessions, Parameter list: $sid
    //*
    //* Hhandles too any sessions. Really shouldn't occur.
    //*

    function MyApp_Session_Auth_TooManySessions($where)
    {
        $this->Sql_Delete_Items
        (
            $where,
            $this->MyApp_Session_Table_Get()
        );

        $this->MakeCGI_Cookie_Set("SID","",time()-$this->CookieTTL);
        $this->MakeCGI_Cookies_Reset();
        $this->MyApp_Login_Form("More than one LoginID Session!!");

        $this->DoDie("More than one Session");
    }


    //*
    //* function MyApp_Session_Auth_InvalidLogin, Parameter list: $login
    //*
    //* Handles invalid password.
    //*

    function MyApp_Session_Auth_InvalidLogin($login)
    {
        $this->Auth_Message=$this->MyLanguage_GetMessage("Error_PasswordMismatch");         

        $this->LogMessage("Authentication","Invalid login: ".$login);
        $this->RegisterBadLogon();
     }


}

?>