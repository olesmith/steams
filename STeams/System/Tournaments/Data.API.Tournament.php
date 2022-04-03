array
(
    "API_Latency"         => array//seconds!
    (
        "Sql" => "INT",
        "Compulsory" => FALSE,
        "Default"  => 86400,
    ),
    
    "API_Last"         => array
    (
        "Sql" => "VARCHAR(256)",
        "TimeType"=> 1,

        "Compulsory" => FALSE,
    ),
    "API_Count"         => array
    (
        "Sql" => "INT",

        "Compulsory" => FALSE,
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
    
    "API_Result"         => array
    (
        "Sql" => "TEXT",
        "Size" => "100x5",

        "Compulsory" => FALSE,
    ),
    "API_Digest"         => array
    (
        "Sql" => "TEXT",

        "Size" => "100x5",
        "Compulsory" => FALSE,
    ),
);
