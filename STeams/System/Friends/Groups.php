array
(
   "Basic" => array
   (
       "Data" => array
       (
           "Email","Name",
           //"Cell","Phone","Url",
           "Profile_Friend","Profile_Coordinator","Profile_Admin",

       ),
       "Registration" => 1,
       "Load_Method" => "",
       "CGIs" => array(),
        
       "Dynamic" => array
       (
           "Edit" => array
           (
               "Module" => "Friends",
               "Action" => "Edit",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array(),
               "Hash" => array
               (
                   "Friend" => "ID",
               ),
           ),
           "Copy" => array
           (
               "Module" => "Friends",
               "Action" => "Copy",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array(),
               "Hash" => array
               (
                   "Friend" => "ID",
               ),
           ),
           "Permissions" => array
           (
               "Module" => "Permissions",
               "Action" => "Search",
               "Args" => array
               (
                   //"GroupName" => "",
               ),
               "GETs" => array(),
               "Hash" => array
               (
                   "Friend" => "ID",
               ),
               "Icon" => 'fas fa-database',
           ),
           "Delete" => array
           (
               "Module" => "Friends",
               "Action" => "Delete",
               "Args" => array
               (
                   "GroupName" => "Basic",
               ),
               "GETs" => array(),
               "Hash" => array
               (
                   "Friend" => "ID",
               ),
           ),
       ),
   ),
   "Times" => array
   (
       "Data" => array
       (
           "Edit","Copy","Delete","Permissions",
           "Email","Name",
           "CTime","MTime","ATime",
       ), 
    ),
   "System" => array
   (
       "Data" => array
       (
           "Edit","Copy","Delete","Permissions",
           "Email","Name",
           "Password",
           "CondEmail",
           "ConfirmCode","ConfirmDate",
       ), 
    ),
   "Profiles" => array
   (
       "Data" => array_merge
       (
           array
           (
               "Edit","Copy","Delete","Permissions",
               "Email","Name",
           ),
           $this->ApplicationObj()->MyApp_Profile_Allowed_Detect()
       ),
    ),
);