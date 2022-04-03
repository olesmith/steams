array
(
    'Search' => array
    (
        'AccessMethod' => "Tournaments_Access_Show",
    ),
    'Add' => array
    (
        'AccessMethod' => "Tournaments_Access_Edit",
    ),
    'Copy' => array
    (
        'AccessMethod' => "Tournaments_Access_Edit",
    ),
    'Show' => array
    (
        'AccessMethod' => "Tournament_Access_Show",
    ),
    'Edit' => array
    (
        'AccessMethod' => "Tournament_Access_Edit",
    ),
    'EditList' => array
    (
        'AccessMethod' => "Tournaments_Access_Edit",
    ),
    'Delete' => array
    (
        'AccessMethod' => "Tournament_Access_Delete",
    ),
    "LeftMenu" => array
    (
        "Href"     => "",
        "HrefArgs" => "Tournament=#ID&Season=".$this->Season("ID"),


        "Icon"   => "fas fa-people-carry",
        "AccessMethod"   => "Tournament_Access_Show",
        "Handler"   => "Tournament_Handle_LeftMenu",

        "Singular"   => TRUE,
    ),
    "Seasons" => array
    (
        "Href"     => "",
        "HrefArgs" => "Tournament=#ID&Season=".$this->Season("ID"),


        "Icon"   => "Groups_Icon",
        "AccessMethod"   => "Tournaments_Access_Show",
        "Handler"   => "Tournament_Handle_Seasons",

        "Singular"   => TRUE,
    ),
    "Season" => array
    (
        "Href"     => "",
        "HrefArgs" => "ModuleName=Tournament_Seasons&Action=Edit&Tournament=#ID&Season=#Season",


        "Icon"   => "Groups_Icon",
        "AccessMethod"   => "Tournaments_Access_Show",
        "Handler"   => "Tournament_Handle_Season",

        "Singular"   => TRUE,
    ),
    "Groups" => array
    (
        "Href"     => "",
        "HrefArgs" => "Tournament=#ID&Season=".$this->Season("ID"),


        "Icon"   => "Groups_Icon",
        "AccessMethod"   => "Tournaments_Access_Show",
        "Handler"   => "Tournament_Handle_Groups",

        "Singular"   => TRUE,
    ),
    "Teams" => array
    (
        "Href"     => "",
        "HrefArgs" => "Tournament=#ID&Season=".$this->Season("ID"),


        "Icon"   => "Teams_Icon",
        "AccessMethod"   => "Tournaments_Access_Show",
        "Handler"   => "Tournament_Handle_Teams",

        "Singular"   => TRUE,
    ),
    "Rounds" => array
    (
        "Href"     => "",
        "HrefArgs" => "Tournament=#ID&Season=".$this->Season("ID"),


        "Icon"   => "Rounds_Icon",
        "AccessMethod"   => "Tournaments_Access_Show",
        "Handler"   => "Tournament_Handle_Rounds",

        "Singular"   => TRUE,
    ),
    "Matches" => array
    (
        "Href"     => "",
        "HrefArgs" => "Tournament=#ID&Season=".$this->Season("ID"),


        "Icon"   => "Matches_Icon",
        "AccessMethod"   => "Tournaments_Access_Show",
        "Handler"   => "Tournament_Handle_Matches",

        "Singular"   => TRUE,
    ),
    "Pools" => array
    (
        "Href"     => "",
        "HrefArgs" =>
        "ModuleName=Pools&Action=Search&Tournament=#ID&Season=".$this->Season("ID"),


        "Icon"   => "Pools_Icon",
        "AccessMethod"   => "Tournament_Access_Pools",
        "Handler"   => "Tournament_Handle_Pools",

        "Singular"   => TRUE,
    ),
    "API" => array
    (
        "Href"     => "",
        "HrefArgs" => "Tournament=#ID&Season=".$this->Season("ID"),
        
        "Icon"   => "API_Icon",
        "AccessMethod"   => array
        (
            "Tournament_Access_Edit",
            "Tournament_API_Active"
        ),
        "Handler"   => "Tournament_Handle_API",

        "Singular"   => TRUE,
    ),
    "Table" => array
    (
        "Href"     => "",
        "HrefArgs" => "Tournament=#ID&Season=".$this->Season("ID"),


        "Icon"   => "Table_Icon",
        "AccessMethod"   => "Tournament_Access_Show",
        "Handler"   => "Tournament_Handle_Tables",

        "Singular"   => TRUE,
    ),
    "Select" => array
    (
        "Href"     => "",
        "HrefArgs" => "Tournament=#ID&Season=".$this->Season("ID"),


        "Icon"   => "Teams_Icon",
        "AccessMethod"   => "Tournaments_Access_Show",
        "Handler"   => "Tournament_Handle_Select",

        "Singular"   => TRUE,
    ),
);
