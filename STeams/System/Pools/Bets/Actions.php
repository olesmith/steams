array
(
    'Search' => array
    (
        'AccessMethod' => "Pool_Bets_Access_Show",
    ),
    'Add' => array
    (
        'AccessMethod' => "Pool_Bets_Access_Edit",
    ),
    'Copy' => array
    (
        'AccessMethod' => "Pool_Bets_Access_Edit",
    ),
    'Show' => array
    (
        'AccessMethod' => "Pool_Bet_Access_Show",
    ),
    'Edit' => array
    (
        'AccessMethod' => "Pool_Bet_Access_Edit",
    ),
    'EditList' => array
    (
        'AccessMethod' => "Pool_Bets_Access_Edit",
    ),
    'Delete' => array
    (
        'AccessMethod' => "Pool_Bet_Access_Delete",
    ),

    "Friend" => array
    (
        "Href"     => "",
        "HrefArgs" => "Tournament=#Tournament&Friend=#Friend",


        "Icon"   => "Rounds_Icon",
        "AccessMethod"   => "Pool_Bets_Access_Show",
        //"Handler"   => "Tournament_Round_Matches_Handle",
        "Handler"   => "Pool_Bets_Friend_Handle",

        "Singular"   => TRUE,
    ),
    "Round" => array
    (
        "Href"     => "",
        "HrefArgs" => "Tournament=#Tournament&Round=#Round",


        "Icon"   => "Rounds_Icon",
        "AccessMethod"   => "Pool_Bets_Access_Show",
        "Handler"   => "Pool_Bets_Round_Handle",


        "Icon" => "Bet_Icon",
        "Singular"   => TRUE,
    ),
);
