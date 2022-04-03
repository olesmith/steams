<?php

trait MyMod_Handle_Email_Attachments_File
{
    //*
    //* function MyMod_Handle_Email_Attachments_File_MIME_Type, Parameter list:
    //*
    //* Detect upload file MIME type..
    //*

    function MyMod_Handle_Email_Attachments_File_MIME_Type()
    {
        // DO NOT TRUST $_FILES['upfile']['mime'] VALUE !!
        // Check MIME Type.
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        
        return $finfo->file($_FILES[ $this->MyMod_Handle_Email_Attachments_CGI_Base_Name() ]['tmp_name']);
    }

    //*
    //* function AttachmentFileTempName, Parameter list:
    //*
    //* Generate temp name for upload file.
    //*

    function MyMod_Handle_Email_Attachments_File_Tmp_Name()
    {
        return
            sys_get_temp_dir().
            "/".
            getmypid().
            rand();
    }

    //*
    //* function MyMod_Handle_Email_Attachment_File_Move, Parameter list:
    //*
    //* Generate temp name and move upload file.
    //*

    function MyMod_Handle_Email_Attachment_File_Move()
    {
        $srcname=$_FILES[ $this->MyMod_Handle_Email_Attachments_CGI_Base_Name() ]['tmp_name' ];
        $destname=$this->MyMod_Handle_Email_Attachments_File_Tmp_Name();

        move_uploaded_file($srcname,$destname);

        return basename($destname);
    }

}

?>