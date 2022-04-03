<?php

trait MyMod_Handle_Email_Attachments_Rows
{
    //*
    //* function MyMod_Handle_Email_Attachments_Rows, Parameter list: $edit,$attachments 
    //*
    //* Creates rows with attachments.
    //*

    function MyMod_Handle_Email_Attachments_Rows($edit,$attachments)
    {
        $rows=array();
        array_push
        (
           $rows,
           $this->MyMod_Handle_Email_Attachments_Rows_Titles($edit)
        );

        $n=1;
        foreach (array_keys($attachments) as $k)
        {
            array_push
            (
               $rows,
               $this->MyMod_Handle_Email_Attachment_Row($edit,$n,$attachments[ $k ])
            );
            $n++;
        }

        if ($edit==1)
        {
            array_push
            (
               $rows,
               $this->MyMod_Handle_Email_Attachment_Row_New(count($attachments)+1)
            );
        }

        return $rows;
    }
    
    //*
    //* function MyMod_Handle_Email_Attachment_Row, Parameter list: $edit,$n,$attachment
    //*
    //* Creates row with attachment.
    //*

    function MyMod_Handle_Email_Attachment_Row($edit,$n,$attachment)
    {
        $row=array
        (
           $this->MyMod_Handle_Email_Attachments_Cell_Number($n).
           $this->MyMod_Handle_Email_Attachments_Cell($n,$attachment),
           $this->MyMod_Handle_Email_Attachments_Cell_File($n,$attachment),
           $this->MyMod_Handle_Email_Attachments_Cell_MIME_Type($n,$attachment)
        );

        if ($edit==1)
        {
            array_push
            (
               $row,
               $this->MyMod_Handle_Email_Attachments_Cell_Remove($n)
            );
        }

        return $row;
    }
    //*
    //* function MyMod_Handle_Email_Attachments_Titles, Parameter list: $edit
    //*
    //* Creates attachments title row.
    //*

    function MyMod_Handle_Email_Attachments_Rows_Titles($edit)
    {
        $row=array("Anexos","Arquivo","Tipo");
        if ($edit==1)
        {
            array_push
            (
               $row,
               "Remover"
            );
        }

        return array
        (
           "TitleRow" => TRUE,
           "Class" => 'head',
           "Row" => $row,
        );
    }
    
    //*
    //* function MyMod_Handle_Email_Attachment_Row_New, Parameter list: $n
    //*
    //* Creates last/new attachment row.
    //*

    function MyMod_Handle_Email_Attachment_Row_New($n)
    {
        return array
        (
           $this->MyMod_Handle_Email_Attachments_Cell_Number($n),
           $this->MakeFileField($this->MyMod_Handle_Email_Attachments_CGI_Base_Name()),
           "",""
        );
    }
}

?>