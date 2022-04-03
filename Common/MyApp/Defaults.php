<?php

trait MyApp_Defaults
{
    function MyApp_Defaults()
    {
        return array
            (
                "IsMain" => TRUE,
                "NoLeftMenu" => FALSE,

                "IsMain" => TRUE,
                "MayCreateSessionTable" => FALSE,
                "SavePath" => "?Action=Start",

                "Logging" => FALSE,

                "Temp_Path" => "tmp",

                "SessionTable" => "Sessions",
                "MayCreateSessionTable" => FALSE,
                "MaxLoginAttempts" => 10,

                "SetupPath" => "System",
                "SetupFile" => "Setup.php",

                "MessageFiles" => array(),
                "MessageDirs" => array(
                    //"../Common","../Application","../MySql2/Messages/"
                ),

                "SubModules" => array(),

                "ProfilesFile" => "Profiles.php",
                "LoginType" => "Public",
                "Profile" => "Public",

                "LeftMenuFile" => "LeftMenu.php",

                "DefaultAction" => "Start",
                "AppModules" => array(),


                "ActionPaths" => array
                (
                    $this->MyApp_Setup_Root().
                    "/Application/Actions"
                ),
                
                "ActionFiles" => array("Actions.php"),
                "Actions" => array(),

                "Language_File" => "Languages.php",
                "DB" => FALSE,
                "DBHashFile" => "DB.php",
                "DBHash" => array(),
                "DBType" => "MySql",


                "Authentication" => FALSE,
                "AuthHashFile" => "Auth.Data.php",
                "AuthHash" => array(),

                "Mail" => FALSE,
                "MailSetup" => "Mail.php",
                "MailInfo" => array(),

                //CGI Vars that points to global hashes
                "CGIVars" => array(),
            );
    }
}

?>