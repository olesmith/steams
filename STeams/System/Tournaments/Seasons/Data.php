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
    "Year" => array
    (
        "Sql" => "VARCHAR(256)",
        "Search" => True,
    ),
    "Name" => array
    (
        "Sql" => "VARCHAR(256)",
        "Search" => True,
    ),
    "Title" => array
    (
        "Sql" => "VARCHAR(256)",
        "Search" => True,
    ),
    "Logo"         => array
    (
        "Sql" => "FILE",
        "Compulsory" => FALSE,
        "Extensions" => array("jpg","png","svg"),
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
    "Winner"         => array
    (
        "Sql" => "INT",
        "SqlClass" => "Teams",
        "Compulsory" => FALSE,
        "Search"  => True,
        "Add"  => TRUE,
    ),
    "URL"         => array
    (
        "Sql" => "VARCHAR(256)",
        "Compulsory" => FALSE,
        "Search"  => True,
    ),    
    
    "API_ID" => array
    (
        "Sql" => "INT",
        "Search" => True,
    ),
    "API_Result" => array
    (
        "Sql" => "TEXT",
        "Search" => True,
    ),
);
