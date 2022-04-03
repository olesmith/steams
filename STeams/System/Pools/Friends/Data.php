array
(
    "ID"           =>  array
    (
        "Sql"   => "INT NOT NULL PRIMARY KEY AUTO_INCREMENT",
        "Compulsory" => FALSE,
        "Visible" => 0,
    ),
    "Name"         => array
    (
        "Sql" => "VARCHAR(256)",
        "Size" => "50",
        "Compulsory" => FALSE,
        "Search"  => FALSE,
        "Add"  => False,
    ),
    "Tournament"         => array
    (
        "Sql" => "INT",
        "SqlClass" => "Tournaments",
        "Compulsory" => FALSE,
        "Search"  => True,
        "Add"  => TRUE,
    ),
    "Season" => array
    (
        "Sql" => "INT",
        "SqlClass" => "Tournament_Seasons",
        "GETSearchVarName"  => "Season",
        "Search" => True,
    ),
    "Pool"         => array
    (
        "Sql" => "INT",
        "SqlClass" => "Pools",
        "Compulsory" => FALSE,
        "Search"  => True,
        "Add"  => TRUE,
    ),
    "Friend"         => array
    (
        "Sql" => "INT",
        "SqlClass" => "Friends",
        "Compulsory" => FALSE,
        "Search"  => True,
        "Add"  => TRUE,
    ),
    "Result" => array
    (
        "Sql" => "INT",
        "Size" => "1",
        "Compulsory" => FALSE,
    ),
    "Result_Goals" => array
    (
        "Sql" => "INT",
        "Size" => "1",
        "Compulsory" => FALSE,
    ),
    "Result_Goal" => array
    (
        "Sql" => "INT",
        "Size" => "1",
        "Compulsory" => FALSE,
    ),
    "Points" => array
    (
        "Sql" => "INT",
        "Search" => False,
        "Default"  => " 0",
        "Size"  => 1,
    ),
    "Ranking" => array
    (
        "Sql" => "INT",
        "Search" => False,
        "Default"  => " 0",
        "Size"  => 1,
    ),
);
