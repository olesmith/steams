array
(
   "ID"           =>  array
   (
      "Sql"   => "INT NOT NULL PRIMARY KEY AUTO_INCREMENT",
      "Compulsory" => FALSE,
      "Visible" => 0,
   ),
   "Language" => array
   (
      "Sql" => "VARCHAR(4)",

      "Compulsory" => False,
   ),
   "City" => array
   (
      "Sql" => "INT",
      "SqlClass" => "Cities",
      "Search" => FALSE,

      "Compulsory" => False,
      "NoAdd"      => True,
      "ReadOnly"   => True,
   ),
   "Name"         => array
   (
      "Sql" => "VARCHAR(256)",
      "Size" => "35",
      "Compulsory" => 1,
      "Search"  => TRUE,
      "TrimCase"  => TRUE,
   ),
   "TextName"         => array
   (
      "Sql" => "VARCHAR(256)",
      "Size" => "35",
      "Compulsory" => FALSE,
      "TrimCase" => 1,
      "Search"  => FALSE,
   ),
   "Email"        => array
   (
      "Sql" => "VARCHAR(256)",
      "Size" => "25",
      "Compulsory" => 1,
      "ShowOnly" => 1,
      "Unique" => 1,
      "Iconify" => 1,
      "IconColors" => 'LightGrey',
      "BkIconColors" => 'DarkBlue',
      "Search"  => TRUE,
   ),
   "Password"     => array
   (
      "Sql" => "VARCHAR(256)",
      "Type"  => "",
      "Size" => "10",
      "Compulsory" => FALSE,

      #"Crypt" => "MD5",
      "Crypt" => "BlowFish",
      "Password" => 1,
    ),
   "RecoverCode" => array
   (
      "Sql" => "VARCHAR(20)",
      "Search" => FALSE,
      "ReadOnly" => TRUE,
      "AdminReadOnly" => TRUE,
   ),
   "RecoverMTime" => array
   (
      "Sql" => "INT",
      "Search" => FALSE,
      "ReadOnly" => TRUE,
      "AdminReadOnly" => TRUE,
      "TimeType" => TRUE,
      "Default" => 0,
   ),
   "CondEmail"        => array
   (
      "Sql" => "VARCHAR(256)",
      "Size" => "25",
      "Compulsory" => FALSE,
      "Visible" => 0,
      "Search"  => TRUE,
      "NoAdd"  => TRUE,
   ),
   "ConfirmCode"        => array
   (
      "Sql" => "VARCHAR(256)",
      "Size" => "20",
      "Compulsory" => FALSE,
      "Visible" => 0,
      "Search"  => TRUE,
      "NoAdd"  => TRUE,
   ),
   "ConfirmDate"       => array
   (
       "Sql" => "VARCHAR(256)",
       "Compulsory" => FALSE,
       "TimeType"=> 1,
   ),
   "Profile_Friend" => array
   (
       "Sql" => "ENUM",
       "Values" => $this->MyLanguage_GetMessages("NoYes"),
                
       "Default" => 2,
       "Search" => TRUE,
       "SearchCheckBox" => TRUE,

       "Admin" => 2,
       "Friend" => 0,
       "Coordinator" => 2,
       "Person" => 0,
       "Public" => 0,
   ),
   "Profile_Coordinator" => array
   (
       "Sql" => "ENUM",
       "Values" => $this->MyLanguage_GetMessages("NoYes"),
                
       "Default" => 1,
       "Search" => TRUE,
       "SearchCheckBox" => TRUE,

       "Admin"  => 2,
       "Friend" => 0,
       "Coordinator" => 2,
       "Person" => 0,
       "Public" => 0,
   ),
   "Profile_Admin" => array
   (
       "Sql" => "ENUM",
       "Values" => $this->MyLanguage_GetMessages("NoYes"),
                
       "Default" => 1,
       "Search" => TRUE,
       "SearchCheckBox" => TRUE,

       "Admin"  => 2,
       "Friend" => 0,
       "Coordinator" => 1,
       "Person" => 0,
       "Public" => 0,
   ),
);
