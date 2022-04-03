<?php

trait MyMod_Handle_Email_Attachments_Upload
{
    //*
    //* function TestAttachmentFile, Parameter list:
    //*
    //* Tests validity of uploaded file.
    //*

    function MyMod_Handle_Email_Attachments_Upload_Test($sizelimit=1000000)
    {
        $file_cgi_name=$this->MyMod_Handle_Email_Attachments_CGI_Base_Name();
        $res=TRUE;
        if (
              !isset($_FILES[ $file_cgi_name ]['error'])
              ||
              is_array($_FILES[ $file_cgi_name ]['error'])
           )
        {
            $this->Message='Invalid parameters.';
            $res=FALSE;
        }

        // Check $_FILES['upfile']['error'] value.
        switch ($_FILES[ $file_cgi_name  ]['error'])
        {
           case UPLOAD_ERR_OK:
               break;
           case UPLOAD_ERR_NO_FILE:
               $this->Message='No file sent.';
               $res=FALSE;
           case UPLOAD_ERR_INI_SIZE:
           case UPLOAD_ERR_FORM_SIZE:
               $this->Message='Exceeded filesize limit.';
               $res=FALSE;
           default:
               $this->Message='Unknown errors.';
               $res=FALSE;
        }

        // You should also check filesize here.
        if ($_FILES[ $file_cgi_name  ]['size'] > $sizelimit)
        {
            $this->Message='Exceeded filesize limit: '.$sizelimit;;
            $res=FALSE;
        }

        return $res;
    }

}

?>