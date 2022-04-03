array
(
    "ID" => array
    (
        "Sql" => "INT NOT NULL PRIMARY KEY AUTO_INCREMENT",

    ),
    "Tournament" => array
    (
        "Sql" => "INT",
        "SqlClass" => "Periods",
        "Search" => TRUE,
        "Compulsory" => FALSE,
        //"SqlSortReverse" => TRUE,
        //"SearchFieldMethod" => "PeriodSearchField",
    ),
    "Season" => array
    (
        "Sql" => "VARCHAR(16)",
        "Search" => FALSE,
        "Compulsory" => TRUE,
    ),
    "Pool" => array
    (
        "Sql" => "VARCHAR(256)",
        "Search" => FALSE,
        "Compulsory" => TRUE,
    ),
    "Profile" => array
    (
        "Sql" => "VARCHAR(16)",
        "Search" => FALSE,
        "Compulsory" => TRUE,
    ),
    "Name" => array
    (
        "Sql" => "VARCHAR(256)",
        "Search" => FALSE,
        "Compulsory" => TRUE,
    ),
    "Login" => array
    (
        "Sql" => "INT",
        "SqlClass" => "Users",
        "Search" => FALSE,
        "Compulsory" => TRUE,
    ),
    /* "ModuleName" => array */
    /* ( */
    /*     "Sql" => "VARCHAR(256)", */
    /*     "Search" => FALSE, */
    /*     "Compulsory" => FALSE, */
    /* ), */
    /* "Action" => array */
    /* ( */
    /*     "Sql" => "VARCHAR(256)", */
    /*     "Search" => FALSE, */
    /*     "Compulsory" => FALSE, */
    /* ), */
);
