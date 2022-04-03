<?php


trait MyMod_Icons
{
    var $MyApp_Interface_Icon_Sizes=
        array
        (
            '',
            'fa-lg',
            'fa-2x',
            
            'fa-xs','fa-sm',
            'fa-3x','fa-5x','fa-7x','fa-10x',            
        );
    var $MyApp_Interface_Icon_Size=1;
    
    //*
    //* Inserts icon as I tag.
    //*

    function MyMod_Interface_Icon_Sized($icon,$size="")
    {
        if (empty($size)) { $size=$this->MyApp_Interface_Icon_Size; }

        if (!empty($this->MyApp_Interface_Icon_Sizes[ $size ]))
        {
            $size=$this->MyApp_Interface_Icon_Sizes[ $size ];
        }

        if (is_array($icon))
        {
            foreach (array_keys($icon) as $id)
            {
                $icon[ $id ].=" ".$size;
            }
        }
        else
        {
            $icon.=" ".$size;
        }
        
        return $icon;
    }
    
    //*
    //* Inserts icon as I tag.
    //*

    function MyMod_Interface_Icons($icons,$size="",$options=array())
    {
        foreach (array_keys($icons) as $id)
        {
            if (property_exists($this->ApplicationObj(),$icons[ $id ]))
            {
                $icon=$icons[ $id ];
                $icons[ $id ]=
                    $this->ApplicationObj()->$icon;
            }
            
            $icons[ $id ]=
                $this->MyMod_Interface_Icon
                (
                    $icons[ $id ],
                    $options,
                    $size
                );
        }

        return $icons;
    }
    
    //*
    //* sub MyApp_Interface_Icon, Parameter list: $icon,$options=array()
    //* 
    //* Inserts icon as I tag.
    //*

    function MyMod_Interface_Icon($icon,$options=array(),$size="")
    {
        $icon=
            $this->MyMod_Interface_Icon_Retrieve($icon);

        if (is_array($icon))
        {
            $icons=array();
            foreach (array_keys($icon) as $id)
            {
                array_push
                (
                    $icons,
                    $this->MyMod_Interface_Icon
                    (
                        $icon[ $id ],
                        $options,
                        $size
                    )
                );

                $options[ "data-fa-transform" ]=
                    "shrink-1";
            }

            return
                $this->Htmls_SPAN
                (
                    $icons,
                    array
                    (
                        "CLASS" => "fa-layers fa-fw",
                    )
                );                
        }

        if (!empty($options[ "CLASS" ]))
        {
            if (!is_array($options[ "CLASS" ]))
            {
                $options[ "CLASS" ]=array($options[ "CLASS" ]);
            }
        }
        else
        {
            $options[ "CLASS" ]=array();
        }

        array_push
        (
            $options[ "CLASS" ],
            $this->MyMod_Interface_Icon_Sized($icon,$size),
            "nowrap"
        );

        if (!empty($options[ "COLOR" ]))
        {
            if (empty($options[ "STYLE" ]))
            {
                $options[ "STYLE" ]="";
            }

            if (is_array($options[ "STYLE" ]))
            {
                $options[ "STYLE" ][ "color" ]=$options[ "COLOR" ];
            }
            else
            {
                $options[ "STYLE" ].="color: ".$options[ "COLOR" ].";";
            }
            
            unset($options[ "COLOR" ]);
        }

        return $this->Htmls_Tag_Text("I","",$options);
    }
    
    //* 
    //* If defined as icon in ApplicationObj, reference.
    //* May be list.
    //*

    function MyMod_Interface_Icon_Retrieve($icon)
    {
        if (is_array($icon))
        {
            $icons=$icon;
            foreach (array_keys($icons) as $id)
            {
                $prop=$icons[ $id ];
                if (property_exists($this->ApplicationObj(),$prop))
                {
                    $icons[ $id ]=$this->ApplicationObj()->$prop;
                }
            }

            $icon=$icons;
        }
        else
        {
            if (property_exists($this->ApplicationObj(),$icon))
            {
                $icon=$this->ApplicationObj()->$icon;
            }
        }

        return $icon;
    }

    //*
    //* sub MyApp_Interface_Icon_Link, Parameter list: 
    //* 
    //* Inserts icon as I tag.
    //*

    function MyMod_Interface_Icon_Link($args,$icon,$title,$class,$options=array(),$iconoptions=array(),$size="")
    {
        $options[ "CLASS" ]=$class;

        $rargs=array();
        if (!empty($args[ "Anchor" ]))
        {
            $rargs[ "Anchor" ]=$args[ "Anchor" ];
            $options[ "ID" ]=$args[ "Anchor" ];
            unset($args[ "Anchor" ]);
        }

        return
            $this->Htmls_HRef
            (
                "?".$this->CGI_Hash2Query($args),
                array
                (
                    array
                    (
                        $this->MyMod_Interface_Icon
                        (
                            $icon,
                            $iconoptions,
                            $size
                        )
                    )
                ),
                $title,
                $class,
                $rargs,
                $options
            );
    }
}

?>