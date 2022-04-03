<?php

include_once("Actions/Defaults.php");
include_once("Actions/Names.php");
include_once("Actions/Titles.php");
include_once("Actions/Update.php");

class Language_Messages_Actions extends Language_Messages_Item
{
    use
        Language_Messages_Actions_Defaults,
        Language_Messages_Actions_Names,
        Language_Messages_Actions_Titles,
        Language_Messages_Actions_Update;
    
    var $Actions_Messages=array();
    
}
?>