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
        "Compulsory" => FALSE,
        "Search"  => True,
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
    "Pool_Friend"         => array
    (
        "Sql" => "INT",
        "SqlClass" => "Friends",
        "Compulsory" => FALSE,
        "Search"  => True,
        "Add"  => TRUE,
    ),
    "Tournament_Round"         => array
    (
        "Sql" => "INT",
        "SqlClass" => "Tournament_Rounds",
        "Compulsory" => FALSE,
        "Search"  => True,
        "Add"  => TRUE,
        "Default" => " 0",
    ),
    "Month"         => array
    (
        "Sql" => "INT",
        "Compulsory" => FALSE,
        "Search"  => True,
        "Add"  => TRUE,
        "Default" => " 0",
    ),
    "Ranking" => array
    (
        "Sql" => "INT",
        "Search" => True,
        "Default"  => " 0",
        "SumVar" => True,
        "Size"  => 1,
        "ForceZero"  => TRUE,
    ),
    "Points" => array
    (
        "Sql" => "INT",
        "Search" => False,
        "Default"  => " 0",
        "SumVar" => True,
        "Size"  => 1,
        "ForceZero"  => TRUE,
    ),
    "Scores" => array
    (
        "Sql" => "INT",
        "Search" => False,
        "Default"  => " 0",
        "SumVar" => True,
        "Size"  => 1,
        "ForceZero"  => TRUE,
    ),
);
