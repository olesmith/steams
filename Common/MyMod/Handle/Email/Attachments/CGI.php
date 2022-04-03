<?php

trait MyMod_Handle_Email_Attachments_CGI
{
    //*
    //* Returns list of attachments.
    //*

    function MyMod_Handle_Email_Attachments_CGI_Files()
    {
        $attachments=array();

        for ($n=1;$n<=$this->MyMod_Handle_Email_Attachments_CGI_N_Name();$n++)
        {
            $attachments[ $n ]=
                array
                (
                    "Attachment" => $this->CGI_POSTint("Attachment_".$n),
                    "File"       => $this->CGI_POSTint("File_".$n),
                    "MIME"       => $this->CGI_POSTint("MIME_".$n),
                );
        }

        return $attachments;
    }
    
    //*
    //* Name of attachment cgi key.
    //*

    function MyMod_Handle_Email_Attachments_CGI_Base_Name()
    {
        return "Attachment";
    }
    
    //*
    //* Name of attachment cgi key.
    //*

    function MyMod_Handle_Email_Attachments_CGI_No_Name($n)
    {
        return $this->MyMod_Handle_Email_Attachments_CGI_Base_Name()."_".$n;
    }

    //*
    //* Name of attachment cgi key.
    //*

    function MyMod_Handle_Email_Attachments_CGI_No_Value($n)
    {
        return $this->CGI_POSTint($this->MyMod_Handle_Email_Attachments_CGI_No_Name($n));
    }

    //*
    //* Name of number of attachments cgi key.
    //*

    function MyMod_Handle_Email_Attachments_CGI_N_Name()
    {
        return "N".$this->MyMod_Handle_Email_Attachments_CGI_Base_Name()."s";
    }
    
    //*
    //* Value of numberof  attachment cgi key.
    //*

    function MyMod_Handle_Email_Attachments_CGI_N_Value()
    {
        $cgi_key=$this->MyMod_Handle_Email_Attachments_CGI_N_Name();
        if (!isset($_POST[ $cgi_key ])) { return 0; }

        return $this->CGI_POSTint($cgi_key);
    }
}

?>