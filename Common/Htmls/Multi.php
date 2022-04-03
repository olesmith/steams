<?php

trait Htmls_Multi
{
    //*
    //* Generates a multi column cell.
    //*

    function Htmls_Multi_Cell($text,$colspan,$align="c",$options=array(),$bold=True)
    {
        if ($bold)
        {
            if ($this->LatexMode())
            {
                $text=$this->B($text);
            }
            else
            {
                $options=
                    $this->Htmls_Option_Style_Add
                    (
                        "font-weight",
                        "Bold",
                        $options
                    );
            }
        }
            
        if (!$this->LatexMode())
        {
            $options[ "COLSPAN" ]=$colspan;
            if (empty($options[ "TITLE" ]))
            {
                $options[ "TITLE" ]="";
            }
            //$options[ "TITLE" ].=" ".$colspan." COLS";
            

            if (preg_match('/\S/',$align))
            {
                //$text=$this->Htmls_Align($text,$align);
                $options=
                    $this->Htmls_Align_Style_Add($options,$align);
            }
            
            return array
            (
               "Text" => $text,
               "Options" => $options,
            );
        }
        else
        {
            //Latexmode
            $roptions=
                array
                (
                    "COLSPAN" => $colspan,
                    "ALIGN"   => $align,
                );

            if (!empty($options[ "ROWSPAN" ]))
            {
                $roptions[ "ROWSPAN" ]=$options[ "ROWSPAN" ];
            }

            return
                array
                (
                    "Text"    => $text,
                    "Options" => $roptions,
                );
        }
    }

    
    //*
    //* Generates a multi column cell.
    //*

    function Htmls_Multi_Cells($texts,$colspan,$align="c",$options=array(),$bold=True)
    {
        foreach (array_keys($texts) as $tid)
        {
            $texts[ $tid ]=
                $this->Htmls_Multi_Cell
                (
                    $texts[ $tid ],
                    $colspan,$align,$options,$bold
                );
        }

        return $texts;
    }
}

?>