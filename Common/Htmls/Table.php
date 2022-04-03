<?php

// Table generation.

include_once("Table/Frame.php");
include_once("Table/Row.php");
include_once("Table/Cells.php");
include_once("Table/Pad.php");
include_once("Table/Body.php");
include_once("Table/Head.php");

trait Htmls_Table
{
    use
        Htmls_Table_Frame,
        Htmls_Table_Row,
        Htmls_Table_Cells,
        Htmls_Table_Body,
        Htmls_Table_Head,
        Htmls_Table_Pad;
    
    //*
    //* function Htmls_Table, Parameter list: $titles,$rows,$options=array()
    //*
    //* Generates a HTML table.
    //*

    function Htmls_Table($titles,$rows,$options=array(),$troptions=array(),$tdoptions=array(),$evenodd=False,$hover=False)
    {
        if (empty($options[ "ALIGN" ])) { $options[ "ALIGN" ]='center'; }
        if (empty($rows)) { return array(); }
        if (!is_array($rows)) { return array(); }

        if ($this->LatexMode())
        {
            return
                $this->Latex_Table($titles,$rows,$options);
        }

        $evenclass="even";
        $oddclass="odd";
        if (!$evenodd)
        {
            $evenclass="ceven";
            $oddclass="codd";
        }

        $html=
            array_merge
            (
                $this->Htmls_Table_Head
                (
                    $titles,
                    $troptions,$tdoptions
                ),
                $this->Htmls_Table_Body
                (
                    $titles,$rows,
                    $options,$troptions,$tdoptions
                )
            );
        
        $class=array("table");
        if (!empty($options["CLASS"]))
        {
            if (!is_array($options["CLASS"]))
            {
                $options["CLASS"]=array($options["CLASS"]);
            }
            
            $class=array_merge($class,$options["CLASS"]);
        }
        
        $options["CLASS"]=$class;
                
        return
            array
            (
                $this->Htmls_Tag
                (
                    "TABLE",
                    $html,
                    $options
                )
            );
    }


    
    //*
    //* function Htmls_Table_Multi_Cell, Parameter list: $text,$colspan,$align="c",$options=array()
    //*
    //* Generates a multi cell.
    //*

    function Htmls_Table_Multi_Cell($text,$colspan,$align="c",$options=array(),$bold=True)
    {
        if ($bold) { $text=$this->Htmls_Tag("B",$text); }
            
        if (!$this->LatexMode())
        {
            $options[ "COLSPAN" ]=$colspan;

            if (preg_match('/\S/',$align))
            {
                $text=$this->Htmls_Align($text,$align);
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
            $roptions=array
            (
               "COLSPAN" => $colspan,
               "ALIGN" => $align,
            );

            if (!empty($options[ "ROWSPAN" ]))
            {
                $roptions[ "ROWSPAN" ]=$options[ "ROWSPAN" ];
            }

            return array
            (
               "Text"    => $text,
               "Options" => $roptions,
            );
        }
    }
}

?>