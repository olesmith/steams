array
(
    "Logo"         => array
    (
        "Sql" => "FILE",
        "Compulsory" => FALSE,
        "Extensions" => array("jpg","png","svg"),
    ),
    
    "Logo_URL"         => array
    (
        "Sql" => "VARCHAR(512)",
        "Compulsory" => FALSE,
    ),
    
    "NTeams"         => array
    (
        "Sql" => "INT",
        "Size" => "2",
        "Compulsory" => FALSE,
        "Search"  => FALSE,
        "Add"  => TRUE,
    ),
    "StartDate"         => array
    (
        "Sql" => "INT",
        "Size" => "8",
        "Compulsory" => FALSE,
        "Search"  => FALSE,
        "IsDate"  => True,
        "Add"  => TRUE,
    ),
    "EndDate"         => array
    (
        "Sql" => "INT",
        "Size" => "8",
        "Compulsory" => FALSE,
        "Search"  => FALSE,
        "IsDate"  => True,
        "Add"  => TRUE,
    ),
    "HHMM"         => array
    (
        "Sql" => "INT",
        "Size" => "4",
        "Compulsory" => FALSE,
        "Search"  => FALSE,
        "Add"  => TRUE,
        "Default"  => "1800",
    ),
    "NGroups"         => array
    (
        "Sql" => "INT",
        "Size" => "2",
        "Compulsory" => FALSE,
        "Search"  => FALSE,
        "Default"  => 1,
    ),
    "HomeAndAway"         => array
    (
        "Sql" => "ENUM",
        "Size" => "2",
        "Compulsory" => FALSE,
        "Search"  => FALSE,
        "Add"  => TRUE,
        "Default"  => 1,
        "Values" => $this->MyLanguage_GetMessages("YesNo"),
    ),
    "Cup"         => array
    (
        "Sql" => "ENUM",
        "Size" => "2",
        "Compulsory" => FALSE,
        "Search"  => FALSE,
        "Add"  => TRUE,
        "Default"  => 1,
        "Values" => $this->MyLanguage_GetMessages("Cup_Types"),
    ),
    "Type"         => array
    (
        "Sql" => "ENUM",
        "Size" => "2",
        "Compulsory" => FALSE,
        "Search"  => FALSE,
        "Add"  => TRUE,
        "Default"  => 1,
        "Values" => $this->MyLanguage_GetMessages("Team_Types"),
    ),
    "Country"         => array
    (
        "Sql" => "INT",
        "SqlClass" => "Countries",
        "Compulsory" => FALSE,
        "Search"  => True,
        "Add"  => TRUE,
    ),
    "Continent"         => array
    (
        "Sql" => "ENUM",
        "Compulsory" => FALSE,
        "Search"  => True,
        "Add"  => TRUE,
        "Values" => $this->MyLanguage_GetMessages("Continents"),
    ),
    
    "Points_Win"         => array
    (
        "Sql" => "INT",
        "Compulsory" => FALSE,
        "Default"  => 3,
    ),
    "Points_Draw"         => array
    (
        "Sql" => "INT",
        "Compulsory" => FALSE,
        "Default"  => 1,
    ),
    "UTC"         => array
    (
        "Sql" => "INT",
        "Compulsory" => FALSE,
        "Default"  => -3,
    ),
);
