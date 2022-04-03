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
        "Search" => True,
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
    ),
    "Number" => array
    (
        "Sql" => "VARCHAR(256)",
        "Search" => True,
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
    ),
    "HHMM"         => array
    (
        "Sql" => "INT",
        "Size" => "4",
        "Compulsory" => FALSE,
        "Search"  => FALSE,
        "Add"  => TRUE,
        "IsTime"  => True,
    ),
    "StartDate" => array
    (
        "Sql" => "INT",
        "Size" => "8",
        "Compulsory" => FALSE,
        "Search"  => FALSE,
        "IsDate"  => True,
        "Add"  => TRUE,
    ),
    "EndDate" => array
    (
        "Sql" => "INT",
        "Size" => "8",
        "Compulsory" => FALSE,
        "Search"  => FALSE,
        "IsDate"  => True,
        "Add"  => TRUE,
    ),
    "Status"         => array
    (
        "Sql" => "ENUM",
        "Compulsory" => FALSE,
        "Search"  => True,
        "Values" => $this->MyLanguage_GetMessages("Match_Statuses"),
    ),
    "Stage"         => array
    (
        "Sql" => "ENUM",
        "Compulsory" => FALSE,
        "Search"  => True,
        "Default" => "1",
        "Values" => $this->MyLanguage_GetMessages("Match_Stages"),
    ),
);
