array
(
    'Search' => array
    (
        'AccessMethod' => "Pools_Access_Show",
    ),
    'Add' => array
    (
        'AccessMethod' => "Pools_Access_Edit",
    ),
    'Copy' => array
    (
        'AccessMethod' => "Pools_Access_Edit",
    ),
    'Show' => array
    (
        'AccessMethod' => "Pool_Access_Show",
    ),
    'Edit' => array
    (
        'AccessMethod' => "Pool_Access_Edit",
    ),
    'EditList' => array
    (
        'AccessMethod' => "Pools_Access_Edit",
    ),
    'Delete' => array
    (
        'AccessMethod' => "Pool_Access_Delete",
    ),
    'Participants' => array
    (
        'AccessMethod' => "Pool_Access_Edit",
        'Handler' => "Pool_Handle_Participants",
        "Icon" => "Friends_Icon",
        "Singular" => True,
    ),
    'Rounds' => array
    (
        'AccessMethod' => "Pool_Access_Edit",
        'Handler' => "Pool_Handle_Rounds",
        "Icon" => "Rounds_Icon",
        "Singular" => True,
    ),
    'Friend' => array
    (
        'AccessMethod' => "Pool_Access_Show",
        'Handler' => "Pool_Friend_Handle",
        "Icon" => "fas fa-user",
        "Singular" => True,
    ),
    'Start' => array
    (
        'AccessMethod' => "Pool_Access_Show",
        'Handler' => "Pool_Friend_Handle",
        "Icon" => "fas fa-home",
        "Singular" => True,
    ),
    'Ranking' => array
    (
        'AccessMethod' => "Pool_Access_Show",
        'Handler' => "Pool_Ranking_Handle",
        "Icon" => "fas fa-sort-numeric-down",
        "Singular" => True,
    ),
    'Rankings' => array
    (
        "HrefArgs" => "ModuleName=Pool_Rankings&Action=Display",
        'AccessMethod' => "Pool_Access_Show",
        //'Handler' => "Pool_Ranking_Handle",
        //"Icon" => "fas fa-sort-numeric-down",
        "Singular" => True,
    ),
    'Select' => array
    (
        "HrefArgs" => "ModuleName=Pools&Action=Select",
        'AccessMethod' => "Pool_Access_Show",
        'Handler' => "Pool_Handle_Select",
        //"Icon" => "fas fa-sort-numeric-down",
        "Singular" => True,
    ),
    'API' => array
    (
        "HrefArgs" => "ModuleName=Tournaments&Action=API",
        'AccessMethod' => "Pool_Access_Show",
        //'Handler' => "Pool_Handle_Select",
        //"Icon" => "fas fa-sort-numeric-down",
        "Singular" => True,
    ),
);
