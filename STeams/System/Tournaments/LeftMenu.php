array
(
   'Title' => 'Tours',

   'Public' => 1,
   'Person' => 1,
   'Coordinator' => 1,
   'Admin' => 1,
   
    '1_Seasons' => array
    (
        'Href' =>
        '?Tournament='.$this->Tournament("ID").
        '&Season='.$this->Season("ID").
        '&ModuleName=Tournaments'.
        '&Action=Seasons',
        'Public' => 1,
        'Person' => 1,
        'Coordinator' => 1,
        'Admin' => 1,
    ),
);
