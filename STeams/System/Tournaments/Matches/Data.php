array
(
    "ID"           =>  array
    (
        "Sql"   => "INT NOT NULL PRIMARY KEY AUTO_INCREMENT",
        "Compulsory" => FALSE,
        "Visible" => 0,
    ),
    "Tournament" => array
    (
        "Sql" => "INT",
        "SqlClass" => "Tournaments",
        "GETSearchVarName"  => "Tournament",
        "Search" => False,
        "Add"  => TRUE,
    ),
    "Season" => array
    (
        "Sql" => "INT",
        "SqlClass" => "Tournament_Seasons",
        "GETSearchVarName"  => "Season",
        "Search" => True,
    ),
    "Tournament_Group" => array
    (
        "Sql" => "INT",
        "SqlClass" => "Tournament_Groups",
        "GETSearchVarName"  => "Group",
        "Search" => True,
        "Add"  => TRUE,
    ),
    "Tournament_Round" => array
    (
        "Sql" => "INT",
        "SqlClass" => "Tournament_Rounds",
        "GETSearchVarName"  => "Round",
        "Search" => True,
        "Add"  => TRUE,
        "EditFieldMethod" => "Tournament_Match_Round_Select",
    ),
    "Name" => array
    (
        "Sql" => "VARCHAR(256)",
        "Search" => True,
    ),
    "Date" => array
    (
        "Sql" => "INT",
        "Size" => "8",
        "Compulsory" => FALSE,
        "Search"  => FALSE,
        "IsDate"  => True,
        "Add"  => TRUE,
        //"Key" => array("utcDate"),
    ),
    "HHMM"         => array
    (
        "Sql" => "INT",
        "Size" => "4",
        "Compulsory" => FALSE,
        "Search"  => FALSE,
        "Add"  => TRUE,
    ),
    "Team1" => array
    (
        "Sql" => "INT",
        "SqlClass" => "Teams",
        "GETSearchVarName"  => "Team",
        "Search" => True,
        "Add"  => TRUE,
    ),
    "Team2" => array
    (
        "Sql" => "INT",
        "SqlClass" => "Teams",
        "GETSearchVarName"  => "Team",
        "Search" => True,
        "Add"  => TRUE,
    ),
    "Goals1"         => array
    (
        "Key" => array("score","fullTime","homeTeam"),
        "Sql" => "VARCHAR(4)",
        "Size" => "2",
        "Compulsory" => FALSE,
        "Default" => "-",
        "Search"  => FALSE,
        "OptionsMethod"  => "Tournament_Goals_Input_Options",
    ),
    "Goals2"         => array
    (
        "Key" => array("score","fullTime","awayTeam"),
        "Sql" => "VARCHAR(4)",
        "Size" => "2",
        "Compulsory" => FALSE,
        "Search"  => FALSE,
        "Default" => "-",
        "OptionsMethod"  => "Tournament_Goals_Input_Options",
    ),
    "Status"         => array
    (
        "Sql" => "ENUM",
        "Compulsory" => FALSE,
        "Search"  => True,
        "Values" => $this->MyLanguage_GetMessages("Match_Statuses"),
    ),
    "Duration"         => array
    (
        "Sql" => "ENUM",
        "Compulsory" => FALSE,
        "Search"  => True,
        "Values" => $this->MyLanguage_GetMessages("Match_Durations"),
        "Default" => 1,
    ),
    "Consolidated"         => array
    (
        "Sql" => "ENUM",
        "Compulsory" => FALSE,
        "Search"  => True,
        "Default" => 1,
        "Values" => $this->MyLanguage_GetMessages("NoYes"),
    ),
    "Points1"         => array
    (
        "Sql" => "VARCHAR(4)",
        "Size" => "2",
        "Default" => "-",
        "Compulsory" => FALSE,
        "Search"  => FALSE,
        "Default" => "-",
    ),
    "Points2"         => array
    (
        "Sql" => "VARCHAR(4)",
        "Size" => "2",
        "Default" => "-",
        "Compulsory" => FALSE,
        "Search"  => FALSE,
        "Default" => "-",
    ),

    "Stage"         => array
    (
        "Sql" => "ENUM",
        "Compulsory" => FALSE,
        "Search"  => True,
        "Default" => "1",
        "Values" => $this->MyLanguage_GetMessages("Match_Stages"),
    ),


    "LAST_M" => array
    (
        "Sql" => "INT",
    ),

    "Goals1_Half"         => array
    (
        "Key" => array("score","halfTime","homeTeam"),
        "Sql" => "VARCHAR(4)",
        "Size" => "2",
        "Compulsory" => FALSE,
        "Default" => "-",
        "Search"  => FALSE,
        "OptionsMethod"  => "Tournament_Goals_Input_Options",
    ),
    "Goals2_Half"         => array
    (
        "Key" => array("score","halfTime","awayTeam"),
        "Sql" => "VARCHAR(4)",
        "Size" => "2",
        "Compulsory" => FALSE,
        "Default" => "-",
        "Search"  => FALSE,
        "OptionsMethod"  => "Tournament_Goals_Input_Options",
    ),

    "Goals1_Extra"         => array
    (
        "Key" => array("score","extraTime","homeTeam"),
        "Sql" => "VARCHAR(4)",
        "Size" => "2",
        "Compulsory" => FALSE,
        "Default" => "-",
        "Search"  => FALSE,
        "OptionsMethod"  => "Tournament_Goals_Input_Options",
    ),
    "Goals2_Extra"         => array
    (
        "Key" => array("score","extraTime","awayTeam"),
        "Sql" => "VARCHAR(4)",
        "Size" => "2",
        "Default" => "-",
        "Compulsory" => FALSE,
        "Search"  => FALSE,
        "OptionsMethod"  => "Tournament_Goals_Input_Options",
    ),
    "Goals1_Penalties"         => array
    (
        "Key" => array("score","penalties","homeTeam"),
        "Sql" => "VARCHAR(4)",
        "Size" => "2",
        "Default" => "-",
        "Compulsory" => FALSE,
        "Search"  => FALSE,
        "OptionsMethod"  => "Tournament_Goals_Input_Options",
    ),
    "Goals2_Penalties"         => array
    (
        "Key" => array("score","penalties","awayTeam"),
        "Sql" => "VARCHAR(4)",
        "Size" => "2",
        "Default" => "-",
        "Compulsory" => FALSE,
        "Search"  => FALSE,
        "OptionsMethod"  => "Tournament_Goals_Input_Options",
    ),

    
    "API_ID" => array
    (
        "Key" => "id",
        "Sql" => "INT",
        "Search" => True,
    ),
    "API_Digest" => array
    (
        //"Key" => "id",
        "Sql" => "INT",
        "Search" => True,
    ),
    "API_Last" => array
    (
        //"Key" => "id",
        "Sql" => "INT",
        "TimeType"=> 1,
        "Search" => True,
    ),
 
    "API_Result" => array
    (
        "Sql" => "TEXT",
    ),
 
    "API_Update" => array
    (
        "Sql" => "ENUM",
        "Compulsory" => FALSE,
        "Search"  => FALSE,
        "Default"  => 1,
        "Values" => $this->MyLanguage_GetMessages("YesNo"),
    ),
 
);
