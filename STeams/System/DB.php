<?php
array
(
    'ServType' => 'mysql',
    'Type' => "PDO",
    'Host' => '127.0.0.1',
    'DB' => 'steams',
    'User' => 'steams',
    'Password' => 'Jay250621!',
   
    'Mod' => TRUE,
    'Debug' => 2,
    'MailDebug' => False,
    'Debug_Html' => True,
    'Redirect' => False,

   
    'Languages' => array("PT","UK","ES"),
    'Languages_Pre' => '*',

    //DB connection to Messages table
    //Possible to specify alternate values for all above data!
    'Message_ServType' => 'mysql',
    'Message_Type' => 'PDO',
    'Message_Host' => '127.0.0.1',
    'Message_DB' => 'Apps',
    //'Message_User' => '',
    //'Message_Password' => '3nyefoel.',

    'Message_Table' => 'STeams_Messages',
);

?>
