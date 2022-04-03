array
(
   'Title' => 'Seasons',

   'Public' => 1,
   'Person' => 1,
   'Coordinator' => 1,
   'Admin' => 1,
   
    '1_Ranking' => array
    (
        'Href' =>
        '?Tournament='.$this->Tournament("ID").
        '&Season='.$this->Season("ID").
        '&ModuleName=Tournaments'.
        '&Action=Teams',
        'Public' => 1,
        'Person' => 1,
        'Coordinator' => 1,
        'Admin' => 1,
    ),
    '2_Rounds' => array
    (
        'Href' =>
        '?Tournament='.$this->Tournament("ID").
        '&Season='.$this->Season("ID").
        '&ModuleName=Tournaments'.
        '&Action=Rounds',
        'Public' => 1,
        'Person' => 1,
        'Coordinator' => 1,
        'Admin' => 1,
    ),
    '4_Matches' => array
    (
        'Href' =>
        '?Tournament='.$this->Tournament("ID").
        '&Season='.$this->Season("ID").
        '&ModuleName=Tournaments'.
        '&Action=Matches',
        'Public' => 1,
        'Person' => 1,
        'Coordinator' => 1,
        'Admin' => 1,
    ),
    '5_Groups' => array
    (
        'Href' =>
        '?Tournament='.$this->Tournament("ID").
        '&Season='.$this->Season("ID").
        '&ModuleName=Tournaments'.
        '&Action=Groups',
        'Public' => 1,
        'Person' => 1,
        'Coordinator' => 1,
        'Admin' => 1,
    ),
);
