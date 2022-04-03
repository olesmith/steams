array
(
    "ID"           =>  array
    (
        "Sql"   => "INT NOT NULL PRIMARY KEY AUTO_INCREMENT",
        "Compulsory" => FALSE,
        "Visible" => 0,
    ),
    "Name_PT"         => array
    (
        "Sql" => "VARCHAR(256)",
        "Size" => "35",
        "Compulsory" => 1,
        "Search"  => False,
        "Add"  => TRUE,
    ),
    "Title_PT"         => array
    (
        "Sql" => "VARCHAR(256)",
        "Size" => "35",
        "Compulsory" => FALSE,
        "Search"  => FALSE,
        "Add"  => TRUE,
    ),
    "Name_UK"         => array
    (
        "Sql" => "VARCHAR(256)",
        "Size" => "35",
        "Compulsory" => 1,
        "Search"  => False,
        "Add"  => TRUE,
    ),
    "Title_UK"         => array
    (
        "Sql" => "VARCHAR(256)",
        "Size" => "35",
        "Compulsory" => FALSE,
        "Search"  => FALSE,
        "Add"  => TRUE,
    ),
    "Name_ES"         => array
    (
        "Sql" => "VARCHAR(256)",
        "Size" => "35",
        "Compulsory" => 1,
        "Search"  => False,
        "Add"  => TRUE,
    ),
    "Title_ES"         => array
    (
        "Sql" => "VARCHAR(256)",
        "Size" => "35",
        "Compulsory" => FALSE,
        "Search"  => FALSE,
        "Add"  => TRUE,
    ),
    "Initials_PT"         => array
    (
        "Sql" => "VARCHAR(4)",
        "Size" => "3",
        "Compulsory" => FALSE,
        "Search"  => FALSE,
        "Add"  => TRUE,
    ),
    "Initials_UK"         => array
    (
        "Sql" => "VARCHAR(4)",
        "Size" => "3",
        "Compulsory" => FALSE,
        "Search"  => True,
        "Add"  => TRUE,
    ),
    "Initials_ES"         => array
    (
        "Sql" => "VARCHAR(4)",
        "Size" => "3",
        "Compulsory" => FALSE,
        "Search"  => FALSE,
        "Add"  => TRUE,
    ),
    "Type"         => array
    (
        "Sql" => "ENUM",
        "Values" => $this->MyLanguage_GetMessages("Team_Types"),
        "Compulsory" => FALSE,
        "Default"  => 1,
        "Search"  => True,
        "Add"  => TRUE,
    ),
    "Icon"         => array
    (
        "Size" => "8",
        "Sql" => "FILE",
        "Compulsory" => FALSE,
        "Search" => FALSE,
        "Extensions" => array("jpg","png","svg","gif","bmp"),
        "NoAdd" => TRUE,
        "Height" => '30',//px
        "Width" => '30',//px
    ),
    "Icon_URL"         => array
    (
        "Sql" => "VARCHAR(256)",
        "NoAdd" => TRUE,
        "Key" => "crestUrl",
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
    "Name" => array
    (
        "Key" => "shortName",
        "Sql" => "VARCHAR(256)",
        "Search" => True,
    ),
    "Initials" => array
    (
        "Key" => "tla",
        "Sql" => "VARCHAR(256)",
        "Search" => True,
    ),
    "Title" => array
    (
        "Key" => "name",
        "Sql" => "VARCHAR(256)",
        "Search" => True,
    ),
    /* "SVG" => array */
    /* ( */
    /*     "Size" => "8", */
    /*     "Sql" => "FILE", */
    /*     "Compulsory" => FALSE, */
    /*     "Search" => FALSE, */
    /*     "NoAdd" => TRUE, */
    /*     "Extensions" => array("svg"), */
    /*     //"Key" => "crestUrl", */
    /* ), */
    "Address" => array
    (
        "Key" => "address",
        "Sql" => "VARCHAR(256)",
    ),
    "Phone" => array
    (
        "Key" => "phone",
        "Sql" => "VARCHAR(256)",
    ),
    "URL" => array
    (
        "Key" => "website",
        "Sql" => "VARCHAR(256)",
    ),
    "Email" => array
    (
        "Key" => "email",
        "Sql" => "VARCHAR(256)",
    ),
    "Founded" => array
    (
        "Key" => "founded",
        "Sql" => "VARCHAR(256)",
    ),
    "Colors" => array
    (
        "Key" => "clubColors",
        "Sql" => "VARCHAR(256)",
    ),
    "Venue" => array
    (
        "Key" => "venue",
        "Sql" => "VARCHAR(256)",
    ),
    "LastUpdated" => array
    (
        "Key" => "lastUpdated",
        "Sql" => "VARCHAR(256)",
    ),
    "LAST_M" => array
    (
        "Sql" => "INT",
    ),

    


    
    "API_ID" => array
    (
        "Key" => "id",
        "Sql" => "INT",
        "Search" => True,
    ),
    "API_Digest" => array
    (
        "Sql" => "INT",
        "Search" => True,
    ),
    "API_Last" => array
    (
        "Sql" => "INT",
        "Search" => False,
        "TimeType"=> 1,
    ),
    "API_Result" => array
    (
        "Sql" => "INT",
        "Search" => False,
    ),
    "API_Status"         => array
    (
        "Sql" => "ENUM",
        "Values" => array
        (
            "Untested","Failure","Success",
        ),

        "Default" => 1,
        "Compulsory" => FALSE,
    ),
);
