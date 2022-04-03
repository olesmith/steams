array
(
   "Basic" => array
   (
       "Data" => array
       (
           "No","Name","Type","Title",
           //"UTC",
           "Country","Continent",
           "Season",
           "StartDate","EndDate",
       ),
       
       "Load_Method" => "",
       "CGIs" => array(),
        
       "Dynamic" => array
       (
           "Edit" => array
           (
               "Module" => "Tournaments",
               "Action" => "Edit",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array(),
               "Hash" => array
               (
                   "Tournament" => "ID",
                   "Season" => "Season",
               ),
           ),
           "Copy" => array
           (
               "Module" => "Tournaments",
               "Action" => "Copy",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array(),
               "Hash" => array
               (
                   "Tournament" => "ID",
                   "Season" => "Season",
               ),
           ),
           "Season" => array
           (
               "Module" => "Tournament_Seasons",
               "Action" => "Edit",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array(),
               "Hash" => array
               (
                   "Tournament" => "ID",
                   "Season" => "Season",
               ),
               "Icon" => "Season_Icon"
           ),
           "Seasons" => array
           (
               "Module" => "Tournament_Seasons",
               "Action" => "Search",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array(),
               "Hash" => array
               (
                   "Tournament" => "ID",
                   "Season" => "Season",
               ),
               "Icon" => "Seasons_Icon"
           ),
           "Delete" => array
           (
               "Module" => "Tournaments",
               "Action" => "Delete",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array(),
               "Hash" => array
               (
                   "Tournament" => "ID",
                   "Season" => "Season",
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
               "GETs" => array(),
               "Hash" => array
               (
                   "Tournament" => "ID",
                   "Season" => "Season",
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
               "GETs" => array(),
               "Hash" => array
               (
                   "Tournament" => "ID",
                   "Season" => "Season",
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
               "GETs" => array(),
               "Hash" => array
               (
                   "Tournament" => "ID",
                   "Season" => "Season",
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
               "GETs" => array(),
               "Hash" => array
               (
                   "Tournament" => "ID",
                   "Season" => "Season",
               ),
               "Icon" => "Matches_Icon",
           ),
           "Pools" => array
           (
               "AccessMethod"   => "Tournament_Access_Pools",
               "Module" => "Pools",
               "Action" => "Search",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array(),
               "Hash" => array
               (
                   "Tournament" => "ID",
                   "Season" => "Season",
               ),
               "Icon" => "Pools_Icon",
           ),
           "API" => array
           (
               "Module" => "Tournaments",
               "Action" => "API",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array(),
               "Hash" => array
               (
                   "Tournament" => "ID",
                   "Season" => "Season",
               ),
               "Icon" => "API_Icon",
           ),
       ),
   ),
   "Mobile" => array
   (
       "Data" => array
       (
           "No","Name",
           "StartDate","EndDate",
       ),
       "Actions_Position" => 2,
       "Load_Method" => "Tournament_Active",
       "Load_Action" => "Rounds",
       "CGIs" => array(),
        
       "Dynamic" => array
       (
           "Matches" => array
           (
               "Module" => "Tournaments",
               "Action" => "Matches",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array(),
               "Hash" => array
               (
                   "Tournament" => "ID",
                   "Season" => "Season",
               ),
               "Icon" => "Matches_Icon",
           ),
           "Rounds" => array
           (
               "Module" => "Tournaments",
               "Action" => "Rounds",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array(),
               "Hash" => array
               (
                   "Tournament" => "ID",
                   "Season" => "Season",
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
               "GETs" => array(),
               "Hash" => array
               (
                   "Tournament" => "ID",
                   "Season" => "Season",
               ),
           ),
           "Table" => array
           (
               "Module" => "Tournaments",
               "Action" => "Table",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array(),
               "Hash" => array
               (
                   "Tournament" => "ID",
                   "Season" => "Season",
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
               "GETs" => array(),
               "Hash" => array
               (
                   "Tournament" => "ID",
                   "Season" => "Season",
               ),
           ),
           "Seasons" => array
           (
               "Module" => "Tournament_Seasons",
               "Action" => "Search",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array(),
               "Hash" => array
               (
                   "Tournament" => "ID",
                   "Season" => "Season",
               ),
               "Icon" => "Seasons_Icon"
           ),
           "Pools" => array
           (
               "AccessMethod"   => "Tournament_Access_Pools",
               "Module" => "Pools",
               "Action" => "Search",
               "Args" => array
               (
                   "GroupName" => "Basic",
                   "Season" => $this->Season("ID"),
               ),
               "GETs" => array(),
               "Hash" => array
               (
                   "Tournament" => "ID",
                   "Season" => "Season",
               ),
               "Icon" => "Pools_Icon",
           ),
       ),
   ),
   "Configuration" => array
   (
       "Data" => array
       (
           "Name","Type","Title",
           "UTC",
           "StartDate","EndDate","HHMM",
           "NTeams","NGroups",
           "HomeAndAway","Cup",
           "API_Auth","API_ID",

       ),
       
       "Load_Method" => "",
       "CGIs" => array(),
        
       "Dynamic" => array
       (
           "Edit" => array
           (
               "Module" => "Tournaments",
               "Action" => "Edit",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array(),
               "Hash" => array
               (
                   "Tournament" => "ID",
                   "Season" => "Season",
               ),
           ),
           "Copy" => array
           (
               "Module" => "Tournaments",
               "Action" => "Copy",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array(),
               "Hash" => array
               (
                   "Tournament" => "ID",
                   "Season" => "Season",
               ),
           ),
           "Delete" => array
           (
               "Module" => "Tournaments",
               "Action" => "Delete",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array(),
               "Hash" => array
               (
                   "Tournament" => "ID",
                   "Season" => "Season",
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
               "GETs" => array(),
               "Hash" => array
               (
                   "Tournament" => "ID",
                   "Season" => "Season",
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
               "GETs" => array(),
               "Hash" => array
               (
                   "Tournament" => "ID",
                   "Season" => "Season",
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
               "GETs" => array(),
               "Hash" => array
               (
                   "Tournament" => "ID",
                   "Season" => "Season",
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
               "GETs" => array(),
               "Hash" => array
               (
                   "Tournament" => "ID",
                   "Season" => "Season",
               ),
               "Icon" => "Matches_Icon",
           ),
           "Pools" => array
           (
               "Module" => "Pools",
               "Action" => "Search",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array(),
               "Hash" => array
               (
                   "Tournament" => "ID",
                   "Season" => "Season",
               ),
               "Icon" => "Pools_Icon",
           ),
       ),
   ),
);