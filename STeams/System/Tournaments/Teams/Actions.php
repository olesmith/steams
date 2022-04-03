array
(
    'Search' => array
    (
        'AccessMethod' => "Tournament_Teams_Access_Show",
    ),
    'Add' => array
    (
        'AccessMethod' => "Tournament_Teams_Access_Edit",
    ),
    'Copy' => array
    (
        'AccessMethod' => "Tournament_Teams_Access_Edit",
    ),
    'Show' => array
    (
        'AccessMethod' => "Tournament_Team_Access_Show",
        "Icon" => "?ModuleName=Teams&Action=Download&Data=Icon&ID=#ID",
    ),
    'Edit' => array
    (
        'AccessMethod' => "Tournament_Team_Access_Edit",
    ),
    'EditList' => array
    (
        'AccessMethod' => "Tournament_Teams_Access_Edit",
    ),
    'Delete' => array
    (
        'AccessMethod' => "Tournament_Team_Access_Delete",
    ),
    "Matches" => array
    (
        "Href"     => "",
        "HrefArgs" => "Tournament=#Tournament&Team=#ID",


        "Icon"   => "Matches_Icon",
        "AccessMethod"   => "Tournament_Team_Access_Show",
        "Handler"   => "Tournament_Team_Matches_Handle",

        "Singular"   => TRUE,
    ),
    /* 'Team' => array */
    /* ( */
    /*     "HrefArgs" => "Tournament=#Tournament&Group=#Group", */


    /*     "Icon"   => "Teams_Icon", */
    /*     'AccessMethod' => "Tournament_Team_Access_Show", */
    /* ), */
);
