array
(
    "ID" => array
    (
        "Sql" => "INT NOT NULL PRIMARY KEY AUTO_INCREMENT",
    ),
    
    "Message_Type" => array
    (
        "Compulsory"  => True,
        "Search" => TRUE,
        "Size" => 2,
        "Default" => 1,

        "GETSearchVarName"  => "Type",
        "Sql" => "ENUM",
        "NoSelectSort" => True,

        #Enumeration: see Language_Messages.php      
        "Values" => $this->MyLanguage_GetMessages("Language_Message_Types"),

    ),
    "Message_Group" => array
    (
        "Compulsory"  => False,
        "Search" => TRUE,
        "Search_Details" => TRUE,
        "Size" => 2,
        "Default" => 1,
      
        "Sql" => "INT",
        "SqlClass" => "Languages",
        "EditFieldMethod" => "Language_Message_Group_Field",
    ),
    "Message_Key" => array
    (
        "Compulsory"  => True,
        "Search" => TRUE,
        "Size" => 20,

        "Sql" => "VARCHAR(64)",
    ),
   
    "Module" => array
    (
        "Add"  => True,
        "Compulsory"  => FALSE,
        "Search" => TRUE,
        "Size" => 20,

        "Sql" => "VARCHAR(64)",
        "GETSearchVarName"  => "Module",
    ),
    "File" => array
    (
        "Compulsory"  => False,
        "Search" => False,
        "Size" => 2,

        "Sql" => "VARCHAR(64)",
    ),
   
    "N" => array
    (
        "Compulsory"  => False,
        "Search" => False,
        "Size" => 2,
        "Default" => " 0",

        "Add"  => True,
        "Sql" => "VARCHAR(64)",
    ),

    //Columns pertaining to groups
    "GenTableMethod" => array
    (
        "Compulsory"  => False,
        "Search" => False,

        "Sql" => "VARCHAR(256)",
    ),
    "TableDataMethod" => array
    (
        "Compulsory"  => False,
        "Search" => False,

        "Sql" => "VARCHAR(256)",
    ),
);
