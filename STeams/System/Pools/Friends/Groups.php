array
(
   "Basic" => array
   (
       "Data" => array
       (
           "No",
           //"Tournament",
           //"Pool",
           "Friend",
           //"Name",
           "Pool_Friend_Cell_Points",
           //"Pool_Friend_Cell_Stats",
       ),
       
       "Load_Method" => "",
       "CGIs" => array(),
        
       "Dynamic" => array
       (
           "Edit" => array
           (
               "Module" => "Pool_Friends",
               "Action" => "Edit",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array("Tournament","Pool"),
               "Hash" => array
               (
                   "Owner" => "ID",
               ),
           ),
           "Copy" => array
           (
               "Module" => "Pool_Friends",
               "Action" => "Copy",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array("Tournament","Pool"),
               "Hash" => array
               (
                   "Owner" => "ID",
               ),
           ),
           "Delete" => array
           (
               "Module" => "Pool_Friends",
               "Action" => "Delete",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array("Tournament","Pool"),
               "Hash" => array
               (
                   "Owner" => "ID",
               ),
           ),
           "Bets" => array
           (
               "Module" => "Pools",
               "Action" => "Friend",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array("Tournament","Pool"),
               "Hash" => array
               (
                   "Owner" => "ID",
               ),
           ),
       ),
   ),
   "Ranking" => array
   (
       "Data" => array
       (
           "No",
           "Ranking",
           "Friend",
           "Points",
           "Pool_Friend_Cell_Stats",
       ),
       
       "Load_Method" => "",
       "CGIs" => array(),
        
       "Dynamic" => array
       (
           "Edit" => array
           (
               "Module" => "Pool_Friends",
               "Action" => "Edit",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array("Tournament","Pool"),
               "Hash" => array
               (
                   "Owner" => "ID",
               ),
           ),
           "Bets" => array
           (
               "Module" => "Pool_Bets",
               "Action" => "Friend",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array("Tournament","Pool"),
               "Hash" => array
               (
                   "Owner" => "ID",
               ),
           ),
       ),
   ),
);