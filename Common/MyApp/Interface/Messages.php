<?php

global $HtmlMessages; //global and common for all classes
$HtmlMessages=array();
    

trait MyApp_Interface_Messages
{
#    var $HtmlStatusMessages=array();

    //*
    //* sub MyApp_Interface_ExecTime, Parameter list: 
    //*
    //* Returns exectime, if initialized.
    //*

    function MyApp_Interface_ExecTime()
    {
        if (isset($this->ExecMTime))
        {
            return
                $this->B("Module Exec Time: ").
                 $this->ExecMTime."<BR>";
        }

        return "";
   }

    //*
    //* sub MyApp_Interface_Status, Parameter list: 
    //*
    //* Returns exectime, if initialized.
    //*

    function MyApp_Interface_Status()
    {
        global $HtmlMessages;
        if (!empty($this->Auth_Message))
        {
            array_push($HtmlMessages,$this->Auth_Message);
        }
     

        $status="Status: OK";
        $options=array();
        if (!empty($HtmlMessages))
        {
            $class="errors";
            $status="Erro!";
            $options=array("CLASS" => $class);
        }
        
        return 
            "<BR>".
            $status.
            $this->HtmlList($HtmlMessages);
    }

    //*
    //* sub MyApp_Interface_Messages_Get, Parameter list: $msg
    //*
    //* returns HtmlStatusMessages.
    //*
    //*

    function MyApp_Interface_Messages_Get()
    {
        global $HtmlMessages;
        return $HtmlMessages;
    }
    
    //*
    //* sub MyApp_Interface_Message_Add, Parameter list: $msg
    //*
    //* Adds a message to HtmlStatusMessages.
    //*
    //*

    function MyApp_Interface_Message_Add($msg)
    {
        global $HtmlMessages;
        if (!is_array($msg)) { $msg=array($msg); }
        
        $HtmlMessages=array_merge($HtmlMessages,$msg);
    }

    //*
    //* sub PrintStatusMessage, Parameter list: $msg
    //*
    //* Prints message - and adds to HtmlStatusMessages.
    //*
    //*

    function PrintStatusMessage($msg)
    {
        $this->MyApp_Interface_Message_Add($msg);
        echo
            $this->Div($msg,array("CLASS" => "diagnostics"));
    }


    
    //*
    //* sub MyApp_Interface_Messages_System, Parameter list:
    //*
    //* Prints table of gathered System messages.
    //*
    //*

    function MyApp_Interface_Messages_System()
    {
        global $HtmlMessages;

        $text=array(); 
        if (count($HtmlMessages)>0)
        {
            $table=array();
            for ($n=0;$n<count($HtmlMessages);$n++)
            {
                array_push($table,array($n+1,$HtmlMessages[ $n ]));
            }

            $text=
                $this->Htmls_DIV
                (
                    array
                    (
                        $this->H(4,"Mensagens gerado durante a execução:"),
                        $this->HTMLs_Table("",$table),
                    ),
                    array
                    (
                        "ID"    => "CONSOLE1",
                        "CLASS" => 'messages'
                    )
                );
        }

        return $text;
    }
}

?>