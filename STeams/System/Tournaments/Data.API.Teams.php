array
(
    "API_Teams_URL"         => array
    (
        "Sql" => "VARCHAR(256)",
        "Compulsory" => FALSE,
        "Default"  => "teams",
    ),
    "API_Teams_Latency"         => array//seconds!
    (
        "Sql" => "INT",
        "Compulsory" => FALSE,
        "Default"  => 86400,
    ),
    
    "API_Teams_Last"         => array
    (
        "Sql" => "VARCHAR(256)",
        "TimeType"=> 1,

        "Compulsory" => FALSE,
    ),
    "API_Teams_Count"         => array
    (
        "Sql" => "INT",

        "Compulsory" => FALSE,
    ),
    "API_Teams_Status"         => array
    (
        "Sql" => "ENUM",
        "Values" => array
        (
            "Untested","Failure","Success",
        ),

        "Default" => 1,
        "Compulsory" => FALSE,
    ),
    
    "API_Teams_Result"         => array
    (
        "Sql" => "TEXT",
        "Size" => "100x5",

        "Compulsory" => FALSE,
    ),
    "API_Teams_Digest"         => array
    (
        "Sql" => "TEXT",
        "Size" => "100x5",

        "Compulsory" => FALSE,
    ),
);
