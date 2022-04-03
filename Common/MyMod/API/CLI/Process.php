<?php

include_once("Process/Item.php");
include_once("Process/Page.php");
include_once("Process/Pages.php");

trait MyMod_API_CLI_Process
{
    use
        MyMod_API_CLI_Process_Item,
        MyMod_API_CLI_Process_Page,
        MyMod_API_CLI_Process_Pages;
}

?>