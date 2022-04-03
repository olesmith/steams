<?php

trait MyMod_Handle_Email_Attachments_Cells
{
    //*
    //* function MyMod_Handle_Email_Attachments_Cell_Number, Parameter list: $n
    //*
    //* Creates attachment number cell $n.
    //*

    function MyMod_Handle_Email_Attachments_Cell_Number($n)
    {
        return
            $this->B($n.":",array("ALIGN" => 'center'));
    }

    //*
    //* function MyMod_Handle_Email_Attachments_Cell, Parameter list: $n,$attachment
    //*
    //* Creates attachment number cell $n.
    //*

    function MyMod_Handle_Email_Attachments_Cell($n,$attachment)
    {
        return
            $this->MakeHidden
           (
              $this->MyMod_Handle_Email_Attachments_CGI_No_Name($n),
              $attachment[ "Attachment" ]
           );
    }

    //*
    //* function MyMod_Handle_Email_Attachments_Cell_File, Parameter list: $n,$attachment
    //*
    //* Creates attachment filename cell $n.
    //*

    function MyMod_Handle_Email_Attachments_Cell_File($n,$attachment)
    {
        return
            basename($attachment[ "File" ]).
            $this->MakeHidden
            (
               "File_".$n,
               basename($attachment[ "File" ])
            );
    }
    
    //*
    //* function MyMod_Handle_Email_Attachments_Cell_MIME_Type, Parameter list: $n,$attachment
    //*
    //* Creates attachment filename cell $n.
    //*

    function MyMod_Handle_Email_Attachments_Cell_MIME_Type($n,$attachment)
    {
        return
           " &lt;".
            $attachment[ "MIME" ].
            "&gt;".
           $this->MakeHidden
           (
              "MIME_".$n,
              $attachment[ "MIME" ]
           );
    }

     //*
    //* function MyMod_Handle_Email_Attachments_Cell_Remove, Parameter list: $n
    //*
    //* Creates attachment filename cell $n.
    //*

    function MyMod_Handle_Email_Attachments_Cell_Remove($n)
    {
        return $this->MakeCheckBox("Delete_".$n,1,FALSE);
    }
}

?>