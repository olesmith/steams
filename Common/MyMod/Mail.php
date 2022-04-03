<?php

trait MyMod_Mail
{
    
    //*
    //* function MyMod_Mail_Text_Filter, Parameter list: $user,$text
    //*
    //* Sends item typed email. Destination info in $user.
    //* $type_Subject and $type_Body should have languaged
    //* key entries in $item.
    //*

    function  MyMod_Mail_Text_Filter($user,$text)
    {
        $text=$this->FilterHash($text,$this->Unit(),"Unit_");
        $text=$this->FilterHash($text,$user);

        $text=
            preg_replace
            (
                '/#ApplicationName/',
                $this->ApplicationObj()->MyApp_Title(),
                $text
            );
        
        return utf8_encode($text);
    }

    //*
    //* function MyMod_Mail_Type_Get, Parameter list: $type,$user
    //*
    //* Returns mail subject and body.
    //*

    function MyMod_Mail_Type_Get($type,$language)
    {
        $where=
            array
            (
                "Name" => $type,
                "Language" => $language,
                "Unit" => 1,
            );

        return $this->MailTypesObj()->Sql_Select_Hash($where);
    }
    
    //*
    //* function MyMod_Mail_Typed_Send, Parameter list: $type,$user,$item,$hrefs=array()
    //*
    //* Sends item typed email. Destination info in $user.
    //* $type_Subject and $type_Body should have languaged
    //* key entries in $item.
    //*

    function MyMod_Mail_Typed_Send($type,$user,$item,$hrefs=array(),$mailhash=array(),$filters=array())
    {
        foreach ($hrefs as $key => $url)
        {
            $user[ $key ]=preg_replace('/index\.php/',"",$url);
        }

        $language=$this->ApplicationObj()->GetLanguage();

        $mail=$this->MyMod_Mail_Type_Get($type,$language);
        
        $this->ApplicationObj()->MyApp_Email_Send
        (
           $user,
           array_merge
           (
               $mailhash,
               array
               (
                   "Subject" => $this->Html2Text
                   (
                       $this->MyMod_Mail_Text_Filter
                       (
                           $user,
                           $mail[ "Subject" ]
                       )
                   ),
                   "Body"    => $this->Html2Text
                   (
                       $this->MyMod_Mail_Text_Filter
                       (
                           $user,
                           $this->GetRealNameKey($item,"MailHead")."\n\n".
                           $mail[ "Body" ]."\n\n".
                           $this->GetRealNameKey($item,"MailTail").
                           "\n\n"
                       )
                   ),
               )
           ),
           $filters
        );
        
    }

    
    /* To be eradicated!!! */

    
    //Emails stored in DB
    var $MoMod_Module_Emails_DB=array();

    var $MoMod_Module_Emails_Data=array
    (
       "Subject" => array
       (
          "Sql" => "VARCHAR(256)",
          
          "Name"  => "#Type Assunto, #Lang",
          "Name_UK"  => "#Type Subject, #Lang",
          "Title"  => "#Type Assunto, #Lang",
          "Title_UK"  => "#Type Subject, #Lang",
          "Type"  => "",
          "Size" => 50,
          "Compulsory" => 1,
          "Admin" => 2,
          "Person" => 1,
          "Public" => 1,
          "Coordinator" => 2,
       ),
       "Body" => array
       (
          "Sql" => "TEXT",
          
          "Name"  => "#Type Corpo, #Lang",
          "Name_UK"  => "#Type Body, #Lang",
          "Title"  => "#Type Corpo, #Lang",
          "Title_UK"  => "#Type Body, #Lang",

          "Size" => '50x3',
          "Compulsory" => 1,
          "Admin" => 2,
          "Person" => 1,
          "Public" => 1,
          "Coordinator" => 2,
       ),
    );
    
    //*
    //* function MyMod_Mail_Texts_Get, Parameter list: $files=array()
    //*
    //* Initializes mailing, if no.
    //*

    function MyMod_Mail_Texts_Get($files=array())
    {
        if (empty($files))
        {
            $files=array
            (
               "System/".$this->ModuleName."/Mail.Data.php"
            );
        }
        
        $hash=array();
        foreach ($files as $file)
        {
            if (file_exists($file))
            {
                $hash=$this->ReadPHPArray($file,$hash);
            }
        }
        
        return $hash;
    }
    
    //*
    //* function MyMod_Mail_Texts_DB_Read, Parameter list: $files=array()
    //*
    //* Initializes mailing, if no.
    //*

    function MyMod_Mail_Texts_DB_Data_Add()
    {
        foreach ($this->MoMod_Module_Emails_DB as $mailname => $maildef)
        {
            foreach ($this->MoMod_Module_Emails_Data as $data => $def)
            {
                foreach ($this->ApplicationObj()->Languages as $lang => $langdef)
                {
                    $langkey=$langdef[ "Key" ];
                    if (!empty($langkey)) { $langkey="_".$langkey; }
                    
                    $langname=$langdef[ "Name" ];
                    
                    $rdata=$data."_".$lang;
                    $rdef=$def;
                    foreach (array("Name","Title") as $key)
                    {
                        $rdef[ $key ]=preg_replace('/#Lang/',$lang,$rdef[ $key ]);
                        $rdef[ $key ]=preg_replace('/#Type/',$maildef[ "Name".$langkey ],$rdef[ $key ]);
                    }
                }
            }
        }
    }
}

?>