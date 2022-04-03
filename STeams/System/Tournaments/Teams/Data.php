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
    ),
    "Season" => array
    (
        "Sql" => "INT",
        "SqlClass" => "Tournament_Seasons",
        "GETSearchVarName"  => "Season",
        "Search" => True,
    ),
    "Team" => array
    (
        "Sql" => "INT",
        "SqlClass" => "Teams",
        "GETSearchVarName"  => "Team",
        "SqlDerivedData" => array("Name_".$this->MyLanguage_Get()),
        "SqlFilter" => "#Name_".$this->MyLanguage_Get(),
        "SqlTitleFilter" => "Name_".$this->MyLanguage_Get()." (ID #ID)",
        "Search" => True,
    ),
    "Name" => array
    (
        "Sql" => "VARCHAR(256)",
    ),
    "Tournament_Group" => array
    (
        "Sql" => "INT",
        "SqlClass" => "Tournament_Groups",
        "GETSearchVarName"  => "Group",
        "Search" => True,
    ),
    
    "Points_Home" => array
    (
        "Sql" => "INT",
        "Search" => False,
        "Format" => "%02d",
    ),
    "Points_Away" => array
    (
        "Sql" => "INT",
        "Search" => False,
        "Format" => "%02d",
    ),
    "Points_Total" => array
    (
        "Sql" => "INT",
        "Search" => False,
        "Format" => "%02d",
    ),
    "Matches_Home" => array
    (
        "Sql" => "INT",
        "Search" => False,
        "Format" => "%02d",
    ),
    "Matches_Away" => array
    (
        "Sql" => "INT",
        "Search" => False,
        "Format" => "%02d",
    ),
    "Matches_Total" => array
    (
        "Sql" => "INT",
        "Search" => False,
        "Format" => "%02d",
    ),
    "Goals_Favor" => array
    (
        "Sql" => "INT",
        "Search" => False,
        "Format" => "%02d",
    ),
    "Goals_Against" => array
    (
        "Sql" => "INT",
        "Search" => False,
        "Format" => "%02d",
    ),
    "Goals_Total" => array
    (
        "Sql" => "INT",
        "Search" => False,
        "Format" => "%02d",
    ),
    "Matches_Home" => array
    (
        "Sql" => "INT",
        "Search" => False,
        "Format" => "%02d",
    ),
    "Matches_Victory" => array
    (
        "Sql" => "INT",
        "Search" => False,
        "Format" => "%02d",
    ),
    "Matches_Draw" => array
    (
        "Sql" => "INT",
        "Search" => False,
        "Format" => "%02d",
    ),
    "Matches_Defeat" => array
    (
        "Sql" => "INT",
        "Search" => False,
        "Format" => "%02d",
    ),
);
