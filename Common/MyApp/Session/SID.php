<?php


trait MyApp_Session_SID
{
    function MyApp_Session_Msg($msg)
    {
        $this->MyApp_Interface_Message_Add
        (
            "Session Msg: ".$msg."; "
        );

        if (!empty($this->Session[ "ID" ]))
        {
            $this->MyApp_Interface_Message_Add
            (
                $this->Sql_Select_Hash_Value
                (
                    $this->Session[ "ID" ],
                    "Profile",$idvar="ID",
                    $noecho=FALSE,
                    $this->MyApp_Session_Table_Get()
                ),
                $this->Session[ "Profile" ]
            );
        }
    }
    
    //*
    //* function MyApp_Session_SID_New, Parameter list: $sid
    //*
    //* Registers new $sid session.
    //*

    function MyApp_Session_SID_New()
    {
        $this->MyApp_Session_SID_User_Deletes($this->LoginData[ "ID" ]);
        $this->Authenticated=TRUE;

        $sid=rand().rand().rand();
        $time=time();
        $this->Session=
            array
            (
                "SID"       => $sid,
                "LoginID"   => $this->LoginData[ "ID" ],
                "Login"     => $this->LoginData[ "Login" ],
                "LoginName" => $this->LoginData[ "Name" ],
                "SQL_Table" => $this->LoginData[ "SQL" ],
                "CTime"     => $time,
                "ATime"     => $time,
                "MTime"     => $time,
                "IP"        => $_SERVER[ "REMOTE_ADDR" ],
                "Profile"   => $this->MyApp_Profile_Default(),
                "Authenticated"  => 2,
                "LastAuthenticationAttempt"  => $time,
                "LastAuthenticationSuccess"  => $time,
                "NAuthenticationAttempts"  => 0,
            );

        $this->Sql_Insert_Item
        (
            $this->Session,
            $this->MyApp_Session_Table_Get()
        );
        
        $this->MakeCGI_Cookie_Set
        (
            "SID",
            $sid,
            $time+$this->CookieTTL
        );

        return $sid;
    }

    //*
    //* function MyApp_Session_SID_Read, Parameter list: $sid
    //*
    //* Reads $sid as session SID.

    function MyApp_Session_SID_Read($sid)
    {
        $this->Session=
            $this->Sql_Select_Hash
            (
                array
                (
                    "SID" => $sid
                ),
                array(),
                TRUE,
                $this->MyApp_Session_Table_Get()
            );

        $this->__Profile__=$this->Session[ "Profile" ];
    }

    //*
    //* function MyApp_Session_SID_2LoginData, Parameter list: $sid
    //*
    //* Reads $sid as session SID.

    function MyApp_Session_SID_2LoginData($sid)
    {
        $this->MyApp_Login_SetData
        (
            $this->MyApp_Login_Retrieve_LoginData
            (
                $this->Session[ "Login" ],
                $this->Session[ "SQL_Table" ]
            )
        );
    }

    //*
    //* function MyApp_Session_SID_Update, Parameter list: $sid
    //*
    //* Updates session entry.
    //*

    function MyApp_Session_SID_Update($sid)
    {
        if ($this->CGI_GET("Action")=="Download") { return; }
        
        //$this->MyApp_Session_SID_User_Deletes($this->LoginData[ "ID" ]);
        $this->Authenticated=TRUE;

        $time=time();
        $this->Session[ "Authenticated" ]=2;
        $this->Session[ "LastAuthenticationAttempt" ]=$time;
        $this->Session[ "LastAuthenticationSuccess" ]=$time;
        $this->Session[ "NAuthenticationAttempts" ]=0;
        $this->Session[ "ATime" ]=$time;
        $this->Session[ "MTime" ]=$time;

        $profile=$this->MyApp_Profiles_CGI_Get();
        if ($this->Session[ "Profile" ]!=$profile)
        {
            $this->Session[ "Profile" ]=$profile;
        }

        $this->Sql_Update_Item_Values_Set
        (
           array
           (
              "Authenticated",
              "LastAuthenticationAttempt","LastAuthenticationSuccess",
              "NAuthenticationAttempts","ATime","Profile"
           ),
           $this->Session,
           $this->MyApp_Session_Table_Get()
        );

        $this->MakeCGI_Cookie_Set("SID",$sid,$time+$this->CookieTTL);
    }

    //*
    //* function MyApp_Session_SID_Delete, Parameter list: $sid
    //*
    //* Deletes $sid in sessions the table.
    //*

    function MyApp_Session_SID_Delete($sid)
    {
        $this->MakeCGI_Cookie_Set("SID","",time()-$this->CookieTTL);
        $this->Sql_Delete_Items
        (
           array
           (
              "SID" => $sid,
           ),
           $this->MyApp_Session_Table_Get()
        );
    }
    //*
    //* function MyApp_Session_SID_User_Deletes, Parameter list: $loginid=""
    //*
    //* Deletes SID=$sid entries in sessions the table.
    //*

    function MyApp_Session_SID_User_Deletes($loginid="")
    {
        if (empty($loginid)) { $loginid=$this->LoginData[ "ID" ]; }
        if (empty($loginid)) { return; }

        //Delete all entries associated with
        //LoginID $loginid in session table
        $this->Sql_Delete_Items
        (
           array
           (
              "LoginID" => $loginid,
           ),
           $this->MyApp_Session_Table_Get()
        );
    }



}

?>