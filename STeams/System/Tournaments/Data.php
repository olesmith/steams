array
(
    "ID"           =>  array
    (
        "Sql"   => "INT NOT NULL PRIMARY KEY AUTO_INCREMENT",
        "Compulsory" => FALSE,
        "Visible" => 0,
    ),
    "Season"         => array
    (
        "Sql" => "INT",
        "SqlClass" => "Tournament_Seasons",
        "Compulsory" => FALSE,
        "Search"  => True,
        "Add"  => TRUE,
    ),
    
    "Name"         => array
    (
        "Sql" => "VARCHAR(256)",
        "Size" => "35",
        "Compulsory" => 1,
        "Search"  => TRUE,
        "Add"  => TRUE,
    ),
    "Title"         => array
    (
        "Sql" => "VARCHAR(256)",
        "Size" => "35",
        "Compulsory" => FALSE,
        "Search"  => FALSE,
        "Add"  => TRUE,
    ),
);
