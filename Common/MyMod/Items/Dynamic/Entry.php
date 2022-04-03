<?php


trait MyMod_Items_Dynamic_Entry
{
    //*
    //* An empty $dynamics cells.
    //*

    function MyMod_Item_Dynamic_Entry_Empty($item,$group,$action)
    {
        return
            array
            (
                "Empty" => True,
            );
    }
    
    //*
    //* Generate the $dynamics cells.
    //*

    function MyMod_Item_Dynamic_Entry($item,$group,$action,$def)
    {
        $entry=
            array
            (
                "Tag" => "SPAN",
                "Hide" => False,
                
                "ID" => $this->MyMod_Item_Dynamic_Entry_ID
                (
                    $item,$group,$action
                ),
                
                "Icon" => $this->MyMod_Item_Dynamic_Entry_Icon($def,$item),
                "Title" => $this->MyMod_Item_Dynamic_Entry_Title($def,$item),
                
                "Onclick" => "MyMod_Item_Dynamic_Entry_JS",
                
                "Destination" =>
                $this->MyMod_Item_Dynamic_Destination_Cell_ID
                (
                    $item,$group,$action
                ),
                "Class" => 'dynbutton',
            );

        if (!empty($def[ "Icon_Color" ]))
        {
            $entry[ "Color" ]=$def[ "Icon_Color" ];
        }
        
        if (!empty($def[ "Icon_Opacity" ]))
        {
            $entry[ "Opacity" ]=$def[ "Icon_Opacity" ];
        }

        return $entry;
    }
    
    //*
    //* Generate the $dynamics cells.
    //*

    function MyMod_Item_Dynamic_Entry_Title($def,$item)
    {
        $moduleobj=
            $def[ "Module" ]."Obj";

        return
            $this->$moduleobj()->MyActions_Entry_Title
            (
                $def[ "Action" ],$item
            );            
    }

    //*
    //* 
    //*

    function MyMod_Item_Dynamic_Entry_JS($action,$is_hide_cell)
    {
        if ($is_hide_cell)
        {
            return
                $this->MyMod_Item_Dynamic_Entry_JS_Hide($action);
        }
        else
        {
            return
                $this->MyMod_Item_Dynamic_Entry_JS_Show($action);
        }
    }
    //*
    //* 
    //*

    function MyMod_Item_Dynamic_Entry_JS_Hide($action)
    {
        return
            array
            (
                //Display destination row TR
                $this->JS_Hide_Elements_By_ID
                (
                    $this->MyMod_Item_Dynamic_Destination_Row_ID
                    (
                        $this->Item
                    )
                )
            );
    }
    //*
    //* 
    //*

    function MyMod_Item_Dynamic_Entry_JS_Show($action)
    {
        $def=$this->Defs[ $action ];

        $url=
            $this->MyMod_Item_Dynamic_Entry_Url
            (
                $this->Item,
                $action,
                $def
            );


        return
            array
            (
                "//Hide all destination cells.",
                $this->JS_Hide_Elements_By_ID
                (
                    $this->MyMod_Item_Dynamic_Destination_Cell_IDs
                    (
                        $this->Item,
                        $this->Group,
                        $action
                    )                    
                ),

                $this->MyMod_Item_Dynamic_Entry_JS_Load($action),

                
                "//Make Display destination row TR visible",
                $this->JS_Show_Elements_By_ID
                (
                    $this->MyMod_Item_Dynamic_Destination_Row_ID
                    (
                        $this->Item
                    ),
                    $display="table-row"
                ),
            );
    }

    //*
    //* 
    //*

    function MyMod_Item_Dynamic_Entry_JS_Load($action)
    {
        $def=$this->Defs[ $action ];

        $url=
            $this->MyMod_Item_Dynamic_Entry_Url
            (
                $this->Item,
                $action,
                $def
            );
        
        $js=array();
        if (!empty($def[ "Content" ]))
        {
            $js=
                array
                (
                    $this->JS_Load_URL_2_Window
                    (
                        $url,
                        "_blank"
                    ),
                );            
        }
        else
        {
            $js=
                array
                (
                    $this->JS_Load_URL_2_Element
                    (
                        $url,
                        $this->MyMod_Item_Dynamic_Destination_Cell_ID
                        (
                            $this->Item,
                            $this->Group,
                            $action
                        ),
                        $this->MyMod_Item_Dynamic_Entry_Load_Group($action),
                        0//debug-level
                    ),
                );
        }

        return $js;
    }
    
    //*
    //* 
    //*

    function MyMod_Item_Dynamic_Entry_Load_Group($action)
    {
        return
            join
            (
                "",
                array
                (
                    $this->ModuleName,
                    $action,
                    $this->Item[ "ID" ],
                )
            );
    }
    //*
    //* 
    //*

    function MyMod_Item_Dynamic_Entry_Url($item,$action,$def)
    {
        $raction=
            $this->MyMod_Item_Dynamic_Action_Allowed
            (
                $this->Group,
                $this->Defs[ $action ],
                $this->Item
            );

        //var_dump("$action: $raction");
        return
            "?".
            $this->CGI_Hash2URI
            (
                array_merge
                (
                    array
                    (
                        //"Links"      => $this->CGI_GETint("Links"),
                        "ModuleName" => $def[ "Module" ],
                        "Action"     => $raction,
                        "RAW"        => 1,
                        "NoHorMenu"  => 1,
                        "NoSearch"   => 1,
                        "Dest"       =>
                        $this->MyMod_Item_Dynamic_Destination_Cell_ID
                        (
                            $item,
                            $this->Group,
                            $action
                        ),
                    ),
                    $this->MyMod_Item_Dynamic_Entry_Args($item,$action,$def)
                )
            );
    }   
    //*
    //* 
    //*

    function MyMod_Item_Dynamic_Entry_Args($item,$action,$def)
    {
        $args=$def[ "Args" ];

        $this->ApplicationObj()->CGI_CommonArgs_Add($args);

        foreach ($def[ "GETs" ] as $data)
        {
            if (!empty($item[ $data ]))
            {
                $args[ $data ]=$item[ $data ];
            }
            elseif ( ($value=$this->CGI_GETint($data))>0)
            {
                $args[ $data ]=$value;
            }
        }

        if (!empty($def[ "Hash" ]))
        {
            foreach ($def[ "Hash" ] as $data => $rdata)
            {
                if (!empty($item[ $rdata ]))
                {
                    $args[ $data ]=$item[ $rdata ];
                }
                elseif ( ($value=$this->CGI_GETint($rdata))>0)
                {
                    $args[ $data ]=$value;
                }
            }
        }        
        

        return $args;
    }

    
    //*
    //* The ID (with Show/Hide) of the $action element.
    //*

    function MyMod_Item_Dynamic_Entry_Element_ID($group,$action,$is_hide_cell,$item)
    {
        $id="Show";
        if ($is_hide_cell) { $id="Hide"; }
        
        $element_id="";
        if
            (
                !empty
                (
                    $this->Defs[ $action ]
                )
                &&
                $this->MyMod_Item_Dynamic_Action_Allowed
                (
                    $group,
                    $this->Defs[ $action ],
                    $item
                )
            )
        {
            $element_id=
                $this->MyMod_Item_Dynamic_Entry_ID
                (
                    $item,
                    $group,
                    $action
                ).
                "_".
                $id;
        }

        return $element_id;
    }

}

?>