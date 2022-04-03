<?php

include_once("Email/Read.php");
include_once("Email/CGI.php");
include_once("Email/Cells.php");
include_once("Email/Table.php");
include_once("Email/Html.php");
include_once("Email/Attachments.php");
include_once("Email/Send.php");
include_once("Email/Printables.php");
include_once("Email/Form.php");

trait MyMod_Handle_Email
{
    use
        MyMod_Handle_Email_Read,
        MyMod_Handle_Email_CGI,
        MyMod_Handle_Email_Cells,
        MyMod_Handle_Email_Table,
        MyMod_Handle_Email_Html,
        MyMod_Handle_Email_Attachments,
        MyMod_Handle_Email_Send,
        MyMod_Handle_Email_Printables,
        MyMod_Handle_Email_Form;
    
    var $MailFilters=array();
    
    //*
    //* function MyMod_Handle_Email_Friend_Keys, Parameter list: 
    //*
    //* Sql where.
    //*

    function MyMod_Handle_Email_Friend_Keys()
    {
        return array("Friend");
    }
    //*
    //* function MyMod_Handle_Email_Where, Parameter list: 
    //*
    //* Sql where.
    //*

    function MyMod_Handle_Email_Where()
    {
        $where=array();
        if (!preg_match('/^(Admin|Coordinator)$/',$this->Profile()))
        {
            $where[ "ID" ]=-1;
        }
        
        return $where;
    }

    //*
    //* function MyMod_Handle_Email_Fixed, Parameter list: 
    //*
    //* Fixed values.
    //*

    function MyMod_Handle_Email_Fixed()
    {
        return $this->MyMod_Handle_Email_Where();
    }

    
    //*
    //* function MyMod_Handle_Email, Parameter list: 
    //*
    //* Handles form for emailing items.
    //*

    function MyMod_Handle_Email()
    {
        echo
            $this->Htmls_Text
            (
                $this->MyMod_Handle_Email_Form
                (
                    1,
                    $this->MyMod_Handle_Email_Where(),
                    $this->MyMod_Handle_Email_Friend_Keys(),
                    $this->MyMod_Handle_Email_Fixed()                    
                )
            );
    }


  
}

?>