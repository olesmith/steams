<?php


trait MyApp_JS
{
    var $JS_Fragments=array();
    var $JS_Function_Calls=array();

    //*
    //*
    //* Echoes Java script Fragments and Function_Calls.
    //*

    function MyApp_JS_Echo()
    {
        $this->Htmls_Echo
        (
            array
            (
                //$this->MyApp_JS_PRE(),
                $this->MyApp_JS_SCRIPT(),
            )
        );
    }
    
    //*
    //*
    //* 
    //*

    function MyApp_JS_SCRIPT()
    {
        $scripts=
            array_merge
            (
                $this->MyApp_JS_Function_Calls(),
                $this->MyApp_JS_Function_Load_Call(),
                $this->JS_Fragments
            );

        if (count($scripts)>0)
        {
            $scripts=
                $this->Htmls_SCRIPT
                (
                    $scripts,
                    array
                    (
                        "TYPE" => "text/javascript",
                    )
                );
        }

        return $scripts;        
    }
    
    //*
    //* Load Application.
    //*

    function MyApp_JS_PRE()
    {
        return
            $this->Htmls_Tag
            (
                "PRE",
                array
                (
                    "&lt;SCRIPT&gt;",
                    $this->MyApp_JS_Function_Calls(),
                    $this->MyApp_JS_Function_Load_Call(),
                    $this->JS_Fragments,
                    "&lt;/SCRIPT&gt;",
                )
            );    
    }
    //*
    //* Accumulate JS statements, for outputting from __destruct.
    //*

    function MyApp_JS_Fragment_Add($js)
    {
        if (!is_array($js)) { $js=array($js); }
    
        $this->JS_Fragments=
            array_merge
            (
                $this->JS_Fragments,
                $js
            );
    }
    
    //*
    //*
    //* Load Application.
    //*

    function MyApp_JS_Fragments_SCRIPT()
    {
         return
            $this->Htmls_SCRIPT
            (
                $this->JS_Fragments

            );        
    }
    
    //*
    //* Load Application.
    //*

    function MyApp_JS_Fragments_PRE()
    {
        return
            $this->Htmls_Tag
            (
                "PRE",
                array
                (
                    "&lt;SCRIPT&gt;",
                    $this->JS_Fragments,
                    "&lt;/SCRIPT&gt;",
                )
            );    
    }
    
    //*
    //* 
    //*

    function MyApp_JS_Fragments_Echo()
    {
        
        $this->Htmls_Echo
        (
            array
            (
                "SCRIPT SECTION:",
                $this->MyApp_JS_Fragments_PRE(),
                $this->MyApp_JS_Fragments_SCRIPT(),
            )
        );

        
    }
    
    
    //* Accumulate JS statements, for outputting from __destruct.
    //*

    function MyApp_JS_Function_Call_Add($js)
    {
        if (!is_array($js)) { $js=array($js); }
    
        $this->JS_Function_Calls=
            array_merge
            (
                $this->JS_Function_Calls,
                $js
            );
    }
    
    //*
    //* 
    //*

    function MyApp_JS_Function_Calls_Echo()
    {
        
        $this->Htmls_Echo
        (
            array
            (
                "SCRIPT SECTION 2:",
                $this->MyApp_JS_Function_Calls_PRE(),
                $this->MyApp_JS_Function_Calls_SCRIPT(),
            )
        );

        
    }
    
    //*
    //* 
    //*

    function MyApp_JS_Function_Calls_PRE()
    {
        return
            $this->Htmls_Tag
            (
                "PRE",
                array
                (
                    "&lt;SCRIPT&gt;",
                    $this->MyApp_JS_Function_Calls(),
                    $this->MyApp_JS_Function_Load_Call(),
                    "&lt;/SCRIPT&gt;",
                )
            );    
    }
    
    //*
    //* 
    //*

    function  MyApp_JS_Function_Load_Name()
    {
        return
            join
            (
                "_",
                array
                (
                    "Load",
                    $this->CGI_GET("ModuleName"),
                    $this->CGI_GET("Action"),
                    $this->CGI_GET("ID"),
                )
            );
        
    }
    
    //*
    //* 
    //*

    function  MyApp_JS_Function_Load_Call()
    {
        return
            array
            (
                //'document.addEventListener("DOMContentLoaded",'.
                //$this->MyApp_JS_Function_Load_Name().
                //', false);'
                //$this->MyApp_JS_Function_Load_Name().
                //"();"
            );
        
    }
    
    //*
    //* 
    //*

    function  MyApp_JS_Function_Calls()
    {
        if (empty($this->JS_Function_Calls))
        {
            return array();
        }
        
        $function_name=
            $this->MyApp_JS_Function_Load_Name();
        
        $function_call=
            $this->JS_Function_Define
            (
                $function_name,
                array(),
                $this->JS_Function_Calls
            );


        return
            array_merge
            (
                $function_call,
                array
                (
                    $function_name.'(event);',
                )

            );
    }    
   //*
    //* 
    //*

    function  MyApp_JS_Function_Calls_SCRIPT()
    {
        return
            $this->Htmls_SCRIPT
            (
                array
                (
                    $this->MyApp_JS_Function_Calls(),
                    array
                    (
                        $this->MyApp_JS_Function_Load_Call(),
                    ),
                )
            );
    }    
}


?>