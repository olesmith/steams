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
    "Number" => array
    (
        "Sql" => "VARCHAR(256)",
        "Search" => True,
        "Default" => 1,
    ),
    "Name" => array
    (
        "Sql" => "VARCHAR(256)",
        "Search" => True,
    ),
    "Status"         => array
    (
        "Sql" => "ENUM",
        "Compulsory" => FALSE,
        "Search"  => True,
        "Values" => $this->MyLanguage_GetMessages("Match_Statuses"),
    ),
);
