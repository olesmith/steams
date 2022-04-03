<?php

trait MyMod_Handle_Email_Attachments_Add
{
    //*
    //* function AddAttachmentEntry, Parameter list: 
    //*
    //* If new attachment is defined, attachment.
    //*

    function MyMod_Handle_Email_Attachments_Add_Entry()
    {
        if (
              !empty($_FILES[ $this->MyMod_Handle_Email_Attachments_CGI_Base_Name() ])
              &&
              !empty($_FILES[ $this->MyMod_Handle_Email_Attachments_CGI_Base_Name() ][ 'tmp_name' ])
           )
        {
            $uploadinfo=$_FILES[ $this->MyMod_Handle_Email_Attachments_CGI_Base_Name() ];
            if($this->MyMod_Handle_Email_Attachments_Upload_Test())
            {
                $mimetype=$this->MyMod_Handle_Email_Attachments_File_MIME_Type();
                $name=basename($_FILES[ $this->MyMod_Handle_Email_Attachments_CGI_Base_Name() ]['name' ]);
                $destname=$this->MyMod_Handle_Email_Attachment_File_Move();

                return array
                (
                   "Attachment" => $destname,
                   "File"        => $name,
                   "MIME"        => $mimetype,
                );
            }
            else
            {
                //error
            }

        }

        return array();
    }
}

?>