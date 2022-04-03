array
(
    "ID" => array
    (
        "Sql" => "INT NOT NULL PRIMARY KEY AUTO_INCREMENT",
    ),
    /* "Type" => array */
    /* ( */
    /*     "Sql" => "ENUM", */
    /*     "Values" => $this->MyLanguage_GetMessages("Permission_Types"), */
     
    /*     "Default" => "0 ", */
      
    /*     "NoSelectSort" => TRUE, */
    /*     "Search" => TRUE, */
    /*     "Compulsory"  => FALSE, */

    /* ), */
    "User" => array
    (
        "Sql" => "INT",
        "SqlClass" => "Friends",
     
        "Default" => "0 ",
        "Add" => TRUE,
      
        "Search" => TRUE,
        "Compulsory"  => True,
    ),
    "Profile" => array
    (
        "Sql" => "ENUM",
        "Values" => $this->Permissions_Profile_Select_Names(),
     
        "Default" => "0 ",
        "Add" => TRUE,
      
        "NoSelectSort" => TRUE,
        "Search" => TRUE,
        "Compulsory"  => True,
        //"EditFieldMethod" => "Permission_Select_Profile",
    ),
    "Comment" => array
    (
        "Size" => "25",
        "Sql" => "VARCHAR(256)",
        //"Search"  => FALSE,
        "Add" => TRUE,
        "Compulsory"  => FALSE,
    ),
);
