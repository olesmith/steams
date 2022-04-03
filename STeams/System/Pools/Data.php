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
        "Add"  => TRUE,
    ),
    "Season" => array
    (
        "Sql" => "INT",
        "SqlClass" => "Tournament_Seasons",
        "GETSearchVarName"  => "Season",
        "Search" => True,
        "Add"  => TRUE,
        "SqlWhere_Method" => "Tournament_Season_Sql_Where",
    ),
    "Name" => array
    (
        "Sql" => "VARCHAR(256)",
        "Search" => True,
        "Add"  => TRUE,
    ),
    "Friend" => array
    (
        "Sql" => "INT",
        "SqlClass" => "Friends",
        "GETSearchVarName"  => "Owner",
        "Search" => True,
        "Add"  => TRUE,
    ),

    "Price" => array
    (
        "Sql" => "INT",
        "Search" => False,
        "Default"  => 200,
        "Size"  => 3,
    ),
    "Premium_1" => array
    (
        "Sql" => "INT",
        "Search" => False,
        "Default"  => 2000,
        "Size"  => 3,
    ),
    "Premium_2" => array
    (
        "Sql" => "INT",
        "Search" => False,
        "Default"  => 1000,
        "Size"  => 3,
    ),
    "Premium_3" => array
    (
        "Sql" => "INT",
        "Search" => False,
        "Default"  => 500,
        "Size"  => 3,
    ),
    "Premium_Round" => array
    (
        "Sql" => "INT",
        "Search" => False,
        "Default"  => 25,
        "Size"  => 1,
    ),
    "Show_Others_Minutes" => array
    (
        "Sql" => "INT",
        "Search" => False,
        "Default"  => 30,
        "Size"  => 1,
    ),
    
    "Weight_Result" => array
    (
        "Sql" => "INT",
        "Search" => False,
        "Default"  => 5,
        "Size"  => 1,
    ),
    "Weight_Goals" => array
    (
        "Sql" => "INT",
        "Search" => False,
        "Default"  => 10,
        "Size"  => 1,
    ),
    "Weight_Goal" => array
    (
        "Sql" => "INT",
        "Search" => False,
        "Default"  => 2,
        "Size"  => 1,
    ),
);
