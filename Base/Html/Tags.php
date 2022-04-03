<?php

global $NForms,$NFields;
$NForms=0;
$NFields=0;

class HtmlTags extends Log
{
    var $Icons="icons/";
    
    //*
    //* Returns only opening html tag <$tag options> and appends $contents.
    //*
    //*

    function HtmlTag($tag,$contents="",$options=array(),$closing="")
    {
        if (!empty($contents[ "Text" ]))
        {
            $contents=$contents[ "Text" ];
            if (!empty($contents[ "Options" ]))
            {
                $options=array_merge($options,$contents[ "Options" ]);
            }
        }
        
        if (is_array($contents))
        {
            $contents=join("\n",$contents);
        }

        return 
            "<".strtoupper($tag).
            $this->Htmls_Options_String($options).$closing.">".
            $contents;
    }
    //*
    //* sub HtmlCloseTag, Parameter list: $tag
    //*
    //* Returns only closing html tag </$tag>
    //*
    //*

    function HtmlCloseTag($tag)
    {
        return "</".strtoupper($tag).">";
    }

    //*
    //* Returns matching html tags <$tag>$contents</$tag>
    //*
    //*

    function HtmlTags($tag,$contents="",$options=array())
    {
        $tag=strtoupper($tag);
        if (is_array($contents)) { $contents="\n".join("\n",$contents); }

        return 
            "<".$tag.
            $this->Htmls_Options_String($options).">".
            $contents.
            "</".$tag.">";
    }

    //*
    //* sub HtmlTagList, Parameter list: $list,$tag,$options=array()
    //*
    //* Returns matching html tags of list $list.
    //*
    //*

    function HtmlTagList($list,$tag,$options=array())
    {
        foreach ($list as $id => $item)
        {
            $list[ $id ]=$this->HtmlTags($tag,$item,$options);
        }

        return $list;
    }

    //*
    //* Converts string to ass array.
    //*
    //*

    function Options2Hash($options)
    {
        $options=preg_split('/\s+/',$options);
        $roptions=array();
        foreach ($options as $option)
        {
            $option=preg_replace('/[\'"]/',"",$option);
            $comps=preg_split('/\s*=\s*/',$option);
            if (count($comps)>1)
            {
                $roptions[ $comps[0] ]=$comps[1];
            }
            elseif (count($comps)>1)
            {
                $roptions[ $comps[0] ]="";
            }
        }

        return $roptions;
    }

    //*
    //* Creates Image, IMG
    //* 
    //*

    function IMG($src,$alttext="",$height=0,$width=0,$options=array("BORDER" => "0"))
    {
        $options[ "SRC" ]=$src;
        if (!empty($options[ "ALT" ]))
        {
            $options[ "ALT" ]=$alttext;
        }
        $options[ "BORDER" ]=0;

        if (!empty($height))
        {
            $options[ "HEIGHT" ]=$height;
            //if (!preg_match('/\%$/',$height)) { $options[ "HEIGHT" ].="px"; }
        }
        
        if (!empty($width))
        {
            $options[ "WIDTH" ]=$width;
            //if (!preg_match('/\%$/',$width))  { $options[ "WIDTH" ].="px"; }
        }

        return
            $this->Html_IMG
            (
                $src,
                $alttext,
                $options
            );
    }


    //*
    //* function HRow, Parameter list: $n,$text,$hoptions=array()
    //*
    //* Creates a Header N tag (H2,H3,...).
    //* 
    //*

    function HRow($n,$text,$hoptions=array())
    {
        return array($this->H($n,$text,$hoptions));
    }

    //*
    //* Creates a Header N tag (H2,H3,...).
    //* 
    //*

    function H($n,$text,$options=array())
    {
        if ($this->LatexMode())
        {
            $sizes=array("","huge","LARGE","Large","large","normalsize","footnotesize");
            return "\\begin{center}\\".$sizes[ $n ]."{\\textbf{".$text."}}\\end{center}\n\n";
        }
        else
        {
            return $this->HtmlTags("H".$n,$text,$options);;
        }
    }

    //*
    //* Returns matching html tags <$name>$contents</$name>
    //*

    function DIV($contents,$options=array())
    {
        if (!$this->LatexMode())
        {
            $contents=$this->HtmlTags("DIV",$contents,$options);
        }
        
        return $contents;
    }

    //*
    //* Returns matching html tags <$name>$contents</$name>
    //*

    function SPAN($contents,$options=array())
    {
        if ($this->LatexMode())
        {
            if (is_array($contents)) { $contents=join("\n",$contents); }

            return $contents;
        }
        else
        {
            return $this->HtmlTags("SPAN",$contents,$options);
        }
    }

    //*
    //* Returns matching html tags <$name>$contents</$name>
    //*

    function SPANs($contents,$options=array())
    {
        foreach (array_keys($contents) as $id)
        {
            $contents[ $id ]=$this->SPAN($contents[ $id ],$options);
        }

        return $contents;
    }
    
    //*
    //* Returns matching html tags <$name>$contents</$name>
    //*

    function FONT($contents,$options=array())
    {
        return $this->HtmlTags("FONT",$contents,$options);
    }

    //*
    //* Deprecated!
    //*
    //*

    function CENTER($contents,$options=array())
    {
        return $this->Htmls_Center($contents,$options);
        
        /* if ($this->LatexMode()) */
        /* { */
        /*     return "\\begin{center}\n".$contents."\n\\end{center}"; */
        /* } */
        /* else */
        /* { */
        /*     $options[ "STYLE" ]="text-align: center;"; */
        /*     return */
        /*         $this->Htmls_Center */
        /*         ( */
        /*             $contents,$options */
        /*         ); */
        /* } */
    }

    //*
    //* Creates right justified DIV.
    //*

    function RIGHT($contents,$options=array())
    {
        if ($this->LatexMode())
        {
            return "\\begin{flushright}\n".$contents."\n\\end{flushright}";
        }
        else
        {
            $options[ "STYLE" ]="text-align: right;";
            return $this->HtmlTags("DIV",$contents,$options);
        }
    }

    //*
    //* sub LEFT, Parameter list: $contents,$options=array()
    //*
    //* Creates left justified DIV.
    //*
    //*

    function LEFT($contents,$options=array())
    {
        if ($this->LatexMode())
        {
            return "\\begin{flushright}\n".$contents."\n\\end{flushright}";
        }
        else
        {
            $options[ "STYLE" ]="text-align: left;";
            return $this->HtmlTags("DIV",$contents,$options);
        }
    }

    //*
    //* sub ALIGN, Parameter list: $contents,$align="c",$options=array()
    //*
    //* Creates aligned DIV.
    //*
    //*

    function ALIGN($contents,$align="c",$options=array())
    {
            if ($align=="c") { $align="CENTER"; }
        elseif ($align=="r") { $align="RIGHT"; }
        elseif ($align=="l") { $align="LEFT"; }

        return $this->$align($contents,$options); 
   }

   //*
    //* sub A, Parameter list: $name,$contents,$options=array()
    //*
    //* Returns matching html tags <$name>$contents</$name>
    //*
    //*

    function A($href,$contents="",$options=array())
    {
        if ($this->LatexMode())
        {
            return $contents;
        }
        else
        {
            $options[ "HREF" ]=$href;
            if ($contents=="") { $contents=$href; }
            return $this->HtmlTags("A",$contents,$options);
        }
    }


    function BR($n=1)
    {
        if ($this->LatexMode())
        {
            return "\\\\\n";
        }
        else
        {
            $br=$this->HtmlTag("BR");
            
            $html="";
            for ($i=0;$i<$n;$i++)
            {
                $html.=$br;
            }
            return $html;
        }
    }

    function HR($options=array())
    {
        if ($this->LatexMode())
        {
            return "\n\n";
        }
        else
        {
            return $this->HtmlTag("HR","",$options);
        }
    }

    function B($contents="",$options=array())
    {
        if (is_array($contents))
        {
            $rcontents=array();
            foreach ($contents as $id => $rcontent)
            {
                $rcontents[ $id ]=$this->B($rcontent,$options);
            }

            return $rcontents;
        }
        
        if ($this->LatexMode())
        {
            return "\\textbf{".$contents."}";
        }
        else
        {
            $options[ "Class" ]='Bold';
            return $this->HtmlTags("SPAN",$contents,$options);
        }
    }

    function Head($contents="",$options=array())
    {
        if (is_array($contents))
        {
            $rcontents=array();
            foreach ($contents as $id => $rcontent)
            {
                $rcontents[ $id ]=$this->Head($rcontent,$options);
            }

            return $rcontents;
        }

        if ($this->LatexMode())
        {
            return "\\textbf{".$contents."}";
        }
        else
        {
            $options[ "CLASS" ]='head Bold';
            return $this->Center($this->HtmlTags("SPAN",$contents,$options));
        }
    }


    function I($contents="",$options=array())
    {
        if ($this->LatexMode())
        {
            return "\\textit{".$contents."}";
        }
        else
        {
            $options[ "Class" ]='Italic';
            return $this->HtmlTags("SPAN",$contents,$options);
        }
    }

    function U($contents="",$options=array())
    {
        if ($this->LatexMode())
        {
            return "\\underline{".$contents."}";
        }
        else
        {
            $options[ "Class" ]='Underline';
            return $this->HtmlTags("SPAN",$contents,$options);
        }
    }

    function TextColor($color,$contents="",$options=array())
    {
        if ($this->LatexMode())
        {
            return "\\textcolor{".$color."}{".$contents."}";
        }
        else
        {
            if (is_array($color))
            {
                $options[ "STYLE" ]="color:rgb(".join(",",$color).")";
            }
            else
            {
                $options[ "STYLE" ]="color:".$color;
            }

            return $this->HtmlTags("FONT",$contents,$options);
        }
    }

    function SUB($text,$stext,$options=array())
    {
        if ($this->LatexMode())
        {
            $stext=preg_replace('/,/',"}^{",$stext);
            return $text."\$_{".$stext."}\$";
        }
        else
        {
            return $text.$this->HtmlTags("SUB",$stext,$options);
        }
    }

    function SUP($text,$stext,$options=array())
    {
        if ($this->LatexMode())
        {
            return $text."\$^{".$stext."}\$";
        }
        else
        {
            return $text.$this->HtmlTags("SUP",$stext,$options);
        }
    }

}


?>