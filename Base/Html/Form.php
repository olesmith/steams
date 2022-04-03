<?php

#include_once("CSS.php");
include_once("Tags.php");
include_once("List.php");
include_once("Table.php");
include_once("Href.php");
include_once("Input.php");

global $NForms,$NFields;
$NForms=0;
$NFields=0;


class HtmlForm extends HtmlInput
{

    //*
    //* function StartForm, Parameter list: $action,$method="post",$fileupload=FALSE,$options=array(),$suppresscgis=array(),$anchor=""
    //*
    //* Creates leading part of a FORM.
    //* 
    //*

    function StartForm($action="",$method="post",$fileupload=FALSE,$options=array(),$suppresscgis=array())
    {
        return
            $this->Htmls_Text
            (
                $this->Htmls_Form_Start
                (
                    "Deprecated",
                    $action,

                    $content=array(),
                    $args=array
                    (
                        "Suppress" => $suppresscgis,
                    ),
                    $options
                )
            );
    }


    //*
    //* function EndForm, Parameter list:
    //*
    //* Creates trailing part of a FORM.
    //* 
    //*

    function EndForm($nohiddens=TRUE)
    {
        $hiddens="";
        if ($nohiddens)
        {
            $hiddens=$this->CGI_MakeHiddenFields();
        }

        return 
            $hiddens.
            $this->HtmlTag("/FORM")."\n";
    }


    //*
    //* function HtmlForm, Parameter list: $contents,$edit=0,$update=array(),$action="",$method="post",$enctype=0,$options=array(),$hiddens=array()
    //*
    //* Creates FORM with $contents.
    //* 
    //*

    function HtmlForm($contents,$edit=0,$update=array(),$action="",$method="post",$enctype=0,$options=array(),$hiddens=array())
    {
        $html="";
        if ($edit==1)
        {
            if (!empty($update))
            {
                $updatevar=$update[ "CGI" ];
                $updatemethod=$update[ "Method" ];
                $args=$update[ "Args" ];

                if (!empty($updatemethod))
                {
                    $this->$updatemethod($args);
                }
            }
            else
            {
                $update[ "CGI" ]="Update";
            }


            $html.=
                $this->StartForm($action,$method,$enctype,$options).
                $this->Buttons();
        }

        $html.=$contents;

        if ($edit==1)
        {
            $html.=
                $this->MakeHidden($update[ "CGI" ],1).
                $this->Buttons().
                $this->EndForm();
        }

        return $html;
    }
}


?>