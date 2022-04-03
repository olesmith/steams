array
(
   "Basic" => array
   (
       "Data" => array
       (
           "No",
           "Icon","Icon_URL",
           "Initials_UK",
           "Initials_".$this->MyLanguage_Get(),
           "Name_".$this->MyLanguage_Get(),
           "Title_".$this->MyLanguage_Get(),
           "Country","Continent",
           "Type",
           "API_ID",
       ),
       
       "Load_Method" => "",
       "CGIs" => array(),
        
       "Dynamic" => array
       (
           "Edit" => array
           (
               "Module" => "Teams",
               "Action" => "Edit",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array(),
               "Hash" => array
               (
                   "Team" => "ID",
               ),
           ),
           "Copy" => array
           (
               "Module" => "Teams",
               "Action" => "Copy",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array(),
               "Hash" => array
               (
                   "Team" => "ID",
               ),
           ),
           "Delete" => array
           (
               "Module" => "Teams",
               "Action" => "Delete",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array(),
               "Hash" => array
               (
                   "Team" => "ID",
               ),
           ),
       ),
   ),
);