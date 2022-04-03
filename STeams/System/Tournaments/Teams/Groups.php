array
(
   "Basic" => array
   (
       "Data" => array
       (
           "No",
           //"Tournament_Team_Icon",
           "Name",
           "Team",

           //"Points_Home","Points_Away","Points_Total",
           "Matches_Total",
           "Matches_Victory",
           "Matches_Draw",
           "Matches_Defeat",
           "Goals_Favor","Goals_Against","Goals_Total",
           "Points_Total",
           "API_ID",
       ),
       "Load_Method" => "",
       "CGIs" => array("Tournament"),
        
       "Dynamic" => array
       (
           "Team" => array
           (
               "Module" => "Teams",
               "Action" => "Edit",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array("Tournament"),
               "Hash" => array
               (
                   "Team" => "Team",
               ),
               "Icon_Method"   => "Team_Icon",
           ),
           "Matches" => array
           (
               "Module" => "Tournament_Teams",
               "Action" => "Matches",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array("Tournament"),
               "Hash" => array
               (
                   "ID" => "ID",
               ),
               "Icon"   => "Matches_Icon",
           ),
       ),
   ),
);