array
(
   "Basic" => array
   (
       "Data" => array
       (
           "No","Flag","Initials",
           "Name_".$this->MyLanguage_Get(),
           "Title_".$this->MyLanguage_Get(),
           "Continent",

       ),
       "Load_Method" => "",
       "CGIs" => array(),
        
       "Dynamic" => array
       (
           "Edit" => array
           (
               "Module" => "Countries",
               "Action" => "Edit",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array(),
               "Hash" => array
               (
                   "Country" => "ID",
               ),
           ),
           "Copy" => array
           (
               "Module" => "Countries",
               "Action" => "Copy",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array(),
               "Hash" => array
               (
                   "Country" => "ID",
               ),
           ),
           "Delete" => array
           (
               "Module" => "Countries",
               "Action" => "Delete",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array(),
               "Hash" => array
               (
                   "Country" => "ID",
               ),
           ),
       ),
   ),
);