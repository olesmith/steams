<?php


trait MyMod_Search_Form
{
    //*
    //* function MyMod_Search_ Form,Parameter list: $omitvars=array(),$title="",$action="",$addvars=array(),$fixedvalues=array(),$module="",$tabmovesdown=""
    //*
    //* Creates search vars table as html form.
    //*

    function MyMod_Search_Form($omitvars=array(),$title="",$action="",$addvars=array(),$fixedvalues=array(),$module="",$tabmovesdown="",$buttons=array())
    {
        if ($this->MyMod_Search_Table_Written) { return ""; }

        if (empty($module)) { $module=$this->MyMod_Search_Table_Module; }

        if (empty($module)) { $module=$this->ModuleName; }

        if (empty($action))
        {
            $action=$this->CGI_GETOrPOST("Action");
        }
        
        if (empty($action)) { $action="Search"; }

        $anchor=preg_replace('/^[^#]+#/',"",$action);
        $action=preg_replace('/#[^#]+$/',"",$action);

        $options=array();
        if (!empty($anchor))
        {
            $options[ "Anchor" ]=$anchor;
        }

        return
            $this->Htmls_Text
            (
                $this->MyMod_Search_Form_List
                (
                    array
                    (
                        "OmitVars" => $omitvars,
                        "Title" => $title,
                        "Action" => $action,
                        "AddVars" => $addvars,
                        "FixedValues" => $fixedvalues,
                        "Module" => $module,
                        "TabMovesDown" => $tabmovesdown,
                        "Buttons" => $buttons,
                    )
                )
            );
     }

    //*
    //* function MyMod_Search_Form_List, Parameter list: $args,$options=array()
    //*
    //* Creates search vars table as html form.
    //*

    function MyMod_Search_Form_List($args,$options=array())
    {
        $omitvars=array();
        if (!empty($args[ "OmitVars" ]))
        {
            $omitvars=$args[ "OmitVars" ];
        }
        
        $title="";
        if (!empty($args[ "Title" ]))
        {
            $title=$args[ "Title" ];
        }

        $action="";
        if (!empty($args[ "Action" ]))
        {
            $action=$args[ "Action" ];
        }

        $addvars=array();
        if (!empty($args[ "AddVars" ]))
        {
            $addvars=$args[ "AddVars" ];
        }

        $fixedvalues=array();
        if (!empty($args[ "FixedValues" ]))
        {
            $fixedvalues=$args[ "FixedValues" ];
        }

        $module=$this->ModuleName;
        if (!empty($args[ "Module" ]))
        {
            $module=$args[ "Module" ];
        }

        $tabmovesdown="";
        if (!empty($args[ "TabMovesDown" ]))
        {
            $tabmovesdown=$args[ "TabMovesDown" ];
        }

        $buttons=array();
        if (!empty($args[ "Buttons" ]))
        {
            $buttons=$args[ "Buttons" ];
        }
        
        if (!empty($args[ "Options" ]))
        {
            $options=$args[ "Options" ];
        }

        return
            array
            (
                $this->Htmls_Comment_Section
                (
                    "Search Form",
                    $this->Htmls_Form
                    (
                        1,
                        $this->MyMod_Handle_Search_Results_Destination_ID("_Form"),
                        "",

                        //$contents=
                        array
                        (
                            $this->MyMod_Search_HTML
                            (
                                $omitvars,
                                $title,
                                $action,
                                $addvars,
                                $fixedvalues,
                                $module,
                                $tabmovesdown,
                                $buttons
                            ),
                            //determines if search button has been pressed
                            $this->MyMod_Search_CGI_Pressed_Hidden(),

                            $this->MyMod_Search_Post_Text,

                        ),
                        #Named parameters
                        //$args=
                        array
                        (
                            "Method"    => 'post',
                            "JS_Static" => True,
                            "Anchor"    =>
                            $this->MyMod_Handle_Search_Results_Destination_ID("_Results"),
                            
                            "Suppress"  => $this->MyMod_Search_Form_Supress($args),
                            "CGI_Args"  =>
                            array_merge
                            (
                                $this->MyMod_Search_Datas_GETs(),
                                array
                                (
                                    "ModuleName" => $module,
                                    "Action" => $action,
                                    "RAW" => 1,
                                    "NoHorMenu" => 1,
                                    "NoSearch" => 1,
                                    //"Search" => 0,
                                    "Dest" =>
                                    $this->MyMod_Handle_Search_Results_Destination_ID("_Results"),
                                )
                            ),
                            "Dest" =>
                            $this->MyMod_Handle_Search_Results_Destination_ID("_Results"),),
                        $options
                    )
                ),
            );
    }

    
    //*
    //* List of CGI vars to suppress in URL.
    //*

    function MyMod_Search_Form_Supress($args)
    {
        $module=$this->ModuleName;
        if (!empty($args[ "Module" ]))
        {
            $module=$args[ "Module" ];
        }

        return
            array_merge
            (
                array
                (
                    "Messages",
                    $module."_NItemsPerPage",
                    $module."_Page",
                    $module."_NoPaging",
                    $module."_TabMovesDown",
                    "Page","Group",
                    "Search",
                ),
                $this->NonGetVars
            );
    }
 }

?>