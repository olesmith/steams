<?php

include_once("Select/Args.php");
include_once("Select/Option.php");
include_once("Select/Options.php");


trait Htmls_Select
{
    use
        Htmls_Select_Args,
        Htmls_Select_Option,
        Htmls_Select_Options;
    //*
    //* Creates SELECT input element, list (Htmls) version.
    //*
    //*

    function Htmls_Select($name,$values,$valuenames,$selected="",$args=array(),$select_options=array(),$opt_options=array())
    {
        $this->Htmls_Selected_OK($name);

        return
            $this->Htmls_DIV
            (
                $this->Htmls_Tag
                (
                    "SELECT",
                    $this->Htmls_Select_Options_Fields
                    (
                        $values,$valuenames,
                        $this->Htmls_Select_Args_Titles($args),
                        $selected,
                        $args,
                        $this->Htmls_Select_Args_Option_Options
                        (
                            $args,
                            $opt_options
                        )
                    ),
                    $this->Htmls_Select_Field_Options
                    (
                        $name,
                        $args,
                        $selected,
                        $values,
                        $select_options
                    )
                ),
                $this->Htmls_Select_DIV_Options
                (
                    $name,
                    $args
                )
            );
            
    }
    
        
            
    //*
    //* Returns options to return to SELECT DIV field.
    //*

    function Htmls_Selected_OK($name)
    {
        $selectedok=FALSE;
        if (empty($selected))
        {
            $val=$this->CGI_POST($name);
            if (!empty($val))
            {
                $selected=$val;
            }
        }
       

        if (!$selectedok && !empty($selected) && !is_array($selected))
        {
            $this->AddMsg
            (
                "Warning Htmls_Selected_OK: $name, Value: '$selected' undefined"
            );
            $selectedok=False;
        }

        return $selectedok;
    }
    
    //*
    //* Returns options to return to SELECT DIV field.
    //*

    function Htmls_Select_DIV_Options($name,$args,$options=array())
    {
        $options[ "CLASS" ]="select search_div_field";

        return $options;
    }
    
    //*
    //* Returns options to return to SELECT field.
    //*

    function Htmls_Select_Field_Options_Title($name,$args,$selected,$values,&$options)
    {
        if (!empty($args[ "Title" ]))
        {
            $options[ "TITLE" ]=$args[ "Title" ];
        }
        elseif (!empty($selected))
        {
            $options[ "TITLE" ]=$selected;
        }
        else
        {
            $options[ "TITLE" ]=
                "No".
                ": ".
                count($values).
                "";
        }
    }
    
    //*
    //* Returns options to return to SELECT field.
    //*

    function Htmls_Select_Field_Options($name,$args,$selected,$values,$options)
    {
        $options[ "NAME" ]=$name;

        $this->Htmls_Select_Field_Options_Title
        (
            $name,$args,$selected,$values,
            $options
        );

        #var_dump($options);
        if (!empty($args[ "Multiple" ]))
        {
            $options[ "MULTIPLE" ]=$args[ "Multiple" ];
        }
        
        if (!empty($args[ "OnChange" ]))
        {
            $options[ "ONCHANGE" ]=$args[ "OnChange" ];
        }
    
        if (empty($options[ "ONCHANGE" ]))
        {
            $options[ "ONCHANGE" ]=
                "Mark_Form_On_Input_Change();";
        }
        
        if (!empty($args[ "Options" ]))
        {
            $options=array_merge($options,$args[ "Options" ]);
        }
        
        if (empty($options[ "CLASS" ]))
        {
            $options[ "CLASS" ]="select select_field";
        }

        if (!empty($args[ "Value_Styles" ]) && !empty($selected))
        {
            $options[ "STYLE" ]=$args[ "Value_Styles" ][ $selected ];
        }
        
        return $options;
    }
    
    //*
    //* Determines whether option $n is selected by CGI.
    //*

    function Htmls_Select_Selected_Is($value,$values,$n,$selected="")
    {
        $res=False;
        if (is_array($selected))
        {
            if (!empty($selected[ $value ])) { $res=TRUE; }
        }
        elseif ($selected)
        {
            if
                (
                    preg_match('/^\d+$/',$value)
                    &&
                    preg_match('/^\d+$/',$selected)
                )
            {
                $value=intval($value);
                $rvalue=intval($selected);
                if ($value==$rvalue)
                {
                    $res=TRUE;
                }
            }
            elseif ($value==$selected)
            {
                $res=TRUE;
            }
        }

        return $res;
    }

    //*
    //* HTML select input field from list of items. List version
    //*

    function Htmls_Select_Hashes_Field($fieldname,$items,$args=array(),$selectoptions=array(),$optionsoptions=array())
    {
        $selected=$this->MyHash_Default($args,"Selected",0);
        $namekey=$this->MyHash_Default($args,"Name_Key","Name");
        $titlekey=$this->MyHash_Default($args,"Title_Key","Title");
        $idkey=$this->MyHash_Default($args,"ID_Key","ID");
        $emptytext=$this->MyHash_Default($args,"Empty_Text","");

        if (empty($selectoptions[ "CLASS" ]))
        {
            $selectoptions[ "CLASS" ]=array();
        }
        
        if (!is_array($selectoptions[ "CLASS" ]))
        {
            $selectoptions[ "CLASS" ]=array($selectoptions[ "CLASS" ]);
        }

        array_push($selectoptions[ "CLASS" ],"select select_field");
        
        $optionsoptions[ "VALUE" ]=" 0";
        $optionsoptions[ "CLASS" ]="search_options";
        
        if (empty($selectoptions[ "ONCHANGE" ]))
        {
            $selectoptions[ "ONCHANGE" ]=
                "Mark_Form_On_Input_Change();";
        }
        
        $selects=
            array
            (
                $this->Html_Tags
                (
                    "OPTION",
                    $emptytext,
                    $optionsoptions
                )
            );

        foreach ($items as $rid => $item)
        {
            //Copy of options, preventing mixing option options.
            $roptionsoptions=$optionsoptions;
            
            $id="";
            if (isset($item[ $idkey ]))
            {
                $id=$item[ $idkey ];
            }
            
            $name=
                $this->Htmls_Select_Option_Title($namekey,$item);
            
            $roptionsoptions[ "TITLE" ]=
                $this->Htmls_Select_Option_Title($titlekey,$item,$namekey);
            
            if ($id==$selected)
            {
                $roptionsoptions[ "SELECTED" ]="";
                $roptionsoptions[ "CLASS" ]="selected";
                $selectoptions[ "TITLE" ]=$roptionsoptions[ "TITLE" ];
                $name.="!";
            }

            if (!empty($roptionsoptions[ "VALUE" ]))
            {
                $roptionsoptions[ "VALUE" ]=$id;
            }
            
            if (!empty($item[ "Disabled" ]))
            {
                $roptionsoptions[ "DISABLED" ]=" ";
                $roptionsoptions[ "CLASS" ]= "disabled";
            }

            array_push
            (
                $selects,
                $this->Html_Tags
                (
                   "OPTION",
                   $name,
                   $roptionsoptions
                )
            );
        }
        
        $selectoptions[ "NAME" ]=$fieldname;

        return
            $this->Htmls_DIV
            (
                $this->Htmls_Tag
                (
                    "SELECT",
                    array($selects),
                    $selectoptions
                ),
                array
                (
                    "CLASS" => "select search_div_field"
                )
            );
    }
}


?>