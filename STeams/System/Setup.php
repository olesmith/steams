array
(
    "DefaultAction" => "Start",
    "CSSFile"       => "STeams.css",
    "DefaultProfile" => 2,
    "LoginPermissionVars" => array(),
    "SqlTableVars" => array("SqlVars"),
    "CommonData" => array
    (
        "Hashes" => array
        (
            "Login" => "Auth.Data.php",
            "MySql" => "DB.php",
            "Mail" => "Mail.php",
        ),
    ),
    "AllowedModules" => array
    (
        "Countries",
        "Languages",
        "User_States",
        "Logs",
        "Friends",                    
        "Permissions",
        "APIs",
        "Tournaments",
        "Teams",
        "Tournament_Seasons",
        "Tournament_Teams",
        "Tournament_Groups",
        "Tournament_Rounds",
        "Tournament_Matches",
        "Pools",
        "Pool_Friends",
        "Pool_Bets",
        "Pool_Rankings",
    ),

    "SubModulesVars" => array
    (
        "include_file" => "System/Modules.php",
    ),
    "Module2Groups" => array
    (
    ),
    "ModuleGroups2Actions" => array
    (
        //Actions should be defined in System/Actions.php (or elsewhere)
        "Configuration" => array
        (
            "Name" => "Configuração",
            "Title" => "Configuração",
            "Name_UK" => "Configuration",
            "Title_UK" => "Configuration",
            "Actions" => array
            (
            ),
        ),
    ),
);