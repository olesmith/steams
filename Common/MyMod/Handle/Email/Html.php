<?php

trait MyMod_Handle_Email_Html
{
    //*
    //* function MyMod_Handle_Email_Html_Table, Parameter list: $edit,$emails,$attachments
    //*
    //* Creates table for emailing items.
    //*

    function MyMod_Handle_Email_Html_Table($edit,$emails,$attachments,$printables)
    {
         return
            $this->Htmls_Table
            (
                "",
                array_merge
                (
                    $this->MyMod_Handle_Email_Html_Mail_Parts_Table($edit,$emails),
                    $this->MyMod_Handle_Email_Printables
                    (
                        $edit,$printables
                    )//,
                    /*     $this->MyMod_Handle_Email_Attachments_Rows($edit,$attachments) */
                ),
                array
                (
                    "ALIGN" => 'center',
                ),
                array(),array(),FALSE,FALSE
            );
    }
    
    //*
    //* function MyMod_Handle_Email_Html_MailParts_Table, Parameter list: $edit,$emails
    //*
    //* Creates table for emailing items.
    //*

    function MyMod_Handle_Email_Html_Mail_Parts_Table($edit,$emails)
    {
        return
            array
            (
               array
               (
                  $this->B("Para:",array("TITLE" => "BCC/CCO")),
                  $this->MyMod_Handle_Email_Cell_To($edit,$emails)
               ),
               array
               (
                  $this->B("CC:"),
                  $this->MyMod_Handle_Email_Cell_CC($edit)
               ),
               array
               (
                  $this->B("De:",array("TITLE" => "Responder para/Reply-to")),
                  $this->LoginData[ "Email" ]
               ),
               array
               (
                  $this->B("Assunto:"),
                  $this->MyMod_Handle_Email_Cell_Subject($edit)
               ),
               array
               (
                  $this->B("Mensagem:"),
                  $this->MyMod_Handle_Email_Cell_Body($edit),
               ),
            );
    }

 }

?>