array
(
    "ID"           =>  array
    (
        "Sql"   => "INT NOT NULL PRIMARY KEY AUTO_INCREMENT",
        "Compulsory" => FALSE,
        "Visible" => 0,
    ),
    "Name_UK"         => array
    (
        "Sql" => "VARCHAR(256)",
        "Size" => "35",
        "Compulsory" => False,
        "Search"  => True,
    ),
    "Title_UK"         => array
    (
        "Sql" => "VARCHAR(256)",
        "Size" => "35",
        "Compulsory" => FALSE,
        "Search"  => True,
    ),
    "Name_ES"         => array
    (
        "Sql" => "VARCHAR(256)",
        "Size" => "35",
        "Compulsory" => False,
        "Search"  => False,
    ),
    "Title_ES"         => array
    (
        "Sql" => "VARCHAR(256)",
        "Size" => "35",
        "Compulsory" => FALSE,
        "Search"  => FALSE,
    ),
    "Name_PT"         => array
    (
        "Sql" => "VARCHAR(256)",
        "Size" => "35",
        "Compulsory" => False,
        "Search"  => False,
    ),
    "Title_PT"         => array
    (
        "Sql" => "VARCHAR(256)",
        "Size" => "35",
        "Compulsory" => FALSE,
        "Search"  => False,
    ),

   
    "Initials"         => array
    (
        "Sql" => "VARCHAR(4)",
        "Size" => "3",
        "Compulsory" => FALSE,
        "Search"  => FALSE,
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
    "Flag"         => array
    (
        "Size" => "8",
        "Sql" => "FILE",
        "Compulsory" => FALSE,
        "Search" => FALSE,
        "Extensions" => array("jpg","png","svg","gif","bmp"),
        "NoAdd" => TRUE,
    ),
    "Capital"         => array
    (
        "Sql" => "VARCHAR(256)",
        "Size" => "35",
        "Compulsory" => False,
        "Search"  => TRUE,
        "Add"  => TRUE,
    ),
    "Population"         => array
    (
        "Sql" => "BIGINT",
        "Size" => "35",
        "Compulsory" => False,
        "Search"  => False,
    ),
    "Area"         => array
    (
        "Sql" => "BIGINT",
        "Size" => "35",
        "Compulsory" => False,
        "Search"  => False,
    ),
    "Region"         => array
    (
        "Sql" => "VARCHAR(256)",
        "Size" => "35",
        "Compulsory" => False,
        "Search"  => False,
    ),
    "SubRegion"         => array
    (
        "Sql" => "VARCHAR(256)",
        "Size" => "35",
        "Compulsory" => False,
        "Search"  => False,
    ),
    "Code2"         => array
    (
        "Sql" => "VARCHAR(4)",
        "Size" => "3",
        "Compulsory" => FALSE,
        "Search"  => FALSE,
    ),
    "GINI"         => array
    (
        "Sql" => "VARCHAR(4)",
        "Size" => "3",
        "Compulsory" => FALSE,
        "Search"  => FALSE,
    ),
    "CallCode"         => array
    (
        "Sql" => "VARCHAR(4)",
        "Size" => "3",
        "Compulsory" => FALSE,
        "Search"  => FALSE,
    ),
    "TimeZones"         => array
    (
        "Sql" => "VARCHAR(256)",
        "Size" => "3",
        "Compulsory" => FALSE,
        "Search"  => FALSE,
    ),
);
