<?php

include_once("Body/Top.php");
include_once("Body/Middle.php");
include_once("Body/Bottom.php");


trait MyApp_Interface_Body
{
    var $Body_Increment=2;
    
    use
        MyApp_Interface_Body_Top,
        MyApp_Interface_Body_Middle,
        MyApp_Interface_Body_Bottom;
    
    //*
    //* Prints leading interface html:
    //*
    //* Header row, with left, center and right cells.
    //* First middle cll, with Interface lleft (vertical) menu.
    //*
    //*

    function MyApp_Interface_Body_Start()
    {
        if ($this->DocHeadSend!=0) { return; }

        $this->DocHeadSend=1;  
        $this->NoTail=0;
        return
            array
            (
                $this->Htmls_Tag_Start
                (
                    "BODY",
                    $this->Htmls_Comment_Section
                    (
                        "BODY start section, first part",
                        $this->MyApp_Interface_Body_Start_Table()
                    ),
                    array
                    (
                        "ONLOAD" => $this->MyApp_Interface_Body_ONLOAD()
                    )
                ),
                $this->MyApp_Interface_Body_Start_Comments(),
            );
    }

    //*
    //*
    //*

    function MyApp_Interface_Body_Mobile()
    {
        return
            array
            (
                $this->H(1,$this->MyApp_Title()),
                $this->MyApp_Interface_Body_User_Info(),
            );
    }
    
    //*
    //*
    //*

    function MyApp_Interface_Body_User_Info()
    {
        $args=$this->CGI_URI2Hash();
        $args[ "Action" ]="Logoff";

        foreach (array("Login","ModuleName") as $key)
        {
            if (isset($args[ $key ]))
            {
                unset($args[ $key ]);
            }
        }
        
        if (empty($this->LoginData()))
        {
            return array($this->B("Public"));
        }
                
        return
            array
            (
                $this->B("Login:"),
                $this->LoginData("Name"),
                $this->Htmls_A
                (
                    "?".$this->CGI_Hash2URI($args),
                    "Logoff"
                ),
                $this->BR(),
            );
    }
    
    //*
    //*
    //*

    function MyApp_Interface_Body_Start_Table()
    {
        return
            array
            (
                $this->Htmls_Tag_Start
                (
                    "TABLE",
                    array
                    (
                        $this->MyApp_Interface_Body_Top_Row(),
                        $this->MyApp_Interface_Body_Middle_Row_First(),
                    ),
                    array
                    (
                        "CLASS" => 'applicationtable',
                        "WIDTH" => '100%',
                    )
                ),
            );
    }
    
    //*
    //* 
    //*

    function MyApp_Interface_Body_ONLOAD()
    {
        $is_mobile='false';
        if ($this->MyApp_Interface_Mobile_Is())
        {
            $is_mobile='true';
        }

        return "Initialize(".$is_mobile.");";
    }
    
    //*
    //* Generates body start comments (delimiting the handler output)
    //*

    function MyApp_Interface_Body_Start_Comments()
    {
        $comments=array();
        if ($this->MyApp_Module && $this->MyApp_Handler)
        {
            $comments=
                $this->Htmls_Comments
                (
                    "Calling Module ".
                    $this->MyApp_Module.
                    " Handler: ".
                    $this->MyApp_Handler
                );
        }
        elseif ($this->MyApp_Handler)
        {
            $comments=
                $this->Htmls_Comments
                (
                    "Calling Application Handler: ".
                    $this->MyApp_Handler
                );
        }

        return array($comments);
    }
    
    //*
    //* Returns comments for body end comments (delimiting the handler output). 
    //*

    function MyApp_Interface_Body_End_Comments()
    {
        $comments=array();
        if ($this->MyApp_Module && $this->MyApp_Handler)
        {
            $comments=
                $this->Htmls_Comments
                (
                    "Back from Module ".
                    $this->MyApp_Module.
                    " Handler: ".
                    $this->MyApp_Handler
                );
        }
        elseif ($this->MyApp_Handler)
        {
            $comments=
                $this->Htmls_Comments
                (
                    "Back from Application Handler: ".
                    $this->MyApp_Handler
                );
        }

        return array($comments);
    }

    //*
    //* Prints trailing interface html:
    //*
    //* Middle right td cell and bottom row.
    //*
    //*

    function MyApp_Interface_Body_End()
    {
        if ($this->DocHeadSend==1)
        {
            return
                array
                (
                    array
                    (
                        $this->MyApp_Interface_Body_Middle_Row_Last(),
                    ),
                    $this->MyApp_Interface_Body_Bottom_Row(),
                    $this->Htmls_Tag_Close("BODY"),
                );
        }

        return array();
    }

    //*
    //* Print prints some pretext, if defined.
    //*

    function MyApp_Interface_Body_PreText()
    {
        if ($this->Module && !empty($this->Module->PreTextMethod))
        {
            $method=$this->Module->PreTextMethod;
            if (method_exists($this->Module,$method))
            {
                return $this->Module->$method();
            }
            else
            {
                echo "No such Module 'PreTextMethod': ".$method."<BR>";
            }
        }
        elseif (!empty($this->PreTextMethod))
        {
            $method=$this->PreTextMethod;
            if (method_exists($this,$method))
            {
                return $this->$method();
            }
            else
            {
                return "No such Application 'PreTextMethod': ".$method."<BR>";
            }
        }
    }

}

?>