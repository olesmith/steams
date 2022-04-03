array
(
    'Search' => array
    (
        'AccessMethod' => "Tournament_Rounds_Access_Show",
    ),
    'Add' => array
    (
        'AccessMethod' => "Tournament_Rounds_Access_Edit",
    ),
    'Copy' => array
    (
        'AccessMethod' => "Tournament_Rounds_Access_Edit",
    ),
    'Show' => array
    (
        'AccessMethod' => "Tournament_Round_Access_Show",
    ),
    'Edit' => array
    (
        'AccessMethod' => "Tournament_Round_Access_Edit",
    ),
    'EditList' => array
    (
        'AccessMethod' => "Tournament_Rounds_Access_Edit",
    ),
    'Delete' => array
    (
        'AccessMethod' => "Tournament_Round_Access_Delete",
    ),
    "Matches" => array
    (
        "Href"     => "",
        "HrefArgs" => "Tournament=#Tournament&Round=#ID",


        "Icon"   => "Matches_Icon",
        "AccessMethod"   => "Tournament_Round_Access_Show",
        "Handler"   => "Tournament_Round_Matches_Handle",

        "Singular"   => TRUE,
    ),
);
