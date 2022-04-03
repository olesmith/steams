array
(
    'Search' => array
    (
        'AccessMethod' => "Tournament_Groups_Access_Show",
    ),
    'Add' => array
    (
        'AccessMethod' => "Tournament_Groups_Access_Edit",
    ),
    'Copy' => array
    (
        'AccessMethod' => "Tournament_Groups_Access_Edit",
    ),
    'Show' => array
    (
        'AccessMethod' => "Tournament_Group_Access_Show",
    ),
    'Edit' => array
    (
        'AccessMethod' => "Tournament_Group_Access_Edit",
    ),
    'EditList' => array
    (
        'AccessMethod' => "Tournament_Groups_Access_Edit",
    ),
    'Delete' => array
    (
        'AccessMethod' => "Tournament_Group_Access_Delete",
    ),
    "Teams" => array
    (
        "Href"     => "",
        "HrefArgs" => "Tournament=#Tournament&Group=#ID",


        "Icon"   => "Teams_Icon",
        "AccessMethod"   => "Tournament_Group_Access_Edit",
        "Handler"   => "Tournament_Group_Teams_Handle",

        "Singular"   => TRUE,
    ),
    "Rounds" => array
    (
        "Href"     => "",
        "HrefArgs" => "Tournament=#Tournament&Group=#ID",


        "Icon"   => "Rounds_Icon",
        "AccessMethod"   => "Tournament_Group_Access_Edit",
        "Handler"   => "Tournament_Group_Rounds_Handle",

        "Singular"   => TRUE,
    ),
    "Matches" => array
    (
        "Href"     => "",
        "HrefArgs" => "Tournament=#Tournament&Group=#ID",


        "Icon"   => "Matches_Icon",
        "AccessMethod"   => "Tournament_Group_Access_Show",
        "Handler"   => "Tournament_Group_Matches_Handle",

        "Singular"   => TRUE,
    ),
    "Table" => array
    (
        "Href"     => "",
        "HrefArgs" => "Tournament=#Tournament&Group=#ID",


        "Icon"   => "Table_Icon",
        "AccessMethod"   => "Tournament_Group_Access_Show",
        "Handler"   => "Tournament_Group_Matches_Handle",

        "Singular"   => TRUE,
    ),
);
