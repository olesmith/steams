array
(
    "API_Matches_URL"         => array
    (
        "Sql" => "VARCHAR(256)",
        "Compulsory" => FALSE,
        "Default"  => "matches",
    ),
    "API_Matches_Latency"         => array//seconds!
    (
        "Sql" => "INT",
        "Compulsory" => FALSE,
        "Default"  => 3600,
    ),
    
    "API_Matches_Last"         => array
    (
        "Sql" => "VARCHAR(256)",
        "TimeType"=> 1,

        "Compulsory" => FALSE,
    ),
    "API_Matches_Count"         => array
    (
        "Sql" => "INT",

        "Compulsory" => FALSE,
    ),
    "API_Matches_Status"         => array
    (
        "Sql" => "ENUM",
        "Values" => array
        (
            "Untested","Failure","Success",
        ),

        "Default" => 1,
        "Compulsory" => FALSE,
    ),
    
    "API_Matches_Result"         => array
    (
        "Sql" => "TEXT",
        "Size" => "100x5",

        "Compulsory" => FALSE,
    ),
    "API_Matches_Digest"         => array
    (
        "Sql" => "TEXT",

        "Compulsory" => FALSE,
    ),
);
