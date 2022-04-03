<?php

trait MakeCGI_Cookies
{
    var $URL;
    var $ConstantCookieVars=array("SID","Lang");
    
    var $CookieVars=array();
    var $CookieValues=array();
    var $CookieTTL=3600;
    var $CookiesWritten=0;
    var $CookiesSet=array();
    var $CookieLog=array();

    var $GlobalGCVars=array();
    var $MakeCGI_Cookie_TTL=3600;
    var $MakeCGI_Cookie_Written=FALSE;
    var $MakeCGI_Cookie_Debug=False;

    //*
    //* Sets cookie $cookie to value $value. If $expire is "",
    //* uses time()+$this->CookieTTL as expires value.
    //*

    function MakeCGI_Cookie_Set($name,$value="",$expire=0)
    {
        $res=$this->MakeCGI_CGI_Is();
        if (!$res)
        {
            return;
        }
        
        if (empty($expire)) { $expire=time()+$this->ApplicationObj()->CookieTTL; }
        
        #var_dump($name,$value,$this->$name);
        if ($value!="" && property_exists($this,$name)) { $value=$this->$name; }

        if (is_array($value))
        {
            return FALSE;
        }

        if ($this->Handle && $this->CookiesWritten==0)
        {
            if (!$this->ApplicationObj()->HeadersSend)
            {
                $cookie_path=$this->ApplicationObj()->CGI_Cookie_Path();
                $cookie_path="/; samesite=strict";
                
                setcookie
                (
                    $name,$value,$expire,
                    $cookie_path
                );
                
                //$_COOKIE[ $name ]=$value;

                $this->CookiesSet[ $name ]=$value;

                $caller1=$this->CallStack_Caller(2);
                $caller2=$this->CallStack_Caller(3);
                $msg=
                    "Set Cookie: $name=$value;".
                    "path=".
                    $cookie_path.
                    "; ".
                    "ttl=".
                    $this->ApplicationObj()->CookieTTL.
                    "; ".
                    $caller1[ 'function' ].
                    "; ".
                    $caller2[ 'function' ];
                
                array_push
                (
                    $this->Cookie_Msgs,
                    $msg
                );

                if ($this->MakeCGI_Cookie_Debug)
                {
                    $this->ApplicationObj()->MyApp_Interface_Message_Add
                    (
                        $msg
                    );
                }
                
                return $value;
            }
        }
        elseif ($this->CookiesWritten!=0)
        {
            //print "Late cookie: $name";
            //exit();
        }

        return FALSE;
    }

    //*
    //* Sets actual cookies included in $this->CookieVars.
    //*

    function MakeCGI_Cookies_Set($cookievars=array(),$values=array())
    {
        if ($this->CGI_COOKIEOrGET("NoHeads")==1)
        {
            array_push($this->CookieVars,"NoHeads");
            array_push($cookievars,"NoHeads");
            $values["NoHeads" ]=1;
        }

        if ($this->CookiesWritten==0)
        {
            if ($this->CookieTTL==0) { $this->CookieTTL=60*60; }
            if (count($cookievars)==0) { $cookievars=$this->CookieVars; }

            $rcookievars=array();
            foreach ($cookievars as $cookievar)
            {
                $cookievalue="";
                if (isset($values[ $cookievar ]))
                {
                    $cookievalue=$values[ $cookievar ];
                }

                if (
                      $cookievalue==""
                      &&
                      isset($this->CookieValues[ $cookievar ])
                   )
                {
                    $cookievalue=$this->CookieValues[ $cookievar ];
                }

                if ($cookievar=="Admin")
                {
                    if ($this->GetCGIVarValue("Action")=="Admin")
                    {
                        $cookievalue=1;
                    }
                    elseif ($this->GetCGIVarValue("Action")=="NoAdmin")
                    {
                        $cookievalue=0;
                    }
                    else
                    {
                        $cookievalue=$_COOKIE[ "Admin" ];
                    }
                    $cookievalue=$this->GetCGIVarValue($cookievar,1);
                }
                elseif (empty($cookievalue))
                {
                    $cookievalue=$this->GetCGIVarValue($cookievar,1);
                }

                $rcookievars[ $cookievar ]=
                    $this->MakeCGI_Cookie_Set
                    (
                        $cookievar,$cookievalue,time()+$this->CookieTTL
                    );
            }
        }
        else
        {
            //print "Late write cookies...";
            //exit();
        }

        $this->CookiesWritten=1;
    }

    //*
    //* Resets actual cookies included in $this->CookieVars, ie.
    //* sets them with value less than time().
    //*

    function MakeCGI_Cookies_Reset($deletesid=False)
    {
        $noheads=$this->CGI_COOKIEOrGET("NoHeads");

        $msgs=array();
        if ($this->CookiesWritten==0)
        {
            if ($this->CookieTTL==0) { $this->CookieTTL=60*60; }
            $cookievars=$this->CookieVars;

            foreach ($_COOKIE as $cookievar => $cookievalue)
            {
                if
                    (
                        !preg_grep
                        (
                            '/^'.$cookievar.'$/',
                            $this->ConstantCookieVars
                        )
                    )
                {
                    if ($cookievar!="SID" || $deletesid)
                    {                    
                        $this->MakeCGI_Cookie_Set
                        (
                            $cookievar,
                            "",
                            time()-$this->CookieTTL
                        );

                        array_push($msgs,$cookievar);
                    }
                }
            }

            if ($noheads==1)
            {
                $this->MakeCGI_Cookie_Set
                (
                    "NoHeads",
                    1,
                    time()+$this->CookieTTL
                );
            }
        }
        else
        {
            //print "Late reset cookies...";
            //exit();
        }

        //print join(", ",$msgs); exit();
        //$this->CookiesWritten=1;
    }


    var $Cookie_Msgs=array();
    
    //*
    //* Sets actual cookies included in $this->CookieVars.
    //*

    function MakeCGI_Cookies_Show()
    {
        $list=$this->Cookie_Msgs;
        foreach ($this->CookiesSet as $name => $value)
        {
            array_push($list,"$name => $value");
        }

        echo
            $this->Htmls_Text
            (
                $this->Htmls_List($list)
            );
    }
}
?>