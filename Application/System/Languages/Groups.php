array
(
   "Basic" => array
   (
       "Messages_On" => True,
       "Data" => array
       (
           "No",
           "Message_Type",
           "Message_Key",
           "Message",
           "Module","N","Name_PT",
       ),
       "Dynamic" => array
       (
           "Edit" => array
           (
               "Module" => "Languages",
               "Action" => "Edit",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array
               (
                   "ID",
               ),
           ),
           "Copy" => array
           (
               "Module" => "Languages",
               "Action" => "Copy",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array
               (
                   "ID",
               ),
           ),
           "Delete" => array
           (
               "Module" => "Languages",
               "Action" => "Delete",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array
               (
                   "ID",
               ),
           ),
           "Permissions" => array
           (
               "Module" => "Languages",
               "Action" => "Permissions",
               "Args" => array
               (
                   "GroupName" => "Permissions",
               ),
               "GETs" => array
               (
                   "ID",
               ),
               "Icon" => 'fas fa-lock-open',
           ),
           "Messages" => array
           (
               "Module" => "Languages",
               "Action" => "Messages",
               "Args" => array
               (
                   //"GroupName" => "Messages",
               ),
               "GETs" => array
               (
                   "ID",
               ),
               "Icon" => 'fas fa-font',
           ),
       ),
   ),
   "FAQ" => array
   (
       "Messages_On" => True,
       "Data" => array
       (
           "No",
           "Name_PT","Title_PT",
       ),
       
       "Dynamic" => array
       (
            "Edit" => array
            (
                "Module" => "Languages",
                "Action" => "Edit",
                "Args" => array
                (
                    "GroupName" => "FAQ",
                ),
                "GETs" => array
                (
                    "ID",
                ),
            ),
            "Copy" => array
            (
                "Module" => "Languages",
                "Action" => "Copy",
                "Args" => array
                (
                    "GroupName" => "FAQ",
                ),
                "GETs" => array
                (
                    "ID",
                ),
            ),
            "Delete" => array
            (
                "Module" => "Languages",
                "Action" => "Delete",
                "Args" => array
                (
                    "GroupName" => "FAQ",
                ),
                "GETs" => array
                (
                    "ID",
                ),
            ),
       ),
   ),
   "Keys" => array
   (
       "Messages_On" => True,
       "Data" => array
       (
           "No","ID",
           "Module","N",
       ),
       "ReadData" => array
       (
           "Type",     
       ),
   ),
   "_Common_" => array
   (
       "Data" => array
       (
           /* "No", */
           /* "Message_Type", */
           /* "Message_Key", */
           /* "Message", */
       ),     
       "Visible" => False,
   ),
   "Groups" => array
   (
       "Load_Method" => "Message_Dynamic_Empty_Is",
       "Load_Action" => "Messages",

       "Messages_On" => True,
       "Data_Read" =>  $this->Language_Message_Datas(),
       "Data" => $this->MyMod_Handle_Info_Profile_Datas(),
       "Dynamic" => array
       (
            "Edit" => array
            (
                "Module" => "Languages",
                "Action" => "Edit",
                "Args" => array
                (
                    "GroupName" => "Basic",
                ),
                "GETs" => array
                (
                    "ID",
                ),
            ),
            "Delete" => array
            (
                "Module" => "Languages",
                "Action" => "Delete",
                "Args" => array
                (
                    "GroupName" => "Basic",
                ),
                "GETs" => array
                (
                    "ID",
                ),
            ),
            "Permissions" => array
            (
                "Module" => "Languages",
                "Action" => "Permissions",
                "Args" => array
                (
                    "GroupName" => "Permissions",
                ),
                "GETs" => array
                (
                    "ID",
                ),
                "Icon" => 'fas fa-lock-open',
            ),
            "Messages" => array
            (
                "Module" => "Languages",
                "Action" => "Messages",
                "Args" => array
                (
                    "GroupName" => "Permissions",
                ),
                "GETs" => array
                (
                    "ID",
                ),
                "Icon" => 'fas fa-font',
            ),
       ),
   ),
   "Actions" => array
   (
       "Load_Method" => "Message_Dynamic_Empty_Is",
       "Load_Action" => "Messages",

       "Messages_On" => True,
       "Data_Read" =>  $this->Language_Message_Datas(),
       "Data" => $this->MyMod_Handle_Info_Profile_Datas(),
       
       "Dynamic" => array
       (
            "Edit" => array
            (
                "Module" => "Languages",
                "Action" => "Edit",
                "Args" => array
                (
                    "GroupName" => "Basic",
                ),
                "GETs" => array
                (
                    "ID",
                ),
            ),
            "Delete" => array
            (
                "Module" => "Languages",
                "Action" => "Delete",
                "Args" => array
                (
                    "GroupName" => "Basic",
                ),
                "GETs" => array
                (
                    "ID",
                ),
            ),
            "Permissions" => array
            (
                "Module" => "Languages",
                "Action" => "Permissions",
                "Args" => array
                (
                    "GroupName" => "Permissions",
                ),
                "GETs" => array
                (
                    "ID",
                ),
                "Icon" => 'fas fa-lock-open',
            ),
            "Messages" => array
            (
                "Module" => "Languages",
                "Action" => "Messages",
                "Args" => array
                (
                    "GroupName" => "Permissions",
                ),
                "GETs" => array
                (
                    "ID",
                ),
                "Icon" => 'fas fa-font',
            ),
       ),
   ),
   "Datas" => array
   (
       "Load_Method" => "Message_Dynamic_Empty_Is",
       "Load_Action" => "Messages",

       "Messages_On" => True,
       "Data_Read" =>  $this->Language_Message_Datas(),
       "Data" => $this->MyMod_Handle_Info_Profile_Datas(),
       
       "Dynamic" => array
       (
            "Edit" => array
            (
                "Module" => "Languages",
                "Action" => "Edit",
                "Args" => array
                (
                    "GroupName" => "Basic",
                ),
                "GETs" => array
                (
                    "ID",
                ),
            ),
            "Delete" => array
            (
                "Module" => "Languages",
                "Action" => "Delete",
                "Args" => array
                (
                    "GroupName" => "Basic",
                ),
                "GETs" => array
                (
                    "ID",
                ),
            ),
            "Permissions" => array
            (
                "Module" => "Languages",
                "Action" => "Permissions",
                "Args" => array
                (
                    "GroupName" => "Permissions",
                ),
                "GETs" => array
                (
                    "ID",
                ),
                "Icon" => 'fas fa-lock-open',
            ),
            "Messages" => array
            (
                "Module" => "Languages",
                "Action" => "Messages",
                "Args" => array
                (
                    //"GroupName" => "Permissions",
                ),
                "GETs" => array
                (
                    "ID",
                ),
                "Icon" => 'fas fa-font',
            ),
       ),
   ),
);
