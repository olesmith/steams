<?php


trait MyApp_Interface_LeftMenu_Generate_SubMenu_Item
{
    //*
    //* Generates (returns) the Left menu list.
    //*

    function MyApp_Interface_LeftMenu_Generate_SubMenu_Item($submenuitemname,$submenuitem,$item=array())
    {
        $url="";
        if (!empty($submenuitem[ "Href" ])) { $url=$submenuitem[ "Href" ]; }

        $name=
            $this->LanguagesObj()->Language_MenuItem_Name_Get($submenuitemname);
        
        $title=
            $this->LanguagesObj()->Language_MenuItem_Title_Get($submenuitemname);

 
        if
            (
                !$this->MyApp_Interface_LeftMenu_Generate_SubMenu_Inactive_Is
                (
                    $submenuitemname,
                    $submenuitem,
                    $item
                )
            )
        {
            return
                $this->MyApp_Interface_LeftMenu_Generate_SubMenu_Inactive
                (
                    $submenuitemname,
                    $submenuitem,
                    $item
                );
            
        }
        
        $rrurl=$url;
        if (!empty($url))
        {
            if (isset($submenuitem[ "OmitArgs" ]))
            {
                foreach ($submenuitem[ "OmitArgs" ] as $arg)
                {
                    $url=preg_replace('/'.$arg.'=[^\&]*&?/',"",$url);
                }
            }

            $rurl=array();
            if ($this->LanguagesObj()->Message_Debug_Pre_Should())
            {
                $rurl=
                    $this->LanguagesObj()->Message_Debug_Pre
                    (
                        $this->LanguagesObj()->Language_MenuItem_Type,
                        preg_replace('/^\d+_/',"",$submenuitemname)
                    );
            }

            $url=
                $this->Htmls_Span
                (
                    array
                    (
                        $rurl,
                        $this->Htmls_Tag
                        (
                            "A",
                            $name,
                            $this->MyApp_Interface_LeftMenu_Generate_SubMenu_Item_Options
                            (
                                $submenuitemname,$submenuitem,$item
                            )
                        ),
                    ),
                    array("CLASS" => 'nowrap')
                );                    
        }
        else
        {
            $url=
                array
                (
                    $this->Htmls_SPAN
                    (
                        $name,
                        array
                        (
                            "TITLE" => $title,
                        )
                    ),
                );
        }

        return $url;
    }
    
    //*
    //* 
    //*

    function MyApp_Interface_LeftMenu_Generate_SubMenu_Item_Options($submenuitemname,$submenuitem,$item)
    {
        $options=
            array
            (
                "CLASS" => "leftmenulinks nowrap",
                "TITLE" => $this->MyApp_Interface_LeftMenu_Generate_SubMenu_Item_TITLE
                (
                    $submenuitemname,$submenuitem,$item
                )
            );

        if (FALSE)//empty($submenuitem[ "Reload" ]))
        {
            $options=
                array_merge
                (
                    $options,
                    array
                    (
                        "ONCLICK" => $this->MyApp_Interface_LeftMenu_Generate_SubMenu_Item_ONCLICK
                        (
                            $submenuitem,$item
                        ),
                    )
                );
        }
        else
        { 
            $anchor="HorMenu";
            if (isset($submenuitem[ "Anchor" ]))
            {
                $anchor=$submenuitem[ "Anchor" ];
            }
            
            $options=
                array_merge
                (
                    $options,
                    array
                    (
                        "HREF" =>
                        $this->MyApp_Interface_LeftMenu_Generate_SubMenu_Item_URL
                        (
                            $submenuitem,$item
                        ),
                    )
                );
        }

        return $options;
    }
    //*
    //* 
    //*

    function MyApp_Interface_LeftMenu_Generate_SubMenu_Item_TITLE($submenuitemname,$submenuitem,$item)
    {
       return
            $this->LanguagesObj()->Language_MenuItem_Title_Get($submenuitemname).
            /* "\n". */
            /* $this->MyApp_Interface_LeftMenu_Generate_SubMenu_Item_ONCLICK */
            /* ( */
            /*     $submenuitem,$item */
            /* ). */
           "";;
 
    }
    
    //*
    //* 
    //*

    function MyApp_Interface_LeftMenu_Generate_SubMenu_Item_ONCLICK($submenuitem,$item)
    {
        return
            join
            (
                "",
                $this->JS_Function_Call
                (
                    $this->JS_Show_Load,
                    array
                    (
                        $this->MyApp_Interface_LeftMenu_Generate_SubMenu_Item_URL
                        (
                            $submenuitem,$item
                        ),
                        "ModuleCell",
                        "ModuleCell",
                        "initial"
                    )
                )
            );
    }
    
    //*
    //* 
    //*

    function MyApp_Interface_LeftMenu_Generate_SubMenu_Item_URL($submenuitem,$item)
    {
        if (!is_array($submenuitem)) { return $submenuitem; }
        $url="";
        if (!empty($submenuitem[ "Href" ])) { $url=$submenuitem[ "Href" ]; }

        $args=$this->CGI_URI2Hash($url);

        if (empty($submenuitem[ "Reload" ]))
        {
            $args[ "Menu" ]=1;
            $args[ "Search" ]=1;
            //$args=$this->MyMod_CGI_RAW($args,"ModuleCell");
        }
        
        $this->CGI_CommonArgs_Add($args);
        
        if (!empty($url))
        {
            $anchor="HorMenu";
            if (isset($submenuitem[ "Anchor" ]))
            {
                $anchor=$submenuitem[ "Anchor" ];
            }

            
                    
            foreach
                (
                    $this->MyApp_Interface_LeftMenu_Generate_SubMenu_Item_OmitArgs
                    (
                        $submenuitem
                    ) as $arg
                )
            {
                if (!empty($args[ $arg ])) { unset($args[ $arg ]); }                
            }
        }
        
        //$this->CGI_CommonArgs_Add($args);
        
        return
            "?".
            $this->FilterHash
            (
                $this->CGI_Hash2URI($args),
                $item
            );
    }
    
    //*
    //* List of args to commit from def.
    //*

    function MyApp_Interface_LeftMenu_Generate_SubMenu_Item_OmitArgs($submenuitem)
    {
        $omitargs=array();
        if (!empty($submenuitem[ "OmitArgs" ]))
        {
            $omitargs=$submenuitem[ "OmitArgs" ];
        }

        return $omitargs;
    }
    
}

?>