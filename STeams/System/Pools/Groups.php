array
(
   "Basic" => array
   (
       "Data" => array
       (
           "No",
           "Tournament","Name","Season",
           "Friend",
       ),
       "Load_Method" => "",
       "CGIs" => array("Tournament","Season",),
        
       "Dynamic" => array
       (
           "Edit" => array
           (
               "Module" => "Pools",
               "Action" => "Edit",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array("Tournament","Season",),
               "Hash" => array
               (
                   "Pool" => "ID",
               ),
           ),
           "Copy" => array
           (
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array("Tournament","Season",),
               "Hash" => array
               (
                   "Pool" => "ID",
               ),
           ),
           "Friend" => array
           (
               "Module" => "Pools",
               "Action" => "Friend",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array("Tournament","Season","Season",),
               "Hash" => array
               (
                   "Pool" => "ID",
               ),
               //"Icon" => 'fas fa-user',
           ),
           "Participants" => array
           (
               "Module" => "Pools",
               "Action" => "Participants",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array("Tournament","Season",),
               "Hash" => array
               (
                   "Pool" => "ID",
               ),
           ),
           "Rounds" => array
           (
               "Module" => "Pools",
               "Action" => "Rounds",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array("Tournament","Season",),
               "Hash" => array
               (
                   "Pool" => "ID",
               ),
           ),
           "Ranking" => array
           (
               "Module" => "Pools",
               "Action" => "Ranking",
               "Args" => array
               (
                   "GroupName" => "Ranking",
               ),
               "GETs" => array("Tournament","Season",),
               "Hash" => array
               (
                   "Pool" => "ID",
               ),
           ),
           /* "Rankings" => array */
           /* ( */
           /*     "Module" => "Pool_Rankings", */
           /*     "Action" => "Display", */
           /*     "Args" => array */
           /*     ( */
           /*         "GroupName" => "Ranking", */
           /*     ), */
           /*     "GETs" => array("Tournament","Season",), */
           /*     "Hash" => array */
           /*     ( */
           /*         "Pool" => "ID", */
           /*     ), */
           /* ), */
       ),
   ),
);