array
(
    'Search' => array
    (
        'AccessMethod' => "Tournament_Matches_Access_Show",
    ),
    'Add' => array
    (
        'AccessMethod' => "Tournament_Matches_Access_Edit",
    ),
    'Copy' => array
    (
        'AccessMethod' => "Tournament_Matches_Access_Edit",
    ),
    'Show' => array
    (
        'AccessMethod' => "Tournament_Match_Access_Show",
    ),
    'Edit' => array
    (
        'AccessMethod' => "Tournament_Match_Access_Edit",
    ),
    'EditList' => array
    (
        'AccessMethod' => "Tournament_Matches_Access_Edit",
    ),
    'Delete' => array
    (
        'AccessMethod' => "Tournament_Match_Access_Delete",
    ),
    'Team1' => array
    (
        'AccessMethod' => "Tournament_Match_Access_Show",
        'Handler' => "Tournament_Match_Team_Handle",
        "Singular" => True,
    ),
    'Team2' => array
    (
        'AccessMethod' => "Tournament_Match_Access_Show",
        'Handler' => "Tournament_Match_Team_Handle",
        "Singular" => True,
    ),
    'Details' => array
    (
        'AccessMethod' => "Tournament_Match_Access_Show",
        'Handler' => "Tournament_Match_Details_Handle",
        "Singular" => True,
    ),
    'History' => array
    (
        'AccessMethod' => "Tournament_Match_Access_Show",
        'Handler' => "Tournament_Match_History_Handle",
        "Singular" => True,
    ),
);
