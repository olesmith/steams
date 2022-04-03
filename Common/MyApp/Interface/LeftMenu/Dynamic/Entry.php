<?php


trait MyApp_Interface_LeftMenu_Dynamic_Entry
{
    //*
    //* Generates Dynamic Left menu for list of $items.
    //*

    function MyApp_Interface_LeftMenu_Dynamic_Entry($base,$obj,$item,$action,$href,$cgivar,$name,$title,$class)
    {
        return
            array
            (
                "Tag" => "A",
                "Hide" => False,
                //"Debug" => True,

                "Class" => array($class),
                "ID" => $this->MyApp_Interface_LeftMenu_Dynamic_Entry_ID
                (
                    $base,$obj,$item
                ),
                
                "Name" => array
                (
                    $this->MyApp_Interface_LeftMenu_Dynamic_Add,
                ),
                "Name_Hidden" => array
                (
                    $this->MyApp_Interface_LeftMenu_Dynamic_Sub,
                ),
                       
                "Trailing" => array
                (
                    $this->MyApp_Interface_LeftMenu_Dynamic_Entry_Trailing
                    (
                        $base,$obj,$name,$item,$action,$cgivar,$title
                    ),
                ),
                
                "Title" =>
                $this->MyApp_Interface_LeftMenu_Dynamic_Entry_Title
                (
                    $title,$item
                ),
                
                "Destination" => $this->MyApp_Interface_LeftMenu_Dynamic_Destination_ID
                (
                    $base,$obj,$item,"Dest"
                ),

                
                "Onclick" => $this->MyApp_Interface_LeftMenu_Dynamic_Entry_JS
                (
                    $base,$obj,$item,$action,$href,$cgivar,False
                ),
                "Offclick" => $this->MyApp_Interface_LeftMenu_Dynamic_Entry_JS
                (
                    $base,$obj,$item,$action,$href,$cgivar,False
                ),
            );
    }

    //*
    //* Locate $activeid in $items.
    //*

    function MyApp_Interface_LeftMenu_Dynamic_Entry_Active_Get($items,$activeid)
    {
        if (is_array($activeid))
        {
            $activeid=$activeid[ "ID" ];
        }
        
        return
            $this->MyHash_HashHashes_Find_First
            (
                $items,
                array("ID" => $activeid)
            );
    }
    
    //*
    //* ID  for $item DIV.
    //*

    function MyApp_Interface_LeftMenu_Dynamic_Entry_ID($base,$obj,$item)
    {
        if (!empty($base)) { $base.="_"; }
        
        return
            join
            (
                "_",
                array
                (
                    $base.
                    $obj->ModuleName,
                    $item[ "ID" ]
                )
            );
    }
       
    
    //*
    //* Name to display for $item.
    //*

    function MyApp_Interface_LeftMenu_Dynamic_Entry_Title($name,$item)
    {
        return
            $this->Filter($name,$item);
    }
    
    //*
    //* Name to display for $item.
    //*

    function MyApp_Interface_LeftMenu_Dynamic_Entry_Trailing($base,$obj,$name,$item,$action,$cgivar,$title)
    {
        $name=$this->Filter($name,$item);

        $id=
            $this->MyApp_Interface_LeftMenu_Dynamic_Entry_ID
            (
                $base,$obj,$item
            );

        $show_id=$id."_Show";
        $hide_id=$id."_Hide";
        
        $options=
            array
            (
            );
        
        $hide_options=$options;

        $options[ "STYLE" ]=
            array
            (
                "color" => 'blue',
            );
        $hide_options[ "STYLE" ]=
            array
            (
                "display" => 'none',
                "color" => 'grey',
            );
        
        $options[ "ID" ]=$show_id."_Trailing";
        $hide_options[ "ID" ]=$hide_id."_Trailing";
        
        $options[ "Title"]=
                $this->MyApp_Interface_LeftMenu_Dynamic_Entry_Title
                (
                    $title,$item
                );
                
        if (!empty($action))
        {
            $options[ "ONCLICK" ]=
                array
                (
                    $this->JS_Load_URL_2_Element
                    (
                        $this->MyApp_Interface_LeftMenu_Dynamic_Entry_URL_Dest
                        (
                            $obj,$item,$action,$cgivar
                        ),
                        "ModuleCell"
                    ),
                    $this->JS_Hide_Elements_By_ID
                    (
                        $show_id."_Trailing"
                    ),
                    $this->JS_Show_Elements_By_ID
                    (
                        $hide_id."_Trailing"
                    ),
                    $this->JS_Click_Element_By_ID
                    (
                        $show_id
                    ),
                );
            
            $hide_options[ "ONCLICK" ]=
                array
                (
                    $this->JS_Load_URL_2_Element
                    (
                        $this->MyApp_Interface_LeftMenu_Dynamic_Entry_URL_Dest
                        (
                            $obj,$item,$action,$cgivar
                        ),
                        "ModuleCell"
                    ),
                    $this->JS_Click_Element_By_ID
                    (
                        $hide_id
                    ),
                    $this->JS_Show_Elements_By_ID
                    (
                        $show_id."_Trailing"
                    ),
                    $this->JS_Hide_Elements_By_ID
                    (
                        $hide_id."_Trailing"
                    ),
                );
        }

        //var_dump($options[ "ONCLICK" ],$hide_options[ "ONCLICK" ]);
        
        return
            array
            (
                $this->Htmls_SPAN
                (
                    $this->Filter($name,$item),
                    $options
                ),
                $this->Htmls_SPAN
                (
                    $this->Filter($name,$item),
                    $hide_options
                )
            );
                
    }
   
    //*
    //* ONCLICK  for $item Entry.
    //*

    function MyApp_Interface_LeftMenu_Dynamic_Entry_JS($base,$obj,$item,$action,$href,$cgivar,$load=True)
    {
       $js=
            array
            (
                $this->JS_Load_Once
                (
                    $this->MyApp_Interface_LeftMenu_Dynamic_Entry_URL
                    (
                        $base,$obj,$item,$href,$cgivar
                    ),
                    $this->MyApp_Interface_LeftMenu_Dynamic_Destination_ID
                    (
                        $base,$obj,$item
                    ),
                    $display='initial'
                ),
            );

       if ($load && !empty($action))
       {
           array_push
           (
               $js,
               $this->JS_Load_URL_2_Element
                (
                    $this->MyApp_Interface_LeftMenu_Dynamic_Entry_URL_Dest
                    (
                        $obj,$item,$action,$cgivar
                    ),
                    "ModuleCell"
                )
           );
       }

       return $js;
       
    }
    
    //*
    //* Prefix URL
    //*

    function MyApp_Interface_LeftMenu_Dynamic_Entry_URL_Dest($obj,$item,$action,$cgivar)
    {
        return
            array_merge
            (
                $this->CGI_URI2Hash(),
                array
                (
                    "RAW" => 1,
                    "ModuleName" => $obj->ModuleName,
                    "Action" => $action,
                    $cgivar    => $item[ "ID" ],
                )
            );
    }
    
    //*
    //* Prefix URL
    //*

    function MyApp_Interface_LeftMenu_Dynamic_Entry_URL($base,$obj,$item,$href,$cgivar)
    {
        if (!is_array($href))
        {
            $href=$this->CGI_Query2Hash($href);
        }

        return
            array_merge
            (
                $this->URL_CommonArgs,
                $href,
                array
                (
                    "Action"     => "LeftMenu",
                    "Module"     => $obj->ModuleName,
                    $cgivar    => $item[ "ID" ],
                ),
                $this->MyApp_Interface_LeftMenu_Dynamic_Entry_Args
                (
                    $base,$obj,$item
                )
            );
    }
    
    //*
    //* Function returning CGI arguments to transfer between submenus.
    //* Should be overriden my specific app.
    //*

    function MyApp_Interface_LeftMenu_Dynamic_Entry_Args($base,$obj,$item)
    {
        return array();
    }
}

?>