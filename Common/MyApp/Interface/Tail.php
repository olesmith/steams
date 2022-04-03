<?php

trait MyApp_Interface_Tail
{
    //*
    //* sub MyApp_Interface_Cookies_Message, Parameter list:
    //*
    //* Generates and sends the document tail part.
    //*
    //*

    function MyApp_Interface_Tail()
    {
        $this->MyApp_JS_Echo();

        if ($this->DocHeadSend==1 && !$this->MakeCGI_CLI_Is())
        {
            $this->Htmls_Indent_Inc(-$this->Body_Increment);
            echo
                $this->Htmls_Text
                (
                    array
                    (
                        //20201024 $this->Htmls_Tag_Close("DIV","MyApp_Interface_Tail"),
                        $this->MyApp_Interface_Body_End_Comments(),                    

                        $this->Htmls_Comment_Section
                        (
                            "HTML TAIL section",
                            array_merge
                            (
                                $this->MyApp_Interface_Body_End(),
                                $this->Htmls_Tag_Close("HTML")
                            )
                        )
                    )
                );
        }
        elseif (!$this->MakeCGI_CLI_Is())
        {
            $this->Htmls_Echo
            (
                $this->MyApp_Interface_Messages_System()
            );
            
             /* echo */
             /*    $this->Htmls_Text */
             /*    ( */
             /*        array */
             /*        ( */
             /*            //$this->Htmls_Tag_Close("DIV","MyApp_Interface_Tail"), */
             /*        ) */
             /*    ); */
            
        }
    }
    
    //*
    //* sub MyApp_Interface_Cookies_Message, Parameter list:
    //*
    //* Generates cookies info message.
    //*
    //*

    function MyApp_Interface_Cookies_Message()
    {
        return
            array
            (
                "This system uses",
                $this->A('http://www.google.com/search?q=cookies',"Cookies,"),
                "please enable them in you browser!",
            );
    }
    
}

?>