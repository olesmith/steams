<?php


global $Setup_Path;

include_once("Accessor.php");
Accessor_Create
(
   array
   (
      "Unit" => array
      (
         "Type" => "Hash",
      ),
   ),
   $Setup_Path
);

include_once("Application/Application.php");
include_once("Modules/Common.php");

//traits
include_once("App/LeftMenu.php");
include_once("App/Start.php");
include_once("App/Top.php");
include_once("App/CLI.php");
include_once("App/CGI.php");

class STeams extends Application
{
    use
        STeams_LeftMenu,
        STeams_Start,
        STeams_Top,
        App_CLI,
        App_CGI;
    
    var $DB=True;
    
    var $Sigma="&Sigma;";
    var $Mu="&mu;";
    var $Pi="&pi;";
    
    var $UserProfiles=array
    (
       "Student",
       "Teacher",
       "Technical",
    );
    var $Unit=False;
    
    var $LanguageKeys=array
    (
       "",
    );
    var $Start_Icon='far fa-hand-point-right';
    
    var $History_Icon="fas fa-history";
    var $Tournaments_Icon="fas fa-chalkboard";
    var $Seasons_Icon="far fa-calendar-plus";
    var $Season_Icon="far fa-calendar";
    var $Groups_Icon="fas fa-object-ungroup";
    var $Teams_Icon="fas fa-tshirt";
    var $Rounds_Icon="fas fa-circle-notch";
    var $Matches_Icon="fas fa-futbol";
    var $Table_Icon="fas fa-table";//vs none
    var $Dates_Icon="fas fa-hourglass-half";
    var $Results_Icon="fas fa-balance-scale";
    var $Goals_Icon="fas fa-balance-scale";
    var $Pools_Icon="fas fa-comment-dollar";
    var $Friends_Icon="fas fa-users";
    var $Friend_Icon="fas fa-user";
    var $Bet_Icon="fas fa-save";
    var $Bets_Icon="fas fa-coins";
    var $API_Icon="fas fa-download";

    var $__CGI_State__=array();
    
    function CGI_Reset_Cwd()
    {
        #chdir(dirname($_SERVER[ "SCRIPT_FILENAME" ]));
    }
    
    //*
    //* function SigaB, Parameter list: $args=array()
    //*
    //* SigaB constructor, main object.
    //*

    function STeams($args=array())
    {
        $this->ApplicationObj=$this;
        $this->MyLanguage_Detect();
        $unit=$this->GetGETint("Unit");

        $args[ "SavePath" ]="?Action=Start";
                
        parent::Application($args);

        $this->App_CSS_Add();
        
        $this->FriendsObj()->Sql_Table_Structure_Update_Force=True;
        $this->FriendsObj()->Sql_Table_Structure_Update();

        $this->URL_CommonArgs=
            array
            (
                "Tournament"     => $this->Tournament("ID"),
                "Season"     => $this->Season("ID"),
                "Pool" => $this->Pool("ID"),
            );


        array_push
        (
            $this->MyApp_Interface_Head_Scripts_OnLine,
            "JS/STeams.js"
        );
    }
    
    //*
    //* function App_CSS_Add, Parameter list: 
    //*
    //* Adds app specific css to $this->MyApp_Interface_Head_CSS_OnLine.
    //*

    function App_CSS_Add()
    {
        array_push
        (
            $this->MyApp_Interface_Head_CSS_OnLine,
            "STeams.css"
        );
    }

    //*
    //* function MyApp_Setup_LeftMenu_DataFiles, Parameter list:
    //*
    //* Returns name of file with Left Menu. 
    //*

    function MyApp_Setup_SubMenu_DataFiles()
    {
        $files=
            $this->Dir_Files
            (
                $this->MyApp_Setup_Path().
                "/LeftMenu",
                '^[A-Za-z]+\.php$'
            );

        return $files;
    }
    
    //*
    //* Checks whether we have access to messages.
    //*

    function MyApp_Messages_Access_Has()
    {
        return $this->LanguagesObj()->MyMod_Messages_Access_Has();
    }
    
    //*
    //* Checks whether we have access to messages.
    //*

    function UsersObj()
    {
        return $this->FriendsObj();
    }
    
    //*
    //* function MyMod_Mail_Type_Get, Parameter list: $type,$user
    //*
    //* Returns mail subject and body.
    //*

    function MyMod_Mail_Type_Get($type,$language)
    {
        $where=
            array
            (
                "Message_Type" => $this->LanguagesObj()->Language_Mail_Type,
                "Message_Key" => $type,
            );

        $language=$this->Language();
        $message=
            $this->LanguagesObj()->Sql_Select_Hash
            (
                array
                (
                    "Message_Type" => $this->LanguagesObj()->Language_Mail_Type,
                    "Message_Key" => $type,
                ),
                array("Name_".$language,"Title_".$language)
            );

        return
            array
            (
                "Subject" => $message[ "Name_".$language ],
                "Body"    => $message[ "Title_".$language ],
            );
    }

    //*
    //* Printer banner for Tournament, Season - and Pool.
    //*

    function MyApp_Interface_Top()
    {
        return
            array
            (
                //$this->STeams_Interface_Banner_Tournament(),
                //$this->STeams_Interface_Banner_Season(),
            );
    }
    
    //*
    //* Printer banner for Tournament, Season - and Pool.
    //*

    function STeams_Interface_Banner_Tournament()
    {
        return
            $this->Htmls_H
            (
                1,
                $this->Tournament("Name")
            );
    }
    
    //*
    //* Printer banner for Tournament, Season - and Pool.
    //*

    function STeams_Interface_Banner_Season()
    {
        return
            $this->Htmls_H
            (
                2,
                array
                (
                    $this->Tournament_SeasonsObj()->MyMod_ItemName().":",
                    $this->Season("Year"),
                )
            );
    }
    //*
    //* 
    //*

    function STeams_Tournament_Set($tournament_id)
    {
         $this->TournamentsObj()->__Tournament__=
            $this->TournamentsObj()->Sql_Select_Hash
            (
                array("ID" => $tournament_id)
            );
    }
    
    //*
    //* 
    //*

    function STeams_Season_Set($season_id)
    {
         $this->Tournament_SeasonsObj()->__Season__=
            $this->Tournament_SeasonsObj()->Sql_Select_Hash
            (
                array("ID" => $season_id)
            );
    }
    
    //*
    //* 
    //*

    function STeams_Pool_Set($pool_id)
    {
         $this->PoolsObj()->__Pool__=
            $this->PoolsObj()->Sql_Select_Hash
            (
                array("ID" => $pool_id)
            );
    }
    
    //*
    //* 
    //*

    function Pre_Handle()
    {
        $this->__CGI_State__=
            $this->User_StatesObj()->User_State_Store();
    }
    
    //*
    //*  
    //*

    function CGI_State($key="")
    {
        if
            (
                !$this->Profile_Public_Is()
                &&
                !empty($this->__CGI_State__)
            )
        {
            if (!empty($key))
            {
                if (!empty($this->__CGI_State__[ $key ]))
                {
                    return $this->__CGI_State__[ $key ];
                }
            }
            else
            {
                return $this->__CGI_State__;
            }
        }

        return False;
    }
    
    //*
    //* Overrides.
    //*

    function CGI_GET($key)
    {
        $value=parent::CGI_GET($key);
        if (empty($value))
        {
            $value=$this->CGI_State($key);
        }

        return $value;
    }


}


function STeams_Load()
{
    return
        new STeams
        (
            array
            (
                "AppName" => "STeams",
                "PublicAllow" => TRUE,
                "SessionsTable" => "Sessions",
                "MayCreateSessionTable" => TRUE,

                "Mail" => TRUE,
                "Logging" => TRUE,
                "Authentication" => TRUE,
                "DB" => TRUE,

                "ActionPaths" => array("System"),
                "ActionFiles" => array("Actions.php"),
      
                "Temp_Path" => "tmp",
                "SetupPath" => $Setup_Path,

                "MessageDirs" => array
                (
                    /* "../Common", */
                    /* "../MySql2", */
                    /* "../Application", */
                    /* "../EventApp/System", */
                    /* "System", */
                ),
                "MessageFiles" => array
                (
                    /* "../Common/Messages/MyTime.php", */
                ),

                "AppLoadModules" => array
                (
                    #"Units",
                ),

                "LogGETVars" => array
                (
                    #"Unit"
                ),

                "LogPOSTVars" => array
                (
                    "Edit","EditList","Save","Update","Generate","Transfer",
                ),

                "ValidProfiles" => array
                (
                    "Public",
                    "Technical",
                    "Teacher",
                    "Student",
                    "Distributor",
                    "Coordinator",
                    "Admin",
                ),
                "CGIVars" => "STeams_CGIVars_Get",

            )
        );
}

function STeams_Args()
{
    global $Setup_Path,$Upload_Path;

    return
        array
        (
            "AppName" => "STeams",
            "__MyApp_Interface_Mobile__" => True,
            "PublicAllow" => TRUE,
            "SessionsTable" => "Sessions",
            "MayCreateSessionTable" => TRUE,

            "Mail" => TRUE,
            "Logging" => TRUE,
            "Authentication" => TRUE,
            "DB" => TRUE,

            "Log_Path" => "/usr/local/STeams/Logs",
            "ItemData" => array(),
            "ActionPaths" => array
            (
                $Setup_Path
            ),
            "ActionFiles" => array("Actions.php"),
      
            "Upload_Path" => $Upload_Path,
            "Temp_Path" => "tmp",
            "SetupPath" => $Setup_Path,

            "AppLoadModules" => array
            (
            ),

            "LogGETVars" => array
            (
            ),

            "LogPOSTVars" => array
            (
                "Edit","EditList","Save","Update","Generate","Transfer",
            ),

            "ValidProfiles" => array
            (
                "Public",
                "Friend",
                "Coordinator",
                "Admin",
            ),
            "CGIVars" => "STeams_CGIVars_Get",
        );

    
}

$application=
    new STeams
    (
        STeams_Args()
    );
$application->MyApp_Run(array());
?>