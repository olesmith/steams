<?php

trait MyMod_Handle_Email_Cells
{
    //*
    //* function MyMod_Handle_Email_Cell, Parameter list: $edit,$email,$selected=FALSE,$disabled=FALSE
    //*
    //* Creates table with checkboxes and emails.
    //*

    function MyMod_Handle_Email_Cell($edit,$email,$selected=FALSE,$disabled=FALSE)
    {
       return
           array
           (
               $this->MyMod_Handle_Email_Cell_CheckBox($edit,$email,$selected,$disabled),
               $this->Span
               (
                   strtolower($email[ "Email" ]).";",
                   array
                   (
                       "TITLE" => $email[ "Name" ]." (".$email[ "ID" ].")"
                   )
               )
           );
    }
    
    //*
    //* function MyMod_Handle_Email_Cell_CheckBox, Parameter list: $edit,$email,$selected=FALSE,$disabled=FALSE
    //*
    //* Creates table with checkboxes and emails.
    //*

    function MyMod_Handle_Email_Cell_CheckBox($edit,$email,$selected=FALSE,$disabled=FALSE)
    {
        $check="";
        if ($edit==1)
        {
            $cgi="Inc_".$email[ "ID" ];
            if (!$selected)
            {
                $val=$this->GetPOSTint($cgi);
                if ($val==1) { $selected=TRUE; }
                else         { $selected=FALSE; }
            }

             $check=$this->MakeCheckBox($cgi,1,$selected,$disabled);
        }
        
        return $check;
    }

    //*
    //* function BodyCell , Parameter list: $edit
    //*
    //* Creates body (textarea) cell as table.
    //*

    function MyMod_Handle_Email_Cell_Body($edit)
    {
        $body=$this->MyMod_Handle_Email_CGI_Value("Body");
        $cell="&nbsp;";
        if ($edit==1)
        {
            $cell=
                $this->MakeTextArea("Body",5,78,$body);
        }
        else
        {
            $cell=$body;
        }

        return $this->Span($cell,array("WIDTH" => '75%'));
    }
    
    //*
    //* function  MyMod_Handle_Email_Cell_To, Parameter list: $edit
    //*
    //* To (Recipient) cell.
    //*

    function MyMod_Handle_Email_Cell_To($edit,$emails)
    {
        $rrow=array();
        foreach (array_keys($emails) as $friendkey)
        {
            $table=
                $this->MyMod_Handle_Emails_Table
                (
                    $edit,
                    $emails[ $friendkey ],
                    2,FALSE,FALSE
                );


            $name=$this->ItemsName;
            if ($friendkey!="ID")
            {
                if (!empty($this->ItemData[ $friendkey ][ "PName" ]))
                {
                    $name=$this->ItemData[ $friendkey ][ "PName" ];
                }
                if (!empty($this->ItemData[ $friendkey ][ "Name" ]))
                {
                    $name=$this->ItemData[ $friendkey ][ "Name" ];
                }                
            }

            array_unshift
            (
                $table,
                $this->B($name)
            );
            array_push
            (
                $rrow,
                $this->Htmls_Table
                (
                    "",
                    $table,
                    array(),array(),array(),TRUE,TRUE
                )
            );
        }

        return
            $this->Htmls_Table
            (
                "",
                array($rrow),
                array
                (
                    "ALIGN" => 'left',
                ),
                array(),array(),TRUE,TRUE
            );
    }
    
    //*
    //* function  MyMod_Handle_Email_Cell_CC, Parameter list: $edit
    //*
    //* CC cell.
    //*

    function MyMod_Handle_Email_Cell_CC($edit)
    {
        $mailinfo=$this->ApplicationObj()->MyApp_Mail_Info_Get();
        $emails=array
        (
           array
           (
              "ID" => 0,
              "Email" => $this->ApplicationObj()->MyApp_Mail_Info_Get( "BCCEmail" ),
              "Name" => "Sistema",
           ),
           $this->LoginData
        );

        return
            $this->Htmls_Table
            (
                "",
                $this->MyMod_Handle_Emails_Table
                (
                    $edit,
                    array
                    (
                        array
                        (
                            "ID" => 0,
                            "Email" => $this->ApplicationObj()->MyApp_Mail_Info_Get( "BCCEmail" ),
                            "Name" => "Sistema",
                        ),
                        $this->LoginData
                    ),
                    2,
                    TRUE,TRUE
                ),
                array
                (
                    "ALIGN" => 'left',
                ),
                array(),array(),TRUE,TRUE
            );
    }
    
    //*
    //* function  MyMod_Handle_Email_Cell_Subject, Parameter list: $edit
    //*
    //* Creates subject cell as table.
    //*

    function MyMod_Handle_Email_Cell_Subject($edit)
    {
        $subject=$this->MyMod_Handle_Email_CGI_Value("Subject");
        $cell="";
        if ($edit==1)
        {
            $cell=$this->MakeInput("Subject",$subject,80);
        }
        else
        {
            $cell=$subject;
        }

        return  $this->Span($cell,array("WIDTH" => '75%'));
    }
}

?>