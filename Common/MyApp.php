<?php


include_once("MyMod.php");
include_once("MyMessage.php");
include_once("ShowDir.php");


include_once("MyApp/CGI.php");
include_once("MyApp/Messages.php");
include_once("MyApp/Logging.php");
include_once("MyApp/Interface.php");
include_once("MyApp/Language.php");

include_once("MyApp/Mail.php");
include_once("MyApp/Login.php");
include_once("MyApp/Session.php");
include_once("MyApp/Actions.php");
include_once("MyApp/Profiles.php");
include_once("MyApp/Handle.php");
include_once("MyApp/Setup.php");
include_once("MyApp/Access.php");
include_once("MyApp/Module.php");
include_once("MyApp/CGIVars.php");
include_once("MyApp/Globals.php");
include_once("MyApp/Cookies.php");
include_once("MyApp/SubModules.php");
include_once("MyApp/Defaults.php");
include_once("MyApp/JS.php");


trait MyApp
{
    use
        MyMod,
        MyMessage,
        ShowDir,
        MyApp_CGI,MyApp_Messages,MyApp_Logging,MyApp_Interface,MyApp_Language,
        MyApp_Mail,MyApp_Cookies,
        MyApp_Login,MyApp_Session,
        MyApp_Actions,MyApp_Access,MyApp_Module,
        MyApp_Profiles,MyApp_Handle,MyApp_Setup,
        MyApp_Globals,
        MyApp_CGIVars,
        MyApp_SubModules,
        MyApp_Defaults,
        MyApp_JS;

    var $Tables=array();
    var $TablesColumns=array();
    var $ItemHash=array();
    
    var $MyApp_URL="";
    var $MyApp_Latex_Filters=array();

    var $MyApp_Module="";
    var $MyApp_Handler="";
        

    var $Unit2MailInfo=array
    (
       "Auth","Secure","Port","Host","User","Password",
       "FromEmail","FromName","ReplyTo","CCEmail","BCCEmail",
    );
    
    var $Event2MailInfo=array
    (
       "Auth","Secure","Port","Host","User","Password",
       "FromEmail","FromName","ReplyTo","CCEmail","BCCEmail",
    );

    ##From Mysql2_TInterface
    var $CSSFile="../MySql2/wooid.css";
    var $HtmlSetupHash,$CompanyHash; 
    var $Modules=array();
    var $PreTextMethod="";
    var $InterfacePeriods=array();
    var $NoTail=1;
    var $HeadersSend=0;
    var $DocHeadSend=0;
    var $HeadSend=0;
    var $HTML=FALSE;
    var $TInterfaceDataMessages="TInterface.php";


    var $MyApp_Interface_Head_DocType='<!DOCTYPE html>';
        /* '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">'; */

    var $MyApp_Interface_Head_Scripts_OnLine=
        array
        (
            "JS/Grace.js",
            "JS/GET.js",
            "JS/Color.js",
            "JS/Show_Hide.js",
            "JS/Toggle.js",
            "JS/Click.js",
            "JS/Background.js",
            "JS/Highlight.js",
            "JS/CheckBox.js",
            "JS/Disable.js",
            "JS/Table.js",

            "JS/Load.js",
            "JS/Update.js",
            "JS/Send.js",
            "JS/HorMenu.js",
            //"JS/Module.js",
            //"JS/SiDS.js",
            "JS/Mark.js",
            "JS/Input.js",
            "JS/Uniques.js",
            "JS/Clip.js",

            
            'CSS/jquery.min.js',
            'CSS/App.js',
            'CSS/MyApp.js',
            'CSS/MathJax.js',
        );

    var $MyApp_Interface_Head_Scripts_InLine=
        array
        (
        );
    
    var $MyApp_Interface_Head_Links=
        array(
            array
            (
                "REL" => 'stylesheet',
                "HREF" => '/fontawesome-free-5.3.1-web/css/all.css',
            ),
        );
    
    var $MyApp_Interface_CSS_Path="CSS";
    
    var $MyApp_Interface_Head_CSS_OnLine=
        array
        (
            'bulma.0.7.1.css',
            "HTMLs.css",
            "Envs.css",
            "App.css",
            "Application.css",
            "Left.Menu.css",
            "Hor.Menu.css",
            "Odd.Even.css",
            "Modules.css",
            "Top.css",


            //leftovers
            "Sade.css",
            "Simon.css",
        );

    var $MyApp_Interface_Head_CSS_InLine=
        array
        (
        );

    #Array used for app modules storing data read per module/id.
    var $__Datas__=array();
    var $__Datas_Objs__=array();

    function System_Pipe($command)
    {
        if (is_array($command))
        {
            $command=join(" ",$command);
            
        }
        
        $handle = popen($command.' 2>&1', 'r');
        if (!$handle)
        {
            print "Unable to open command handle:\n".$command."\n";
        }
        
        $read = fread($handle, 2096);
        pclose($handle);

        return $read;
    }
    
    //*
    //* function MyApp_Load, Parameter list: $args=array()
    //*
    //* Load Application.
    //*

    function MyApp_Load($args)
    {
        $this->MyApp_Init($args);
    }

    //*
    //* function MyApp_Init, Parameter list: 
    //*
    //* Application initializer.
    //*

    function MyApp_Init($args)
    {
        //We are our own Application object
        $this->ApplicationObj=$this;
        $this->IsMain=TRUE;
        $this->MyLanguage_Detect();

        $this->ModuleName="App";

        $this->Hash2Object($args);

        $this->MyApp_AppSetup($args);
        $this->DB_Init();
        
        $this->MyApp_Language_Init($args);
        $this->MyApp_Messages_Init($args);

        //Detect whether we are cli and should run process
        if ($this->MakeCGI_CLI_Is())
        {
            $this->MyApp_CLI($args);
            exit();
        }
 
        $this->MyApp_Profiles_Read();
        $this->MyApp_CGIVars_Init();
        
        //Must do after MyApp_CGIVars_Ini, may change DB.
        $this->MyApp_Session_Table_Init();
        $this->MyApp_Login_Init();

        $this->MyApp_Interface_Init();
        $this->MyApp_Mail_Init();

        $this->MyActions_Init();

        $this->MyApp_SetURL();

        $this->MyApp_Logging_Init();
        $this->MyApp_SubModules_Load();
    }


    //*
    //* Runs CLI commands.
    //*

    function MyApp_CLI($args)
    {
        if (method_exists($this,"MyApp_CLI_Process"))
        {
            $this->MyApp_CLI_Process($args);
        }
    }

    
    //*
    //* function MyApp_FilterPath, Parameter list: 
    //*
    //* Filters out #System and #ModuleName from path.
    //*

    function MyApp_FilterPath($path)
    {
        return
            preg_replace
            (
               '/#System/',
               $this->SetupPath,
               preg_replace
               (
                  '/#Module(Name)?/',
                  $this->ModuleName,
                  $path
               )
            );
     }

    //*
    //* Returns message title.
    //*

    function MyApp_Name()
    {
        return $this->MyLanguage_GetMessage("Application");
    }
    
    //*
    //* Returns message title.
    //*

    function MyApp_Title()
    {
        return $this->MyLanguage_GetMessage("Application","Title");
    }
    
    //*
    //* Returns message version.
    //*

    function MyApp_Version()
    {
        return $this->HtmlSetupHash[ "ApplicationVersion" ];
    }
    
    //*
    //* Runs Application setup.
    //*

    function MyApp_AppSetup($args)
    {
        $this->MyHash_Args2Object
        (
            $this->MyApp_Defaults()
        );
        
        $this->MyHash_Args2Object($args);

        $this->MyHash_Args2Object
        (
           $this->ReadPHPArray
           (
              $this->MyApp_Setup_File(),
              $args
           )
        );

        $this->MyApp_Setup_Read();
        $this->MyApp_SubModules_Read();
    }
    
    
    //*
    //* Runs application, that is calls Handle. Load must have been done before.
    //*

    function MyApp_Run($args)
    {
        $this->MyApp_Handle($args);
    }

    //*
    //* function MyApp_Application_Name, Parameter list: 
    //*
    //* Returns key from HtmlSetupHash.
    //*

    function MyApp_Application_Name()
    {
        return $this->MyApp_Setup_Application_Get_Name();
    }

    //*
    //* function MyApp_Application_Version, Parameter list: 
    //*
    //* Returns key from HtmlSetupHash.
    //*

    function MyApp_Application_Version()
    {
        return $this->HtmlSetupHash[ "ApplicationVersion"  ];
    }

    //*
    //* function MyApp_Application_Title, Parameter list: 
    //*
    //* Returns key from HtmlSetupHash.
    //*

    function MyApp_Application_Title()
    {
        return
            $this->MyApp_Setup_Application_Get_Title().
            " ".
            $this->MyApp_Application_Version().
            "";
    }

    //*
    //* Counts number of Actions read.
    //*

    function MyApp_Actions_N()
    {
        $n=0;
        foreach (array_keys($this->LanguagesObj()->Actions_Messages) as $module)
        {
            $n+=count($this->LanguagesObj()->Actions_Messages[ $module ]);
        }

        return $n;
    }
    
    //*
    //* Counts number of ItemData'ss read.
    //*

    function MyApp_Datas_N()
    {
        $n=0;
        foreach (array_keys($this->LanguagesObj()->Datas) as $module)
        {
            $n+=count($this->LanguagesObj()->Datas[ $module ]);
        }

        return $n;
    }
    
    //*
    //* Counts number of Groups read.
    //*

    function MyApp_Groups_N()
    {
        $n=0;
        foreach (array_keys($this->LanguagesObj()->Groups) as $module)
        {
            $n+=count($this->LanguagesObj()->Groups[ $module ]);
        }

        return $n;
    }


    //*
    //* 
    //*

    function MyApp_Messages_Stats()
    {
        return
            $this->Htmls_DIV
            (
                $this->Htmls_List
                (
                    array
                    (
                        count($this->Messages)." messages",
                        $this->MyApp_Actions_N()." actions",
                        $this->MyApp_Datas_N()." datas",
                        $this->MyApp_Groups_N()." groups",
                    )
                ),
                array("ALIGN" => 'left')
            );
    }

    //*
    //* function MyApp_Run, Parameter list: $args
    //*
    //* Sets application URL.
    //*

    function MyApp_SetURL()
    {
        $this->MyApp_URL="http";
        if (isset($_SERVER[ "HTTPS" ]))
        {
            $this->MyApp_URL.="s";
        }

        $this->MyApp_URL.=
            "://".
            $this->CGI_Server_Name().
            $this->CGI_Script_Path().
            "/".
            $this->CGI_Script_Name();
        
        $this->MyApp_URL=preg_replace('/\/?index.php/',"",$this->URL);

        return $this->MyApp_URL;
    }
    
    //*
    //* function MyApp_Common_URIs, Parameter list: $args
    //*
    //* The URI's to add for all links.
    //*

    function MyApp_Common_URIs()
    {
        return array();
    }
}

?>