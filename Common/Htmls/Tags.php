<?php


trait Htmls_Tags
{
    //*
    //* Tags $html contents with $options;
    //*

    function Htmls_Tag_Start($tag,$html=array(),$options=array(),$style=array())
    {
        if (!empty($style))
        {
            if (empty($options[ "STYLE" ]))
            {
                $options[ "STYLE" ]=array();
            }

            $options[ "STYLE" ]=
                array_merge
                (
                    $options[ "STYLE" ],
                    $style
                );
        }
            
        $starttag=array($this->Html_Tag_Start($tag,$options));
        if (empty($html)) { return $starttag; }
        
        if (!is_array($html)) { $html=array(array($html)); }
        
        return array_merge($starttag,$html);
    }
    
    //*
    //* Tag, returning text.
    //*

    function Htmls_Tag_Text($tag,$html="",$options=array(),$style=array())
    {
        return
            $this->Html_Tag_Start($tag,$options,$style).
            $html.
            $this->Html_Tag_Close($tag);            
    }
    
    //*
    //* Closing html tag.
    //*

    function Htmls_Tag_Close($tag,$comment="")
    {
        if (!empty($comment))
        {
            $comment="<!-- ".$comment." -->";
        }
        
        return
            array
            (
                $this->Html_Tag_Close($tag).$comment
            );
    }
    
    //*
    //* Returns one-line (array) tag.
    //*
    
    function Htmls_Tag_It($tag,$html=array(),$options=array(),$style=array())
    {
        return
            join
            (
                "",
                $this->Htmls_Tag($tag,$html,$options,$style)
            );
    }
    
    //*
    //* Adds list of subtags to $html;
    //*
    //*

    function Htmls_Tag($tag,$html=array(),$options=array(),$style=array())
    {
        return
            array_merge
            (
                $this->Htmls_Tag_Start($tag,$html,$options,$style),
                $this->Htmls_Tag_Close($tag)
            );
    }
    
    //*
    //* Adds tag to list of $htmls.
    //*

    function Htmls_Tag_List($tag,$htmls=array(),$options=array(),$style=array())
    {
        foreach (array_keys($htmls) as $id)
        {
            $htmls[ $id ]=
                $this->Htmls_Tag($tag,array($htmls[ $id ]),$options,$style);
        }

        return $htmls;
    }


    //*
    //* Html HR as list html.
    //*

    function Htmls_HR($width,$options=array(),$style=array())
    {
        return
            $this->Htmls_Tag_Start
            (
                "HR",
                array(),
                array_merge
                (
                    $options,
                    array("WIDTH" => $width)
                ),
                $style
            );
    }
    
    //*
    //* DIV tag as list html
    //*

    function Htmls_DIV($contents,$options=array(),$style=array())
    {
        if ($this->LatexMode()) { return $contents; }

        /* if (!empty($style)) */
        /* { */
        /*     if (empty($options[ "STYLE" ])) */
        /*     { */
        /*         $options[ "STYLE" ]=array(); */
        /*     } */

        /*     $options[ "STYLE" ]= */
        /*         array_merge */
        /*         ( */
        /*             $options[ "STYLE" ], */
        /*             $style */
        /*         ); */
        /* } */

        return $this->Htmls_Tag("DIV",$contents,$options,$style);
    }
    
    //*
    //* SPAN tag as list html
    //*

    function Htmls_SPAN($contents,$options=array(),$style=array())
    {
        if ($this->LatexMode()) { return $contents; }

        
        return $this->Htmls_Tag("SPAN",$contents,$options,$style);
    }
    
    //*
    //* SPAN list with same $options.
    //*

    function Htmls_SPANs($contents,$options=array(),$style=array())
    {
        if ($this->LatexMode()) { return $contents; }
        
        foreach (array_keys($contents) as $id)
        {
            $contents[ $id ]=$this->Htmls_SPAN($contents[ $id ],$options,$style);
        }

        return $contents;
        
    }
    
    //*
    //* sub Htmls_H, Parameter list: $h,$contents,$options=array()
    //*
    //* DIV tag as list html
    //*

    function Htmls_H($h,$contents,$options=array())
    {
        return $this->Htmls_Tag("H".$h,$contents,$options);
    }
    
    //*
    //* Hs tag as list, increasing Hs.
    //*

    function Htmls_Hs($hlevel,$hs,$options=array())
    {
        $html=array();
        foreach ($hs as $h)
        {
            if (!empty($h))
            {
                array_push
                (
                    $html,
                    $this->Htmls_H($hlevel++,$h,$options)
                );
            }
        }
        
        return $html;
    }
    
    //*
    //* A tag as listed html.
    //*

    function Htmls_A($url,$contents,$title="",$options=array())
    {
        if (!empty($title)) { $options[ "TITLE" ]=$title; }
        $options[ "HREF" ]=$url;
        return
            $this->Htmls_Tag
            (
                "A",
                $contents,
                $options
            );
    }

    //*
    //* Puts glue inbetween elements of $list.
    //*

    function Htmls_Join($glue,$list)
    {
        $n=1;
        $nelements=count($list);

        $rlist=array();
        foreach ($list as $item)
        {
            array_push($rlist,$item);
            if ($n<$nelements)
            {
                array_push($rlist,$glue);
            }

            $n++;
        }

        return $rlist;
    }
    
    //*
    //* Returns alignment html keyword.
    //*

    function Htmls_Align_Get($align)
    {
            if ($align=="c") { $align="center"; }
        elseif ($align=="r") { $align="right"; }
        elseif ($align=="l") { $align="left"; }

        return "text-align: ".$align.";";
    }
    
    //*
    //* Creates aligned DIV.
    //*

    function Htmls_Align($contents,$align="c",$options=array())
    {
            if ($align=="c") { $align="center"; }
        elseif ($align=="r") { $align="right"; }
        elseif ($align=="l") { $align="left"; }

        $options[ "STYLE " ]=$this->Htmls_Align_Get($align);
        
        return $this->Htmls_DIV($contents,$options); 
    }

    //*
    //* Adds alignment to $options
    //*

    function Htmls_Align_Style_Add($options=array(),$align="c")
    {
            if ($align=="c") { $align="center"; }
        elseif ($align=="r") { $align="right"; }
        elseif ($align=="l") { $align="left"; }

        return 
            $this->Htmls_Option_Style_Add
            (
                "text-align",
                $align,
                $options
            );
    }

    
    //*
    //* Creates double div $message structure
    //*

    function Htmls_DIVS_Message($message,$class1=array(),$class2=array())
    {
        if (!is_array($class1)) { $class1=array($class1); }
        if (!is_array($class2)) { $class2=array($class2); }

        array_push($class1,'message-body');
        array_push($class2,'message','is-warning');
        
        return
            $this->Htmls_DIV
            (
                $this->Htmls_DIV
                (
                    $message,
                    array
                    (
                        "CLASS" => $class1,
                    )
                ),
                array
                (
                    "CLASS" => $class2,
                )
            );
    }
    
    //*
    //* Creates html center div.
    //*

    function Htmls_Center($html,$options=array())
    {
        if ($this->LatexMode())
        {
            return "\\begin{center}\n".$contents."\n\\end{center}";
        }
        
        $options[ "CLASS" ]='center';
     
        return
            $this->Htmls_DIV($html,$options);
    }
    
    //*
    //* Creates html center div.
    //*

    function Html_Color($color,$html,$options=array())
    {
        $options[ "STYLE" ]=
            array("color" => $color);
            
        if (is_array($html))
        {
            return $this->Htmls_Span($html,$options);
        }

        return $this->SPAN($html,$options);
    }
    
    //*
    //* Creates html center div.
    //*

    function Htmls_BR($list=array(),$br="")
    {
        if ($this->LatexMode())
        {
            return $list;
        }

        if (empty($br)) { $br="<BR>"; }

        $rlist=array();
        $n=0;
        foreach ($list as $item)
        {
            $n++;
            
            array_push($rlist,$item);
            if ($n<count($list))
            {
                array_push($rlist,$br);
            }
        }

        return $rlist;
    }
}
?>