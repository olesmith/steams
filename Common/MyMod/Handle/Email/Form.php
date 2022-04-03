<?php

trait MyMod_Handle_Email_Form
{
    //*
    //* function MyMod_Handle_Email_Form, Parameter list: $edit,$where,$friendkeys,$fixedvars
    //*
    //* Creates the form.
    //*

    function MyMod_Handle_Email_Form($edit,$where,$friendkeys,$fixedvars,$search_table=True,$printables_obj=True,$item=array())
    {
        if (!is_array($friendkeys)) { $friendkeys=array($friendkeys); }

        $emails=array();
        if
            (
                !$search_table
                ||
                $this->MyMod_Search_CGI_Vars_Defined_Has()
                ||
                $this->CGI_POSTint("SearchPressed")==1
                ||
                $this->CGI_POSTint("Send")==1
            )
        {
            $emails=$this->MyMod_Handle_Emails_Read($where,$friendkeys);
            
        }

        $attachments=$this->MyMod_Handle_Email_Attachments_CGI_Files();

        $attachment=$this->MyMod_Handle_Email_Attachments_Add_Entry();

        $addedattachment=FALSE;
        $res=FALSE;

        $msgkey="Email_Form_Title";
        if (!empty($attachment))
        {
            array_push($attachments,$attachment);
            $addedattachment=FALSE;
        }
        else
        {
            $del=$this->MyMod_Handle_Email_Attachments_Remove($attachments);

            if (!$del && $this->CGI_POSTint("Send")==1)
            {
                $res=$this->MyMod_Handle_Emails_Send($emails,$printables_obj,$item);
                if ($res)
                {
                    $edit=0;
                    $msgkey="Email_Form_Send_Title";
                }
                else
                {
                    $msgkey="Email_Form_Error_Title";
                }
                
            }
        }
        
        return
            $this->Htmls_Text
            (
                array
                (
                    array
                    (
                        $this->MyMod_Handle_Email_Form_Search
                        (
                            $search_table,
                            $fixedvars
                        ),
                    ),
                    $this->Htmls_Form
                    (
                        $edit,
                        "Emails",
                        $action="",

                        #Contents
                        array
                        (
                            $this->H
                            (
                                2,
                                $this->MyLanguage_GetMessage($msgkey)
                            ),
                            $this->H
                            (
                                5,
                                $this->MyLanguage_GetMessage("Email_Form_BCC_Title")
                            ),
                            $this->MyMod_Handle_Email_Form_Warnings(),
                            $this->MyMod_Handle_Email_Html_Table
                            (
                                $edit,
                                $emails,
                                $attachments,
                                $printables_obj
                            ),
                            $this->MyMod_Search_Hiddens_Fields(),
                        ),
                        $args=array
                        (
                            "Hiddens" => $this->MyMod_Handle_Email_Form_Hiddens($attachments),
                            "Buttons" => array
                            (
                                $this->MakeButton("submit","Enviar"),
                                $this->MakeButton("reset","Resetar"),
                            ),
                        ),
                        $options=array()
                    )
                )
            );
    }

    //*
    //* function MyMod_Handle_Email_Form_Warnings, Parameter list: 
    //*
    //* Hiiden hash.
    //*

    function MyMod_Handle_Email_Form_Warnings()
    {
        $html=array();
        if (count($this->MyMod_Handle_Emails_Warning)>0)
        {
            $html=
                array
                (
                    $this->B("Warnings:"),
                    $this->Htmls_List
                    (
                        $this->MyMod_Handle_Emails_Warning
                    ),
                );
        }

        return $html;
    }
    
    //*
    //* function MyMod_Handle_Email_Form_Hiddens, Parameter list: $attachments 
    //*
    //* Hiiden hash.
    //*

    function MyMod_Handle_Email_Form_Hiddens($attachments)
    {
       return
           array_merge
           (
               $this->MyMod_Search_Hiddens_Hash(),
               array
               (
                   "Send" => 1,
                   $this->MyMod_Search_CGI_Include_All_Key() => $this->MyMod_Search_CGI_Include_All_Value(),
                   $this->MyMod_Handle_Email_Attachments_CGI_N_Name() => count($attachments),
               )
           );
    }

    
    //*
    //* function MyMod_Handle_Email_Form_Search, Parameter list: $fixedvars=array()
    //*
    //* Email oriented search form.
    //*

    function MyMod_Handle_Email_Form_Search($search_table,$fixedvars=array())
    {
        if (!$search_table) { return array(); }
        
        return
            array
            (
                $this->MyMod_Search_Form
                (
                    array("Paging","DataGroups"),
                    "",
                    "Emails", //action
                    array(),
                    $fixedvars
                ),
                $this->BR()
            );
    }

  
}

?>