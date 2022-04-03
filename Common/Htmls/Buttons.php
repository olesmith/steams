<?php

trait Htmls_Buttons
{
    //*
    //* Generates buttons as array html.
    //*
    
    function Htmls_Buttons($submit="",$reset="",$options=array(),$pre=array(),$post=array())
    {
        if (empty($submit))
        {
            $submit=
                $this->MyLanguage_GetMessage("SendButton");
        }
        
        if (empty($reset))
        {
            $reset=$this->MyLanguage_GetMessage("ResetButton");
        }

        
        return
            array
            (
                $this->Htmls_DIV
                (
                    array_merge
                    (
                        $pre,
                        array
                        (
                            $this->Htmls_Button($submit,"submit",$options),
                            $this->Htmls_Button($reset,"reset",$options)
                        ),
                        $post
                    ),
                    array
                    (
                        /* "STYLE" => array */
                        /* ( */
                        /*     'position' => 'sticky', */
                        /*     'bottom'      => 0, */
                        /* ), */
                    )
                )
            );
    }
    //*
    //* Generates one button as array html.
    //*
    
    function Htmls_Button($name,$type="submit",$options=array())
    {
        return
            $this->Html_Input_Button_Make($type,$name,$options);
    }
    
    //*
    //* 
    //*

    function Htmls_Button_Dynamic($id,$url,$icon,$onclick,$title)
    {
        return
            $this->Htmls_Tag
            (
                "BUTTON",
                $this->MyMod_Interface_Icon
                (
                    $icon,
                    array
                    (
                        "COLOR" => 'blue',
                    )
                ),
                array
                (
                    "ID"      => $id,
                    "TITLE"   => $title,
                    "ONCLICK" => $onclick,
                )
            );

    }

    
    //*
    //* Generates one button as array html.
    //*
    
    function Htmls_Button_Load_To_New_Window($title,$url,$options=array())
    {
        if (is_array($title)) { $title=join(" ",$title); }
        
        return
            $this->Htmls_Button
            (
                $title,
                
                "Submit",
                array_merge
                (
                    array
                    (
                        "ONCLICK" => array
                        (
                            $this->JS_Send_Form_URL($url)
                        ),
                    ),
                    $options
                )
            );
    }
    
    //*
    //* Generates one button as a form with send button to send it.
    //*
    
    function Htmls_Button_Form($id,$button_title,$url,$message=array(),$style=array())
    {
        return
            $this->Htmls_Form
            (
                1,
                $id,
                "",

                //$contents=
                $message,

                //$args=
                array
                (
                    "Buttons" => $this->Htmls_Button
                    (
                        $button_title,
                
                        "Submit",
                        array
                        (
                            "ONCLICK" => $this->JS_Send_Form_URL($url),

                            "STYLE" => $style
                        )
                    ),
                    "Hiddens" => array
                    (
                        "Latex" => 1,
                    )                
                )
            );
    }

    
    //*
    //* Generates buttons as array html.
    //*
    
    function Htmls_Buttons_Print($url,$submit="",$reset="",$print="",$options=array(),$pre=array(),$post=array())
    {
        if (empty($submit))
        {
            $submit=
                $this->MyLanguage_GetMessage("SendButton");
        }
        
        if (empty($reset))
        {
            $reset=$this->MyLanguage_GetMessage("ResetButton");
        }

        if (empty($print))
        {
            $print=$this->MyLanguage_GetMessage("PrintButton");
        }

        return
            array
            (
                $this->Htmls_DIV
                (
                    array_merge
                    (
                        $pre,
                        array
                        (
                            $this->Htmls_Button($submit,"submit",$options),
                            $this->Htmls_Button($reset,"reset",$options),
                            $this->Htmls_Button_Print_Cell
                            (
                                $print,$url
                            ),
                        ),
                        $post
                    )
                )
            );
    }

    
    //*
    //* Generates cell for printing
    //*
    
    function Htmls_Button_Print_Cell($print,$url,$options=array(),$style=array())
    {
        if (empty($url))
        {
            $url=$this->CGI_URI2Hash();
        }

        $url[ "Print" ]=1;
        $url[ "Latex" ]=1;

        return
            $this->Htmls_Tag
            (
                "BUTTON",
                $print,

                array
                (
                    "ONCLICK" => $this->JS_Load_URL_2_Window
                    (
                        $url
                    ),
                    "CLASS" => "button is-info",
                )
            );
    }
}


?>