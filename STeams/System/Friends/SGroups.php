array
(
   "Basic" => array
   (
       "Data" => array
       (
           "Entity",
           "Email","Name","Password",

       ), 
       "Registration" => 1,
   ),
   /* "Places" => array */
   /* ( */
   /*     "Data" => array */
   /*     ( */
   /*         "Unit","State","City","Campus", */
   /*     ),  */
   /*  ), */
   "Profiles" => array
   (
       "Data" => array
       (
           "Profile_Friend",
           "Profile_Coordinator",
           "Profile_Admin",
       ),
    ),
   /* "Permissions" => array */
   /* ( */
   /*     "Data" => $this->Profiles_Data, */
   /*     "GenTableMethod" => "Friend_Permissions_Show", */
   /* ), */
   "System" => array
   (
       "Data" => array
       (
           "TextName",
           "Password",
       ), 
    ),
   "Confirmations" => array
   (
       "Data" => array
       (
           "CondEmail",
           "ConfirmCode","ConfirmDate",
           "RecoverCode","RecoverMTime",
       ), 
    ),
   "Times" => array
   (
       "Data" => array
       (
           "CTime","MTime","ATime",
       ), 
    ),
);