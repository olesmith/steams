<?php

trait MyMod_Handle_Email_Printables
{
    //*
    //* Creates table for emailing items.
    //*

    function MyMod_Handle_Email_Printables($edit,$printables_obj)
    {
        if (!$printables_obj) { return array(); }
        
        $table=array();

        if (is_bool($printables_obj))
        {
            $printables_obj=$this;
        }

        
        $printables_obj->LatexData();

        if (empty($printables_obj->LatexData[ "SingularLatexDocs" ]))
        {
            return array();
        }
        
        $docno=0;
        foreach
            (
                $printables_obj->LatexData[ "SingularLatexDocs" ][ "Docs" ]
                as $doc
            )
        {
            $docno++;
            array_push
            (
                $table,
                $this->MyMod_Handle_Email_Printable($docno,$doc)
            );
        }

        return
            array
            (
                $this->Htmls_Table
                (
                    array
                    (
                        "No.","Doc",
                        $this->MyLanguage_GetMessage("Include"),
                        "PDF",
                    ),
                    $table
                )
            );
    }
    //*
    //* Creates table for emailing items.
    //*

    function MyMod_Handle_Email_Printable($docno,$doc)
    {
        return
            array
            (
                $this->B($docno),
                $doc[ "Name" ],
                $this->Htmls_CheckBox
                (
                    "Include_".$docno,
                    $value=1,
                    $checked=FALSE
                ),
                $this->MyMod_Handle_Prints_Cell
                (
                    "Singular",
                    $docno,$doc
                )
            );
    }
    
    //*
    //* Generate $printables.
    //*

    function MyMod_Handle_Emails_Printables_Generate($item,$printables_obj)
    {
        //Make sure nobody sends their PDF
        $this->ApplicationObj()->Latex_PDF_Send=False;
        
        $pdffiles=
            $printables_obj->MyMod_Item_Prints($item);

        $attachments=array();
        foreach ($pdffiles as $pdffile)
        {
            array_push
            (
                $attachments,
                array
                (
                    "Name"       => basename($pdffile),
                    "File"       => $pdffile,
                    "MIME"       => "pdf",
                )
            );
        }
        
        return $attachments;
    }
 }

?>