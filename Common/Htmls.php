<?php

include_once("Htmls/Tags.php");
include_once("Htmls/Options.php");
include_once("Htmls/Comments.php");
include_once("Htmls/List.php");
include_once("Htmls/Multi.php");
include_once("Htmls/Table.php");
include_once("Htmls/Menues.php");
include_once("Htmls/Form.php");
include_once("Htmls/Inputs.php");
include_once("Htmls/Select.php");
include_once("Htmls/Radios.php");
include_once("Htmls/Anchors.php");
include_once("Htmls/Hrefs.php");
include_once("Htmls/Buttons.php");
include_once("Htmls/Checkbox.php");
include_once("Htmls/Hide.php");
include_once("Htmls/Dynamic.php");
include_once("Htmls/Script.php");

global $Htmls_Indent_Level;
$Htmls_Indent_Level=0;
    
global $Htmls_Indent;
$Htmls_Indent="   ";
    

trait Htmls
{
    use
        Htmls_Tags,
        Htmls_Options,
        Htmls_Comments,
        Htmls_List,
        Htmls_Multi,
        Htmls_Table,
        Htmls_Menues,
        Htmls_Form,
        Htmls_Inputs,
        Htmls_Select,
        Htmls_Radios,
        Htmls_Anchors,
        Htmls_Hrefs,
        Htmls_Buttons,
        Htmls_Checkbox,
        Htmls_Hide,
        Htmls_Dynamic,
        Htmls_Script;

    var $URL_CommonArgs=array();

    var $SCRIPT_Options=
        array
        (
            "TYPE" => 'text/javascript',
            //"DEFER" => 'defer',
            //"STYLE" => 'display: block;',
        );
    
    //*
    //* Increments $Htmls_Indent value $n.
    //*

    function Htmls_Indent_Inc($n)
    {
        global $Htmls_Indent_Level;
        $Htmls_Indent_Level+=$n;
    }
    
    //*
    //* Echos $html calling Htmls_Text.
    //*

    function Htmls_Echo($html)
    {
        echo $this->Htmls_Text($html);
    }
    
    //*
    //* Converts a list of $html to printable text.
    //*

    function Htmls_Text($html,$trailing="\n")
    {
        if (!is_array($html)) { $html=array($html); }
        
        global $Htmls_Indent_Level;
        global $Htmls_Indent;
        
        $text="";
        foreach ($html as $rhtml)
        {
            if (is_array($rhtml))
            {
                $Htmls_Indent_Level++;
                $text.=$this->Htmls_Text($rhtml);
                $Htmls_Indent_Level--;
            }
            else
            {
                $indent="";
                for ($i=0;$i<$Htmls_Indent_Level;$i++)
                {
                    $indent.=$Htmls_Indent;
                }

                $text.=$indent.$rhtml.$trailing;
            }
        }

        return $text;
    }
    
    
    function Htmls_Image_Text($file,$text,$textcolor=array(),$backcolor=array(),$options=array(), $fontsize=3)
    {
        if (!$textcolor || !is_array($textcolor))
        {
            $textcolor=array(0,0,0);
        }
        if (!$backcolor || !is_array($backcolor))
        {
            $backcolor=array(255,255,255);
        }
        
        $hgt=imagefontheight(1.1*$fontsize);
        $wdt=imagefontwidth($fontsize)*strlen($text);
    
        $handle = imagecreate ($wdt+10, $hgt+5);

        $msg="";
        if ($handle)
        {
            $bg_color = imagecolorallocate($handle,
                                           $backcolor[0],
                                           $backcolor[1],
                                           $backcolor[2]);

            $txt_color = imageColorallocate($handle,
                                            $textcolor[0],
                                            $textcolor[1],
                                            $textcolor[2]);

            if (!is_array($backcolor) || count($backcolor)==0)
            {
                imagecolortransparent($handle,$bg_color);
            }

            imagestring($handle,$fontsize,5,0,$text,$txt_color);

            /* $extrapath_pathcorrection=$this->CGI_Script_Extra_Path_Correction(); */
            $this->ApplicationObj()->CGI_Reset_Cwd();

            if (file_exists($this->ApplicationObj()->Temp_Path))
            {
                if (is_dir($this->ApplicationObj()->Temp_Path))
                {
                    if (is_writeable($this->ApplicationObj()->Temp_Path))
                    {
                        $tmpfile=$this->ApplicationObj()->Temp_Path."/".$file;
                        imagepng ($handle,$tmpfile);
                            
                        return
                            $this->Htmls_Tag_Start
                            (
                                "IMG",
                                array(),
                                array_merge
                                (
                                    $options,
                                    array
                                    (
                                        "SRC" => $tmpfile,
                                        #"ALT" => $text
                                    )
                                )
                            );
                    }
                    else
                    {
                        $msg="Not writable";
                    }
                }
                else
                {
                    $msg="Not a directory";
                }
            }
            else
            {
                $msg="Non-existent";
            }
        }
        else { $msg="Unable to create image object"; }
        
        $this->ApplicationObj()->MyApp_Interface_Message_Add
        (
            join
            (
                " ",
                array
                (
                    "Temp_Path:",
                    getcwd(),
                    $this->ApplicationObj()->Temp_Path,
                    $msg
                )
            )
        );
        
        return "Warning!! ".$file.": not found, text: ".$text;
    }

    
    //*
    //*

    function Htmls_Append($html,$append)
    {
        if (is_array($html))
        {
            array_push($html,$append);
        }
        else
        {
            $html.=$append;
        }

        return $html;
    }
}
?>