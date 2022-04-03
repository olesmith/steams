array
(
   "Basic" => array
   (
       "Data" => array
       (
           "No",
           "Tournament_Match_Cell_Name",
           "Tournament_Match_Cell_Team_Icons",
           "Match_Cell_Score",
           "Tournament_Match_Cell_Stage",
           "Tournament_Match_Cell_Status",
           "Tournament_Match_Cell_Time",
           "Match_Cell_Points",
       ),
       "Load_Method" => "",
       "Focus_Set_Method" => "Tournament_Matches_Initial_Set",
       "CGIs" => array("Tournament"),
        
       "Dynamic" => array
       (
           "Details" => array
           (
               "Module" => "Tournament_Matches",
               "Action" => "Details",
               "Args" => array
               (
                   "GroupName" => "Result",
               ),
               "GETs" => array("Tournament"),
               "Hash" => array
               (
                   "Match" => "ID",
               ),
               "Icon" => "fas fa-search-plus",
           ),
           "Date" => array
           (
               "Module" => "Tournament_Matches",
               "Action" => "Edit",
               "Args" => array
               (
                   "GroupName" => "Date",
               ),
               "GETs" => array("Tournament"),
               "Hash" => array
               (
                   "Match" => "ID",
               ),
               "Icon" => "Dates_Icon",
           ),
           "Result" => array
           (
               "Module" => "Tournament_Matches",
               "Action" => "Edit",
               "Args" => array
               (
                   "GroupName" => "Result",
               ),
               "GETs" => array("Tournament"),
               "Hash" => array
               (
                   "Match" => "ID",
               ),
               "Icon" => "Results_Icon",
           ),
       ),
   ),
   "History" => array
   (
       "Data" => array
       (
           "No",
           "Season",
           "Match_Name_Cell",
           "Tournament_Match_Cell_Team_Icons",
           "Match_Cell_Score",
           "Tournament_Match_Cell_Stage",
           "Status",
           "Duration",
           "Match_Cell_Points",
           //"Tournament_Round",
           "Date","HHMM",
       ),
       "Load_Method" => "",
       "Focus_Set_Method" => "Tournament_Matches_Initial_Set",
       "CGIs" => array("Tournament"),
        
       "Dynamic" => array
       (
           "Details" => array
           (
               "Module" => "Tournament_Matches",
               "Action" => "Details",
               "Args" => array
               (
                   "GroupName" => "Result",
               ),
               "GETs" => array("Tournament"),
               "Hash" => array
               (
                   "Match" => "ID",
               ),
               "Icon" => "fas fa-search-plus",
           ),
           "Date" => array
           (
               "Module" => "Tournament_Matches",
               "Action" => "Edit",
               "Args" => array
               (
                   "GroupName" => "Date",
               ),
               "GETs" => array("Tournament"),
               "Hash" => array
               (
                   "Match" => "ID",
               ),
               "Icon" => "Dates_Icon",
           ),
           "Result" => array
           (
               "Module" => "Tournament_Matches",
               "Action" => "Edit",
               "Args" => array
               (
                   "GroupName" => "Result",
               ),
               "GETs" => array("Tournament"),
               "Hash" => array
               (
                   "Match" => "ID",
               ),
               "Icon" => "Results_Icon",
           ),
       ),
   ),
);