array
(
    'Search' => array
    (
        'AccessMethod' => "Tournament_Seasons_Access_Show",
    ),
    'Add' => array
    (
        'AccessMethod' => "Tournament_Seasons_Access_Edit",
    ),
    'Copy' => array
    (
        'AccessMethod' => "Tournament_Seasons_Access_Edit",
    ),
    'Show' => array
    (
        'AccessMethod' => "Tournament_Season_Access_Show",
    ),
    'Edit' => array
    (
        'AccessMethod' => "Tournament_Season_Access_Edit",
    ),
    'EditList' => array
    (
        'AccessMethod' => "Tournament_Seasons_Access_Edit",
    ),
    'Delete' => array
    (
        'AccessMethod' => "Tournament_Season_Access_Delete",
    ),
    "Teams" => array
    (
        "Href"     => "",
        "HrefArgs" =>
        "Tournament=".$this->Tournament("ID").
        "&Season=#ID",


        "Icon"   => "Teams_Icon",
        //"AccessMethod"   => "Tournaments_Access_Show",
        "Handler"   => "Season_Handle_Teams",

        "Singular"   => TRUE,
    ),
    "Select" => array
    (
        "Href"     => "",
        "HrefArgs" => "Tournament=".$this->Tournament("ID")."&Season=#ID",


        "Icon"   => "Teams_Icon",
        //"AccessMethod"   => "Tournaments_Access_Show",
        "Handler"   => "Tournament_Seasons_Select_Handle",

        "Singular"   => TRUE,
    ),
);
