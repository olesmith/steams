array
(
    'Search' => array
    (
        'AccessMethod' => "Pool_Rankings_Access_Show",
    ),
    'Add' => array
    (
        'AccessMethod' => "Pool_Rankings_Access_Edit",
    ),
    'Copy' => array
    (
        'AccessMethod' => "Pool_Rankings_Access_Edit",
    ),
    'Show' => array
    (
        'AccessMethod' => "Pool_Ranking_Access_Show",
    ),
    'Edit' => array
    (
        'AccessMethod' => "Pool_Ranking_Access_Edit",
    ),
    'EditList' => array
    (
        'AccessMethod' => "Pool_Rankings_Access_Edit",
    ),
    'Delete' => array
    (
        'AccessMethod' => "Pool_Ranking_Access_Delete",
    ),
    'Display' => array
    (
        'AccessMethod' => "Pool_Rankings_Access_Show",
        'Handler' => "Pool_Rankings_Display_Handle",
        "Singular" => True,
    ),
    //Why needed?
    'Info' => array
    (
        'AccessMethod' => "Pool_Rankings_Access_Edit",
        //'Handler' => "Pool_Rankings_Display_Handle",
        "Singular" => True,
    ),
);
