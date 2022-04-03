array
(
   "Basic" => array
   (
       "Data" => array
       (
           "No",
           "Tournament","Name",//"Number",
           "Group_NRounds_Cell",
           "Group_NMatches_Cell",
       ),
       "Load_Method" => "",
       "CGIs" => array("Tournament"),
        
       "Dynamic" => array
       (
           "Edit" => array
           (
               "Module" => "Tournament_Groups",
               "Action" => "Edit",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array("Tournament"),
               "Hash" => array
               (
                   "Group" => "ID",
               ),
           ),
           "Teams" => array
           (
               "Module" => "Tournament_Groups",
               "Action" => "Teams",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array("Tournament"),
               "Hash" => array
               (
                   "Group" => "ID",
               ),
           ),
           "Rounds" => array
           (
               "Module" => "Tournament_Groups",
               "Action" => "Rounds",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array("Tournament"),
               "Hash" => array
               (
                   "Group" => "ID",
               ),
           ),
           "Matches" => array
           (
               "Module" => "Tournament_Groups",
               "Action" => "Matches",
               "Args" => array
               (
                   "GroupName" => "Basic",
                   "Search" => 1,
               ),
               "GETs" => array("Tournament"),
               "Hash" => array
               (
                   "Group" => "ID",
               ),
               "Icon" => "Matches_Icon",
           ),
           "Table" => array
           (
               "Module" => "Tournament_Groups",
               "Action" => "Table",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array("Tournament"),
               "Hash" => array
               (
                   "Group" => "ID",
               ),
               
           ),
       ),
   ),
);