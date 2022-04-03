<?php

trait Htmls_Hide_Buttons
{
    //*
    //* 
    //*

    function Htmls_Hide_Button_Titles($msgkey,$spanid,$shouldhide=False)
    {
        $titles=array();
        if (preg_match('/_(Hide|Show)/',$msgkey))
        {
            $titles=
                array
                (
                    $this->MyLanguage_GetMessage
                    (
                        preg_replace('/_(Hide|Show)/',"_Hide",$msgkey)
                    ),
                    $this->MyLanguage_GetMessage
                    (
                        preg_replace('/_(Hide|Show)/',"_Show",$msgkey)
                    ),
                );
        }
        else
        {
            $message=$this->MyLanguage_GetMessage($msgkey);
            $titles=
                array
                (
                    join
                    (
                        " ",
                        array
                        (
                            $this->MyLanguage_GetMessage("Hide"),
                            $message,
                        )
                    ),
                    join
                    (
                        " ",
                        array
                        (
                            $this->MyLanguage_GetMessage($msgkey),
                            $message,
                        )
                    ),
                );
            
        }

        return
            array
            (
                "Hide" => $titles[0],
                "Show" => $titles[1],
            );
            
    }
    
    //*
    //* 
    //*

    function Htmls_Hide_Button($msgkey,$spanid,$by,$shouldhide=False,$display='inline',$options=array())
    {
        $hideoptions=
            array_merge
            (
                $options,
                array
                (
                    "TYPE" => 'button',
                    "ID" => "On".$spanid,
                    #$by => "On".$spanid,
                )
            );
        
        $unhideoptions=
            array_merge
            (
                $options,
                array
                (
                    "TYPE" => 'button',
                    "ID" => "Off".$spanid,
                    #$by => "Off".$spanid,
                )
            );

        if ($shouldhide)
        {
            $hideoptions[ "STYLE" ]='display: none;';
            $hideoptions[ "onclick" ]=$this->Htmls_Hide_Functions_Hide($spanid,$by);
            
            $unhideoptions[ "STYLE" ]='display: '.$display.';';
            $unhideoptions[ "onclick" ]=$this->Htmls_Hide_Functions_Show($spanid,$by);
         }
        else
        {
            $hideoptions[ "STYLE" ]='display: '.$display.';';
            $hideoptions[ "onclick" ]=$this->Htmls_Hide_Functions_Hide($spanid,$by);
           
            $unhideoptions[ "STYLE" ]='display: none;';
            $unhideoptions[ "onclick" ]=$this->Htmls_Hide_Functions_Show($spanid,$by);
        }
        
        $titles=
            $this->Htmls_Hide_Button_Titles($msgkey,$spanid,$shouldhide);
        
        return
            array
            (
                $this->Htmls_Tag
                (
                    "BUTTON",
                    $titles[ "Hide" ],
                    $hideoptions
                ),
                $this->Htmls_Tag
                (
                    "BUTTON",
                    $titles[ "Show" ],
                    $unhideoptions
                )
            );      
    }
}


?>