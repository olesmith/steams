<?php

trait Htmls_Select_Option
{
    //*
    //* Generates options list.
    //*

    function Htmls_Select_Options_Field($n,$value,$values,$valuenames,$titles,$disableds,$selected,$args,$optoptions=array())
    {
        $excludedisableds=$this->Htmls_Select_Args_ExcludeDisableds($args);

        if
            (
                count($values)==1
                ||
                $this->Htmls_Select_Selected_Is($value,$values,$n,$selected)
            )
         {
             $selectedok=TRUE;
             $is_selected=True;
         }

        $disabled=FALSE;
        if
            (
                !empty($disableds[$n])
                ||
                preg_match('/^disabled$/',$values[$n])
            )
        {
            //$values[ $n]="";
            $disabled=TRUE;
        }


        
        $option_field=array();
        if (!$excludedisableds || !$disabled)
        {
            $valuename=
                $this->Htmls_Select_Option_Value_Name
                (
                    $n,$values,$valuenames,$disabled,$args
                );
                
            $option_field=    
                $this->Htmls_Tag
                (
                    "OPTION",
                    $valuename,
                    $this->Htmls_Select_Option_Field_Options
                    (
                        $n,
                        $value,$valuename,
                        $values,$valuenames,$titles,
                        $selected,
                        $disableds,
                        $args,
                        $optoptions
                    )
                );
        }

        return $option_field;
    }
    
     //*
    //* Generates $options hash for each option. 
    //*

    function Htmls_Select_Option_Field_Options($n,$value,$valuename,$values,$valuenames,$titles,$selected,$disableds,$args,$optoptions=array())
    {
        $options=$optoptions;
        if
            (
                count($values)==1
                ||
                $this->Htmls_Select_Selected_Is($value,$values,$n,$selected)
            )
        {
                $options[ "SELECTED" ]="";
                $options[ "CLASS" ]="search_selected";
        }
        
        $class=$this->Htmls_Select_Option_Class($n,$values,$disableds,$args);
        $disabled=$this->Htmls_Select_Option_Disabled($n,$values,$disableds);

        if ($disabled)
        {
            $options[ "DISABLED" ]="";
        }
        
        if (isset($titles[ $n ])) { $options[ "TITLE" ]=$titles[ $n ]; }

        if
            (
                !$this->Htmls_Select_Args_ExcludeDisableds($args)
                ||
                !$disabled
            )
        {
            if (!empty($class))
            {
               $options[ "CLASS" ]=$class; 
            }
            
            if (!$disabled)
            {
                $options[ "VALUE" ]=$values[$n];
            }

            $options[ "TITLE" ]=$n;
            if (!empty($titles[ $n ]))
            {
                $options[ "TITLE" ]=$titles[$n];
            }
            elseif (empty($options[ "TITLE" ]))
            {
                $options[ "TITLE" ]=$values[$n];
            }
        }

        if (empty($options[ "STYLE" ]))
        {
            $options[ "STYLE" ]=array();
        }

        //var_dump($options);
        return $options;
    }
    
    //*
    //* Generates options list.
    //*

    function Htmls_Select_Option_Class($n,$values,$disableds,$args)
    {
        $class=array("search_options");
        if
            (
                $this->Htmls_Select_Option_Disabled
                (
                    $n,
                    $values,
                    $disableds
                )
            )
        {
            $class=array("disabled");
        }

        if
            (
                !empty($args[ "Classes" ])
                &&
                !empty($args[ "Classes" ][ $n ])
            )
        {
            if (!is_array($args[ "Classes" ][ $n ]))
            {
                $args[ "Classes" ][ $n ]=array($args[ "Classes" ][ $n ]);
            }
            
            $class=
                array_merge
                (
                    $class,$args[ "Classes" ][ $n ]
                );
         
        }

        return $class;
    }
    
    //*
    //* Generates options list.
    //*

    function Htmls_Select_Option_Disabled($n,$values,$disableds)
    {
        $disabled=FALSE;
        if
            (
                !empty($disableds[$n])
                ||
                preg_match('/^disabled$/',$values[$n])
            )
        {
           $disabled=TRUE;
        }

        //var_dump($n,$values[ $n ],$disableds);
        return $disabled;
    }
    
    //*
    //* Generates options list.
    //*

    function Htmls_Select_Option_Value_Name($n,$values,$valuenames,$disabled,$args)
    {
        $maxlen=$this->Htmls_Select_Args_MaxLen($args);
        $excludedisableds=$this->Htmls_Select_Args_ExcludeDisableds($args);
        
        $valuename="";
        if (!empty($valuenames[$n]))
        {
            $valuename=$valuenames[$n];
        }

        $valuename=html_entity_decode($valuename,ENT_QUOTES,"UTF-8");
        if ($maxlen>0 && strlen($valuename)>$maxlen)
        {
            $valuename=substr($valuename,0,$maxlen);
        }

            
        if
            (
                !$this->Htmls_Select_Args_ExcludeDisableds($args)
                ||
                !$disabled
            )
        {
            if ($this->Debug>=2)
            {
                $valuename.=" [".$values[$n]."]";
            }
        }        

        return $valuename;
     }
    
    //*
    //* sub Htmls_Select_Option_Title, Parameter list: 
    //*
    //* Genrates option title.
    //*

    function Htmls_Select_Option_Title($titlekey,$item,$namekey="")
    {
        $title="";
        if (preg_match('/#/',$titlekey))
        {
            $title=$this->FilterHash($titlekey,$item);
        }
        elseif (!empty($item[ $titlekey ]))
        {
            $title=$item[ $titlekey ];
        }

        if (empty($title) && !empty($namekey))
        {
            $title=$this->Htmls_Select_Option_Title($namekey,$item);
        }
        
        return $title;
    }
}


?>