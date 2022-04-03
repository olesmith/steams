<?php

include_once("Attachments/Add.php");
include_once("Attachments/Cells.php");
include_once("Attachments/CGI.php");
include_once("Attachments/File.php");
include_once("Attachments/Remove.php");
include_once("Attachments/Rows.php");
include_once("Attachments/Upload.php");

trait MyMod_Handle_Email_Attachments
{
    use
        MyMod_Handle_Email_Attachments_Add,
        MyMod_Handle_Email_Attachments_Cells,
        MyMod_Handle_Email_Attachments_CGI,
        MyMod_Handle_Email_Attachments_File,
        MyMod_Handle_Email_Attachments_Remove,
        MyMod_Handle_Email_Attachments_Rows,
        MyMod_Handle_Email_Attachments_Upload;

    
}

?>