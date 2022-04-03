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
    ),
    "Tournament_Match"         => array
    (
        "Sql" => "INT",
        "SqlClass" => "Tournament_Matches",
        "Compulsory" => FALSE,
        "Search"  => True,
        "Add"  => TRUE,
    ),
    "Goals1"         => array
    (
        "Sql" => "VARCHAR(4)",
        "Size" => "1",
        "Compulsory" => FALSE,
        "Search"  => True,
        "Add"  => TRUE,
        "Default"  => "-",
        "OptionsMethod"  => "Pool_Bet_Input_Options",
        "ForceZero"  => TRUE,
    ),
    "Goals2"         => array
    (
        "Sql" => "VARCHAR(4)",
        "Size" => "1",
        "Compulsory" => FALSE,
        "Search"  => True,
        "Add"  => TRUE,
        "Default"  => "-",

        "OptionsMethod"  => "Pool_Bet_Input_Options",
        "ForceZero"  => TRUE,
    ),
    "Updated"         => array
    (
        "Sql" => "ENUM",
        "Size" => "1",
        "Compulsory" => FALSE,
        "Search"  => True,
        "Default"  => 1,
        "Values"  => $this->MyLanguage_GetMessages("NoYes"),
    ),
    
    "Result" => array
    (
        "Sql" => "ENUM",
        "Size" => "1",
        "Compulsory" => FALSE,
        "Search"  => True,
        "Default"  => 1,
        "Values"  => $this->MyLanguage_GetMessages("NoYes"),
    ),
    "Result_Goals" => array
    (
        "Sql" => "ENUM",
        "Size" => "1",
        "Compulsory" => FALSE,
        "Search"  => True,
        "Default"  => 1,
        "Values"  => $this->MyLanguage_GetMessages("NoYes"),
    ),
    "Result_Goal" => array
    (
        "Sql" => "ENUM",
        "Size" => "1",
        "Compulsory" => FALSE,
        "Search"  => True,
        "Default"  => 1,
        "Values"  => $this->MyLanguage_GetMessages("NoYes"),
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
    "LastCalc" => array
    (
        "NoAdd" => TRUE,
        "Sql"      => "INT",
        "TimeType" => 1,

        "Public"   => 0,
        "Person"   => 0,
        "Admin"   => 1,
    ),
);
