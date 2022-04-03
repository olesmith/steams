<?php

//v=spf1 include:_spf.kinghost.net -all
trait MyApp_CLI_Mail
{
    //*
    //* Updates counting tables with entries:
    //*
    //* Time Date SQL_Table NEntries
    //*

    function MyApp_CLI_Mail($args)
    {
        if
            (
                count($args)<2
                ||
                !preg_match('/Mail/i',$args[1])
            )
        {
            print "Omitting MyApp_CLI_Mail\n";
            return;
        }

        $texts=array();

        var_dump("Mailing");
        $mailhash=array
            (
                "To" => "ole.ufg@gmail.com",
                "FromEmail" => "root@olesmith.com.br",
                "FromName" =>
                $this->ApplicationObj()->MyApp_Setup_Application_Get_Title(),
                "CC" => array(),
                "BCC" => array(),
                "ReplyTo" => "root@olesmith.com.br",
                "Subject" => "test email",
                "Body" => "test email",
                "AltBody" => "testing",
            );

        $res=
            $this->ApplicationObj->MyApp_Email_Send
            (
                array(),
                $mailhash,
                array()
            );
                    
 
        return $texts;
    }
}

?>