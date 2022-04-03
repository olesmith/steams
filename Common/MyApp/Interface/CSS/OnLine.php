<?php


trait MyApp_Interface_CSS_OnLine
{
    
    //*
    //* sub MyApp_Interface_CSS_Online, Parameter list:
    //*
    //* ReturnsCSS online LINK tags.
    //*
    //*

    function MyApp_Interface_CSS_OnLine()
    {
        $csshtml=array("<!-- Online CSS Start -->");
        foreach ($this->MyApp_Interface_CSS_OnLine_Files_Get() as $cssfile)
        {
            array_push
            (
                $csshtml,
                $this->MyApp_Interface_CSS_OnLine_LINK_Tag($cssfile)
            );
        }
        array_push($csshtml,"<!-- Online CSS End -->");
        return $csshtml;
    }

    //*
    //* sub MyApp_Interface_CSS_LINK_Tag, Parameter list:
    //*
    //* Returns list of (static) file, to be included INLINE.
    //*
    //*

    function MyApp_Interface_CSS_OnLine_LINK_Tag($cssfile)
    {
        return
            $this->HtmlTag
            (
               "LINK",
               "",
               array
               (
                  "REL" => 'stylesheet',
                  "HREF" => $cssfile,
               )
            ).
            "";
    }

    
    //*
    //* sub MyApp_Interface_CSS_OnLine_Files_Get, Parameter list:
    //*
    //* Reads css files from disk and returns code for online insertion.
    //*
    //*

    function MyApp_Interface_CSS_OnLine_Files_Get()
    {
        $cssfiles=array();
        foreach ($this->MyApp_Interface_Head_CSS_OnLine as $cssfile)
        {
            array_push($cssfiles,$cssfile);
        }
        
        $action=$this->CGI_GET("Action");
        $modulename=$this->CGI_GET("ModuleName");

        $css_path=$this->MyApp_Interface_CSS_Path();
        $css_uri=$this->MyApp_Interface_CSS_Uri();
        
        foreach (array_keys($cssfiles) as $cfid)
        {
            $cssfiles[ $cfid ]=$css_uri."/".$cssfiles[ $cfid ];
        }


        $files=array();
        $uris=array();
        
        if (!empty($action))
        {
            $action_file=$action.".css";
            array_push($files,join("/",array($css_path,$action_file)));
            array_push($uris,join("/",array($css_uri,$action_file)));
        }
        
        if (!empty($modulename))
        {
             $module_file=$modulename.".css";
             array_push($files,join("/",array($css_path,$module_file)));
             array_push($uris,join("/",array($css_uri,$module_file)));
                    
             if (!empty($action))
             {
                $action_file=$modulename."/".$action.".css";
                array_push($files,join("/",array($css_path,$action_file)));
                array_push($uris,join("/",array($css_uri,$action_file)));
            }
        }

                
        for ($n=0;$n<count($files);$n++)
        {
            $this->MyFile_Touch($files[ $n ]);
            array_push($cssfiles,$uris[ $n ]);
        }

        if ($this->Module)
        {
            $cssfiles=
                array_merge
                (
                    $cssfiles,
                    $this->Module->MyMod_CSS_OnLine($css_uri)
                );
        }

        if ($this->MyApp_Interface_Mobile_Is())
        {
            array_push
            (
                $cssfiles,
                $css_uri."/"."Mobile.css"
            );
        }

        return $cssfiles;
    }
}

?>