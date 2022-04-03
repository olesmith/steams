<?php

trait MyMod_Handle_Email_CGI
{
    //*
    //* function MyMod_Handle_Email_CGI_Value, Parameter list: 
    //*
    //* Detects mail subject from either CGI (if set) - or $this->MailTexts[ "Form" ].
    //*

    function MyMod_Handle_Email_CGI_Value($field)
    {
        $subject="";
        if (!empty($_POST[ $field ])) { $subject=$this->CGI_POST($field); }

        if (empty($subject))
        {
            if (empty($this->MailTexts))
            {
                $this->MailTexts=$this->FriendsObj()->MyMod_Mail_Texts_Get();
            }

            $subject=$this->GetRealNameKey( $this->MailTexts[ "Emails" ],$field );
            $subject=
                $this->ApplicationObj()->MyEmail_Field_Filter
                (
                    $subject,
                    $this->MailFilters
                );
        }

        return $subject;
    }
}

?>