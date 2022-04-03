   "Languages" => array
   (
      "SqlClass" => "Languages",
      
      "SqlDerivedData" => "Language_Message_Derived_Data",
      "SqlFile" => "Languages.php",

      "ItemNamer" =>
         "#Name_".
         $this->ApplicationObj()->MyLanguage_Detect(),
      "SqlFilter" =>
         "#Name_".
         $this->ApplicationObj()->MyLanguage_Detect(),
      "SqlTitleFilter" =>
         "#Title_".
         $this->ApplicationObj()->MyLanguage_Detect().
         " (#ID)",
      "SqlHref" => "1",
      "SqlObject" => "LanguagesObject",
      "SqlTable" => "_Languages_",
   ),

   "User_States" => array
   (
       "SqlObject" => "User_StatesObject",
       "SqlClass" => "User_States",
       "SqlFile" => "User_States.php",
       "SqlHref" => TRUE,
       "SqlTable" => "User_States",
       "SqlDerivedData" => array("Login"),
       "SqlFilter" => "#Login",

       'ItemNamer' => 'Login',
   ),
   "Logs" => array
   (
      "SqlClass" => "Logs",
      "SqlDerivedData" => array("Message"),
      "SqlFile" => "Logs.php",
      "SqlFilter" => "#Message",
      "SqlHref" => "1",
      "SqlObject" => "LogsObject",
      "SqlTable" => "Logs",
   ),
   "Countries" => array
   (
      "SqlClass" => "Countries",
      "SqlDerivedData" => array("Name_".$this->MyLanguage_Get()),
      "SqlFile" => "Countries.php",
      "SqlFilter" => "#Name_".$this->MyLanguage_Get(),
      "SqlHref" => "1",
      "SqlObject" => "CountriesObject",
      "SqlTable" => "Countries",
   ),
   "Friends" => array
   (
      "SqlClass" => "Friends",
      "SqlDerivedData" => array("Name","Email"),
      "SqlFile" => "Friends.php",
      "SqlFilter" => "#Name",
      "SqlFilter_Public" => "#Name",
      "SqlTitleFilter" => "#Name (#ID - #Email)",
      "SqlHref" => "1",
      "SqlObject" => "FriendsObject",
      "SqlTable" => "Friends",
   ),
   "Permissions" => array
   (
      "SqlClass" => "Permissions",
      "SqlDerivedData" => array("Name","Email"),
      "SqlFile" => "Permissions.php",
      "SqlFilter" => "#Name",
      "SqlFilter_Public" => "#Name",
      "SqlTitleFilter" => "#Name (#ID - #Email)",
      "SqlHref" => "1",
      "SqlObject" => "PermissionsObject",
      "SqlTable" => "Permissions",
   ),
   "APIs" => array
   (
      "SqlClass" => "APIs",
      "SqlDerivedData" => array("Name"),
      "SqlFile" => "APIs.php",
      "SqlFilter" => "#Name",
      "SqlHref" => "1",
      "SqlObject" => "APIsObject",
      "SqlTable" => "APIs",
   ),
   "Tournaments" => array
   (
      "SqlClass" => "Tournaments",
      "SqlDerivedData" => array("Name"),
      "SqlFile" => "Tournaments.php",
      "SqlFilter" => "#Name",
      "SqlTitleFilter" => "#Name (ID #ID)",
      "SqlObject" => "TournamentsObject",
      "SqlTable" => "Tournaments",
      "ItemNamer" => "Name",
   ),
   "Teams" => array
   (
      "SqlClass" => "Teams",
      "SqlDerivedData" => array
      (
          "Name_".$this->MyLanguage_Get(),
          "Title_".$this->MyLanguage_Get(),
          "Initials_".$this->MyLanguage_Get(),
      ),
      "SqlFile" => "Teams.php",
      "SqlFilter"      => "#Initials_".$this->MyLanguage_Get(),
      "SqlTitleFilter" => "#Name_".    $this->MyLanguage_Get(),
      "SqlObject" => "TeamsObject",
      "SqlTable" => "Teams",
   ),
   "Tournament_Seasons" => array
   (
      "SqlClass" => "Tournament_Seasons",
      "SqlDerivedData" => array("ID","Year","Name"),
      "SqlFile" => "Tournaments/Seasons.php",
      "SqlFilter" => "#Name",
      "SqlTitleFilter" => "#Year (ID #ID)",
      "SqlObject" => "Tournament_SeasonsObject",
      "SqlTable" => "Tournament_Seasons",
   ),
   "Tournament_Teams" => array
   (
      "SqlClass" => "Tournament_Teams",
      "SqlDerivedData" => array("Name","Team"),
      "SqlFile" => "Tournaments/Teams.php",
      "SqlFilter" => "#Name #Team",
      "SqlTitleFilter" => "#Name (ID #ID)",
      "SqlObject" => "Tournament_TeamsObject",
      "SqlTable" => "Tournament_Teams",
   ),
   "Tournament_Groups" => array
   (
      "SqlClass" => "Tournament_Groups",
      "SqlDerivedData" => array("Name"),
      "SqlFile" => "Tournaments/Groups.php",
      "SqlFilter" => "#Name",
      "SqlTitleFilter" => "#Name (ID #ID)",
      "SqlObject" => "Tournament_GroupsObject",
      "SqlTable" => "Tournament_Groups",
   ),
   "Tournament_Rounds" => array
   (
      "SqlClass" => "Tournament_Rounds",
      "SqlDerivedData" => array("Name","Number","Date","Season"),
      "SqlFile" => "Tournaments/Rounds.php",
      "SqlFilter" => "#{%02d}Number, #Season",
      //"SqlTitleFilter" => "#{%02d}Number #Date, #Season",
      "SqlObject" => "Tournament_RoundsObject",
      "SqlTable" => "Tournament_Rounds",
   ),
   "Tournament_Matches" => array
   (
      "SqlClass" => "Tournament_Matches",
      "SqlDerivedData" => array("Name","ID"),
      "SqlFile" => "Tournaments/Matches.php",
      "SqlFilter" => "#Name",
      "SqlTitleFilter" => "#Name (ID #ID)",
      "SqlObject" => "Tournament_MatchesObject",
      "SqlTable" => "Tournament_Matches",
   ),
       
   "Pools" => array
   (
      "SqlClass" => "Pools",
      "SqlDerivedData" => array("Name"),
      "SqlFile" => "Pools.php",
      "SqlFilter" => "#Name",
      "SqlTitleFilter" => "#Name (ID #ID)",
      "SqlObject" => "PoolsObject",
      "SqlTable" => "Pools",
   ),
   "Pool_Friends" => array
   (
      "SqlClass" => "Pool_Friends",
      "SqlDerivedData" => array("Name"),
      "SqlFile" => "Pools/Friends.php",
      "SqlFilter" => "#Name",
      "SqlTitleFilter" => "#Name (ID #ID)",
      "SqlObject" => "Pool_FriendsObject",
      "SqlTable" => "Pool_Friends",
   ),
   "Pool_Bets" => array
   (
      "SqlClass" => "Pool_Bets",
      "SqlDerivedData" => array("Name"),
      "SqlFile" => "Pools/Bets.php",
      "SqlFilter" => "#Name",
      "SqlTitleFilter" => "#Name (ID #ID)",
      "SqlObject" => "Pool_BetsObject",
      "SqlTable" => "Pool_Bets",
   ),
   "Pool_Rankings" => array
   (
      "SqlClass" => "Pool_Rankings",
      "SqlDerivedData" => array("Name"),
      "SqlFile" => "Pools/Rankings.php",
      "SqlFilter" => "#Name",
      "SqlTitleFilter" => "#Name (ID #ID)",
      "SqlObject" => "Pool_RankingsObject",
      "SqlTable" => "Pool_Rankings",
   ),
