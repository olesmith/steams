<?php

include_once("CLI/IDs.php");
include_once("CLI/Process.php");
include_once("CLI/Delete.php");

trait MyMod_API_CLI
{
    use
        MyMod_API_CLI_IDs,
        MyMod_API_CLI_Process,
        MyMod_API_CLI_Delete;
}

?>