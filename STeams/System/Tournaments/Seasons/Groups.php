array
(
   "Basic" => array
   (
       "Data" => array
       (
           "No",
           "Tournament","Year",
           "Tournament_Season_Cell_Period",
           "Tournament_Season_Cell_Teams_N",
           "Tournament_Season_Cell_Matches_N",
           "Tournament_Season_Cell_Rounds_N",
           "Tournament_Season_Cell_Groups_N",            
       ),
       "Load_Method" => "Tournament_Season_Active",
       "Load_Action" => "Teams",
       "CGIs" => array("Tournament"),
        
       "Dynamic" => array
       (
           "Edit" => array
           (
               "Module" => "Tournament_Seasons",
               "Action" => "Edit",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array("Tournament"),
               "Hash" => array
               (
                   "Season" => "ID",
               ),
           ),
           "Teams" => array
           (
               "Module" => "Tournaments",
               "Action" => "Teams",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array("Tournament"),
               "Hash" => array
               (
                   "Season" => "ID",
               ),
           ),
           "Groups" => array
           (
               "Module" => "Tournaments",
               "Action" => "Groups",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array("Tournament"),
               "Hash" => array
               (
                   "Season" => "ID",
               ),
           ),
           "Rounds" => array
           (
               "Module" => "Tournaments",
               "Action" => "Rounds",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array("Tournament"),

               "Hash" => array
               (
                   "Season" => "ID",
               ),
           ),
           "Matches" => array
           (
               "Module" => "Tournament_Matches",
               "Action" => "Search",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array("Tournament"),
               "Hash" => array
               (
                   "Season" => "ID",
               ),
               "Icon" => "Matches_Icon",
           ),
           "Pools" => array
           (
               "AccessMethod"   => "Tournament_Season_Access_Pools",
               "Module" => "Pools",
               "Action" => "Search",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array("Tournament"),

               "Hash" => array
               (
                   "Season" => "ID",
               ),
               "Icon" => "Pools_Icon",
           ),
        ),
   ),
);