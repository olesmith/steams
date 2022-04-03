array
(
   "Basic" => array
   (
       "Data" => array
       (
           "No",
           //"Tournament",
           //"Tournament_Group",
           "Number",
           "StartDate","EndDate",
           "Round_Cell_NMatches",
       ),
       "Load_Method" => "Tournament_Round_Active_Is",
       "Load_Action" => "Matches",
       "CGIs" => array("Tournament","Season"),
        
       "Dynamic" => array
       (
           "Edit" => array
           (
               "Module" => "Tournament_Rounds",
               "Action" => "Edit",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array("Tournament"),
               "Hash" => array
               (
                   "Round" => "ID",
               ),
           ),
           "Matches" => array
           (
               "Module" => "Tournament_Rounds",
               "Action" => "Matches",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array("Tournament"),
               "Hash" => array
               (
                   "Round" => "ID",
               ),
           ),
       ),
   ),
   "Bets" => array
   (
       "Data" => array
       (
           //"No",
           //"Tournament",
           "Tournament_Group",
           "Number",
           "StartDate","EndDate",
           "Round_Cell_Friend_NMatches",
           "Round_Cell_Friend_NBets"
       ),
       "Load_Method" => "Tournament_Round_Active_Is",
       "Load_Action" => "Round",
       "CGIs" => array("Tournament"),
        
       "Dynamic" => array
       (
           "Edit" => array
           (
               "Module" => "Tournament_Rounds",
               "Action" => "Edit",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array("Tournament"),
               "Hash" => array
               (
                   "Round" => "ID",
               ),
           ),
           "Round" => array
           (
               "Module" => "Pool_Friends",
               "Action" => "Round",
               "Args" => array
               (
                   "GroupName" => "Basic",
                   "Friend" => $this->LoginData("ID"),
               ),
               "GETs" => array("Tournament","Pool"),
               "Hash" => array
               (
                   "Round" => "ID",
               ),
           ),
           "Matches" => array
           (
               "Module" => "Tournament_Rounds",
               "Action" => "Matches",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array("Tournament"),
               "Hash" => array
               (
                   "Round" => "ID",
               ),
           ),
           //Adm
           "Rounds" => array
           (
               "Module" => "Pool_Bets",
               "Action" => "Round",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array("Tournament","Pool"),
               "Hash" => array
               (
                   "Round" => "ID",
               ),
               "Icon" => "Bets_Icon",
           ),
           "Ranking" => array
           (
               "Module" => "Pools",
               "Action" => "Ranking",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array("Tournament","Pool","Friend","Owner"),
               "Hash" => array
               (
                   "Round" => "ID",
                   "Owner" => "Owner",
               ),
               //"Icon" => "Ranking_Icon",
           ),
       ),
   ),
   "Friend" => array
   (
       "Data" => array
       (
           //"No",
           //"Tournament",
           //"Tournament_Group",
           "Number",
           "Round_Cell_Dates",
           "Round_Cell_Friend_NMatches",
           "Round_Cell_Friend_NBets",
           "Round_Cell_Friend_Score",
           //"Scores",
       ),
       "Load_Method" => "Tournament_Round_Active_Is",
       "Load_Action" => "Round",
       "CGIs" => array("Tournament","Season","Pool"),
        
       "Dynamic" => array
       (
           "Edit" => array
           (
               "Module" => "Tournament_Rounds",
               "Action" => "Edit",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array("Tournament","Season","Pool"),
               "Hash" => array
               (
                   "Round" => "ID",
               ),
           ),
           "Round" => array
           (
               "Module" => "Pool_Friends",
               "Action" => "Round",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array("Tournament","Season","Pool","Friend","Owner"),
               "Hash" => array
               (
                   "Round" => "ID",
                   "Owner" => "Owner",
               ),
               "Icon" => "Rounds_Icon",
           ),
           "Matches" => array
           (
               "Module" => "Tournament_Rounds",
               "Action" => "Matches",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array("Tournament"),
               "Hash" => array
               (
                   "Round" => "ID",
               ),
           ),
           //Adm
           "Rounds" => array
           (
               "Module" => "Pool_Bets",
               "Action" => "Round",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array("Tournament","Pool"),
               "Hash" => array
               (
                   "Round" => "ID",
               ),
               "Icon" => "Bets_Icon",
           ),
           "Ranking" => array
           (
               "Module" => "Pools",
               "Action" => "Ranking",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array("Tournament","Pool","Friend","Owner"),
               "Hash" => array
               (
                   "Round" => "ID",
                   "Owner" => "Owner",
               ),
               //"Icon" => "Ranking_Icon",
           ),
       ),
   ),
);