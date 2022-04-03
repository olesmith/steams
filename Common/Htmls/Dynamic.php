<?php

trait Htmls_Dynamic
{
    //*
    //* Creates a dynamic cell. 
    //* 
    //*

    function Htmls_Dynamic_Cell($def)
    {        
        //if (empty($def[ "Title" ])) { $def[ "Title" ]=$def[ "Name" ]; }
        return
            $this->Htmls_Tag
            (
                $def[ "Tag" ],
                $this->Htmls_Dynamic_Cell_Name($def),
                $this->Htmls_Dynamic_Cell_Options($def)
            );
    }
    

    //*
    //* Creates a dynamic cell. 
    //* 
    //*

    function Htmls_Dynamic_Cell_Name($def)
    {
        $name="";
        if (!empty($def[ "Icon" ]))
        {
            if (preg_match('/<IMG/',$def[ "Icon" ]))
            {
                $name=$def[ "Icon" ];
            }
            elseif (preg_match('/^https?/',$def[ "Icon" ]))
            {
                $name=
                    $this->Html_IMG
                    (
                        $def[ "Icon" ],
                        $alttext="external icon",
                        array
                        (
                            "WIDTH" => '20px',
                        )
                    );
            }
            else
            {
                $options=array();
                if (!empty($def[ "Icon_Color" ]))
                {
                    $options[ "STYLE" ]=
                        array
                        (
                            "color" => $def[ "Icon_Color" ]
                        );
                }
                
                $name=
                    $this->MyMod_Interface_Icon
                    (
                        $def[ "Icon" ],
                        $options
                    );
            }
        }
        else
        {
            if ($def[ "Hide" ] && !empty($def[ "Name_Hidden" ]))
            {
                $name=$def[ "Name_Hidden" ];
            }
            elseif (!empty($def[ "Name" ]))
            {
                $name=$def[ "Name" ];
            }
        }

        return $name;
    }
    
    //*
    //* Creates options as array.
    //*

    function Htmls_Dynamic_Cell_Options($def)
    {
        $options=
            array
            (
                "ID"    => $def[ "ID" ],
                "CLASS" => array(),
                "STYLE" => array(),
            );

        foreach
            (
                array
                (
                    "Cell_ID" => "ID",
                    "Class" => "CLASS",
                    "Style" => "STYLE",
                    "Onclick" => "ONCLICK",
                )
                as $key => $value
            )
        {
            $this->Htmls_Dynamic_Cell_Option_Apply($def,$key,$value,$options);
        }

        if (empty($options[ "STYLE" ]))
        {
            $options[ "STYLE" ]=array();
        }
        
        if (!is_array($options[ "CLASS" ]))
        {
            $options[ "CLASS" ]=array($options[ "CLASS" ]);
        }
        
        if (isset($def[ "Color" ]))
        {
            $options[ "STYLE" ][ 'color' ]=$def[ "Color" ];
        }
        
        if (isset($def[ "Opacity" ]))
        {
            $options[ "STYLE" ][ 'opacity' ]=$def[ "Opacity" ];
        }
        
        if (isset($def[ "Back_Color" ]))
        {
            $options[ "STYLE" ][ 'background-color' ]=$def[ "Back_Color" ];
        }

        

        if (!empty($def[ "Hide" ]))
        {
            $options[ "STYLE" ][ "display" ]='none';
            array_push($options[ "CLASS" ],"Hide");
        }
        else
        {
            if (!empty($def[ "Display" ]))
            {
                $options[ "STYLE" ][ "display" ]=$def[ "Display" ];
            }
            
            array_push($options[ "CLASS" ],"Show");
        }
        
        $this->Htmls_Dynamic_Cell_Option_Title
        (
            $def,
            $options
        );

        
        foreach (array("STYLE","ONCLICK") as $key)
        {
            if (empty($options[ $key ])) { unset($options[ $key ]); }
        }
        
        return $options;
    }
    
    //*
    //* Generate specific option - calling method of exists as method.
    //*

    function Htmls_Dynamic_Cell_Option_Value($def,$def_key,$option_key)
    {
        $value="";
        if (!empty($def[ $def_key ]))
        {
             $value=$def[ $def_key ];
            
             $method=$def[ $def_key ];
             if (is_string($method) && method_exists($this,$method))
             {
                 $value=$this->$method($def);
             }
        }

        return $value;
    }

    //*
    //* Generate specific option - calling method of exists as method.
    //*

    function Htmls_Dynamic_Cell_Option_Apply($def,$def_key,$option_key,&$options)
    {
        if (!empty($def[ $def_key ]))
        {
            $value=
                $this->Htmls_Dynamic_Cell_Option_Value
                (
                    $def,$def_key,$option_key
                );

            if (is_array($value))
            {
                if (empty($options[ $option_key ]))
                {
                    $options[ $option_key ]=array();
                }
                
                $options[ $option_key ]=
                    array_merge($options[ $option_key ],$value);
            }
            else
            {
                if (empty($options[ $option_key ]))
                {
                    $options[ $option_key ]="";
                }
                
                $options[ $option_key ].=$value;
            }
        }
    }

    
    //*
    //* Add info to titles
    //*

    function Htmls_Dynamic_Cell_Option_Title($def,&$options)
    {
        $this->Htmls_Dynamic_Cell_Option_Apply
        (
            $def,
            $def_key="Title",
            $option_key="TITLE",
            $options
        );

        
        if
            (
                empty($this->ApplicationObj()->DBHash[ "Debug_Html" ])
                &&
                empty($def[ "Debug" ])
            )
        {
            return;
        }
        
        if (empty($options[ "TITLE" ]))
        {
            $options[ "TITLE" ]="";
        }
        
        if
            (
                empty($this->ApplicationObj()->DBHash[ "Debug_Html" ])
                &&
                empty($def[ "Debug" ])
            )
        {
            return;
        }

        
        if (isset($options[ "TITLE" ]) && is_string($options[ "TITLE" ]))
        {
            if (!empty($options[ "ID" ]))
            {
                $options[ "TITLE" ].=
                    "\n\n".
                    $options[ "ID" ];
            }
            
            if (!empty($options[ "CLASS" ]))
            {
                $options[ "TITLE" ].=
                    "\n\n".
                    join(" ",$options[ "CLASS" ]);
            }
            
            if (!empty($options[ "ONCLICK" ]))
            {
                $options[ "TITLE" ].=
                    "\n\n".
                    $this->Htmls_Text($options[ "ONCLICK" ]);
            }
        }

        $options[ "TITLE" ]=preg_replace('/^\s+/',"",$options[ "TITLE" ]);
        $options[ "TITLE" ]=preg_replace('/\s+$/',"",$options[ "TITLE" ]);
    }
    
    //*
    //* Creates two dynamic cells toogling each otehr. 
    //* 
    //*

    function Htmls_Dynamic_Cells($def)
    {        
        //if (empty($def[ "Title" ])) { $def[ "Title" ]=$def[ "Name" ]; }

        $names=array();
        if (!empty($def[ "Names" ]))
        {
            $names=$def[ "Names" ];
        }

        if (empty($names[0]))
        {
            $names[0]=$this->MyMod_Interface_Icon("fas fa-plus");
        }
        if (empty($names[1]))
        {
            $names[1]=$this->MyMod_Interface_Icon("fas fa-divide");
        }
        
        $options_show=array();
        if (!empty($def[ "Options" ][0]))
        {
            $options_show=$def[ "Options" ][0];
        }
        
        $options_hide=array();
        if (!empty($def[ "Options" ][1]))
        {
            $options_hide=$def[ "Options" ][1];
        }

        $onclick_show=array();
        if (!empty($options_show[ "ONCLICK" ]))
        {
            $onclick_show=$options_show[ "ONCLICK" ];
            if (!is_array($onclick_show))
            {
                $onclick_show=array($onclick_show);
            }
        }
        
        $onclick_hide=array();
        if (!empty($options_hide[ "ONCLICK" ]))
        {
            $onclick_hide=$options_hide[ "ONCLICK" ];
            if (!is_array($onclick_hide))
            {
                $onclick_hide=array($onclick_hide);
            }
        }

        $id=$def[ "ID" ];

        $id_show=$id;
        array_push($id_show,"Show");
        
        $id_hide=$id;
        array_push($id_hide,"Hide");
        
        $options_show[ "ID" ]=$id_show;
        $options_hide[ "ID" ]=$id_hide;
            
        array_push
        (
            $onclick_show,
            $this->JS_Hide_Element_By_ID
            (
                $id_show
            ),
            $this->JS_Show_Element_By_ID
            (
                $id_hide
            )
        );
        
        array_push
        (
            $onclick_hide,
            $this->JS_Hide_Element_By_ID
            (
                $id_hide
            ),
            $this->JS_Show_Element_By_ID
            (
                $id_show
            )
        );
        
        $options_show[ "ONCLICK" ]=$onclick_show;
        $options_hide[ "ONCLICK" ]=$onclick_hide;
            
        return
            array
            (
                $this->Htmls_Tag
                (
                    $def[ "Tag" ],
                    $names[0],
                    $options_show,
                    $def[ "Styles" ][0]
                ),
                $this->Htmls_Tag
                (
                    $def[ "Tag" ],
                    $names[1],
                    $options_hide,
                    $def[ "Styles" ][1]
                ),
            );
    }
    
}
?>