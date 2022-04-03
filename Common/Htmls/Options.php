<?php

trait Htmls_Options
{
    //*
    //* Converts $options to an options string.
    //* As in HTML entities OPTION1='value1',... .
    //*
    //* provides special treatment for CLASS and STYLE.
    //* CLASS may be a list, style a hash.
    //*

    function Htmls_Options_String($options)
    {
        //Start with one to ensure first leading space
        $optionstrings=array("");
        foreach ($options as $option => $value)
        {
            array_push
            (
                $optionstrings,
                $this->Htmls_Option_String($option,$value)
            );
         }

        return join(" ",$optionstrings); 
    }
    
    //*
    //* 
    //*

    function Htmls_Option_String($option,$value)
    {
        $optionstring="";

        $value=
            $this->Htmls_Option_String_Value_Treat($option,$value);

        $option=
            $this->Htmls_Option_String_Option_Treat($option,$value);
        
        if (!is_string($value))
        {
            var_dump("option '$option' value: ",$value,"is not string");     
        }
        elseif (preg_match('/^\s+$/',$option))
        {
            //only white space
            $optionstring.=$value;
        }
        else
        {
            //$value='"'.$value.'"';
            if (empty($value))
            {
                if ($value=="0")
                {
                    $optionstring.=$option."=".$value;
                }
                elseif (!preg_match('/^(CLASS|TITLE)$/i',$option))
                {
                    $optionstring.=$option;
                }
            }
            else
            {
            $value='"'.$value.'"';
                $optionstring.=$option."=".$value;
            }
        }

        return $optionstring;
    }
    
    //*
    //* Treats $value for allowable keys.
    //*

    function Htmls_Option_String_Option_Treat($option,$value)
    {
        return strtolower($option);
    }
    
    //*
    //* Treats $value for allowable keys.
    //*

    function Htmls_Option_String_Value_Treat($option,$value)
    {
        if (preg_match('/^(CLASS)$/i',$option))
        {
            $value=
                $this->Htmls_Option_String_Value_Array($value);
        }
        elseif (preg_match('/^(ID)$/i',$option))
        {
            $value=
                $this->Htmls_Option_String_Value_Array($value,"_");
        }

        
        
        elseif
            (
                preg_match
                (
                    '/^(ONCLICK|ONCHANGE|ONKEYPRESS|TITLE|ONMOUSEOVER|ONMOUSEOUT)$/i',
                    $option
                )
            )
        {
            $value=
                $this->Htmls_Option_String_Value_Text($value);
        }
        
        elseif (preg_match('/^(STYLE)$/i',$option))
        {
            $value=
                $this->Htmls_Option_String_Value_Hash($value);
        }

        return preg_replace('/"/',"",$value);
    }
    
    //*
    //* 
    //*

    function Htmls_Option_String_Value_Text($value)
    {
        return $this->Htmls_Text($value);
    }

    //*
    //* 
    //*

    function Htmls_Option_String_Value_Array($value,$sep=" ")
    {
        if (is_array($value))
        {
            //var_dump($value);
            $value=join($sep,$value);
        }

        return $value;
    }

    
    //*
    //* 
    //*

    function Htmls_Option_String_Value_Hash($value)
    {
        if (is_array($value))
        {
            $values=array();
            foreach ($value as $key => $key_val)
            {
                array_push($values,$key.": ".$key_val.";");
            }

            $value=join(" ",$values);
        }

        return $value;
    }
    
    //*
    //* 
    //*

    function Htmls_Option_Style_Add($key,$value,$options=array())
    {
        if (empty($options[ "STYLE" ]))
        {
            $options[ "STYLE" ]=array();
        }

        $options[ "STYLE" ][ $key ]=$value;

        return $options;
    }
    
    //*
    //* Adds (or overwrite) $options TITLE;
    //*

    function Htmls_Option_Title_Add($title,$options=array())
    {
        $options[ "TITLE" ]=$title;

        return $options;
    }
    //*
    //* 
    //*

    function Htmls_Option_Class_List(&$options,$classes=array())
    {
        if (empty($options[ "CLASS" ]))
        {
            $options[ "CLASS" ]=array();
        }
        elseif (!is_array($options[ "CLASS" ]))
        {
            $options[ "CLASS" ]=array($options[ "CLASS" ]);
        }

        if (!is_array($classes)) { $classes=array($classes); }

        $options[ "CLASS" ]=array_merge($options[ "CLASS" ],$classes);
    }
}
?>