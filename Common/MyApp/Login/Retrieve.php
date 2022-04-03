<?php

trait MyApp_Login_Retrieve
{
    //*
    //* Retrieve login data from AuthHash[ "Table" ], given login.
    //*

    function MyApp_Login_Retrieve_LoginData($login,$table="")
    {
        $this->AuthHash();
        $this->UsersObj()->Sql_Table_Structure_Update();

        return
            $this->UsersObj()->Sql_Select_Hash_Unique
            (
                "LOWER(".
                $this->Sql_Table_Column_Name_Qualify($this->AuthHash[ "LoginField" ]).
                ")=".
                $this->Sql_Table_Column_Value_Qualify($login),
                TRUE,
                $sqldata=array(),
                $this->MyApp_Login_SQL_Table($table)
            );
    }

    //*
    //* Name of table with Login Data. Table may have been specified by Session entry.
    //*

    function MyApp_Login_SQL_Table($table="")
    {
        if (!empty($table)) { return $table; }
        return $this->SqlTableName($this->AuthHash[ "Table" ]);
    }
    
    //*
    //* Retrieve login data from AuthHash[ "Table" ], given login.
    //* Tries login and in sequence $login.AuthHash[ "LoginAppend" ]
    //*

    function MyApp_Login_Retrieve_Data($login="")
    {
        if (!isset($login) || $login=="") { $login=$_POST[ "Login" ]; }

        if (method_exists($this,"FriendsObj"))
        {
            $this->FriendsObj()->ItemData();
            $this->FriendsObj()->Sql_Table_Structure_Update();
        }

        $authdata=$this->MyApp_Login_Retrieve_LoginData($login);
        if (is_array($authdata))
        {
            $nprofiles=count($this->ValidProfiles);
            if (preg_grep('/^Public$/',$this->ValidProfiles)) { $nprofiles--; }

            $rauth=array();
            foreach
                (
                    array("ID","Login","Password")
                    as $id => $data
                )
            {
                $rauth[ $data ]=$authdata[ $this->AuthHash[ $data."Field" ] ];
            }

            foreach ($this->AuthHash[ "LoginData" ] as $id => $data)
            {
                $rauth[ $data ]=$authdata[ $data ];
            }

            $rauth[ "SQL" ]=$authdata[ "SQL" ];
            
            for ($n=0;$n<count($this->ValidProfiles);$n++)
            {
                if ($this->ValidProfiles[$n]!="Public")
                {
                    $data="Profile_".$this->ValidProfiles[$n];
                    $rauth[ $data ]=1;
                    if (isset($authdata[ $data ]))
                    {
                        $rauth[ $data ]=$authdata[ $data ];
                    }
                }
            }

           return $rauth;
        }
        else
        {
            return array();
        }

        $this->DoDie("Unable to retrieve login data",$login);
    }
}

?>