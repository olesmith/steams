<?php

trait Htmls_Hide_Boths
{
    //*
    //* 
    //*

    function Htmls_Hide_Button_And_Content($content,$msgkey,$by,$spanid,$shouldhide=False)
    {
        $options=array("ID" => $spanid);
        if ($shouldhide)
        {
            $options[ "STYLE" ]='display: none;';
        }
        return
            array
            (
                $this->Htmls_Hide_Button($msgkey,$spanid,$by,$shouldhide),
                $this->Htmls_Hide_Content($content,$spanid,$by,$shouldhide)
            );
    }
    
    //*
    //* 
    //*

    function MyMod_Handle_Buttons_And_Contents($contents,$by)
    {
        $hbuttons=array();
        $hcontents=array();

        foreach ($contents as $content)
        {
            $shouldhide=True;
            if (isset($content[ "Hide" ]))
            {
                $shouldhide=$content[ "Hide" ];
            }
            if (isset($content[ "Update_key" ]))
            {
                $cgi=$this->CGI_POSTint($content[ "Update_key" ]);
                if ($cgi==1)
                {
                    $shouldhide=False;
                }
            }

            //id or class
            array_push
            (
                $hbuttons,
                $this->Htmls_Hide_Button
                (
                    $content[ "Msg_Key" ],
                    $content[ $by ],
                    $by,
                    $shouldhide
                )
            );
            
            array_push
            (
                $hcontents,
                $this->Htmls_Hide_Content
                (
                    $content[ "Contents" ],
                    $content[ $by ],
                    $by,
                    $shouldhide
                )
            );
        }

        return
            array
            (
                $hbuttons,
                $hcontents
            );
    }
}


?>