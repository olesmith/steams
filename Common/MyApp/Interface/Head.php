<?php

include_once("Head/Styles.php");
include_once("Head/Scripts.php");
include_once("Head/Metas.php");
include_once("Head/Links.php");

trait MyApp_Interface_Head
{
    use
        MyApp_Interface_Head_Styles,
        MyApp_Interface_Head_Scripts,
        MyApp_Interface_Head_Metas,
        MyApp_Interface_Head_Links;

    var $__MyApp_Interface_Mobile__=False;
    var $__MyApp_Interface_Mobile_Regexps__=
        array
        (
            'Android',
            'Mobile;',
        );
    
    //*
    //* return interface head left cell.
    //*

    function MyApp_Interface_Mobile_Is()
    {
        return
            $this->__MyApp_Interface_Mobile__
            &&
            (
                preg_match
                (
                    '/\b('.
                    join
                    (
                        "|",
                        $this->__MyApp_Interface_Mobile_Regexps__
                    ).
                    ')/i',
                    $_SERVER[ "HTTP_USER_AGENT" ]
                )
                ||
                $this->CGI_GET("Mobile")==1
            );
    }
    
    //*
    //* Returns nothing - override.
    //*

    function MyApp_Interface_Banner()
    {
        return array();
    }
    
    //*
    //* Sends http header then prints application head part.
    //*

    function MyApp_Interface_Head()
    {
        if (!$this->MyApp_Interface_RAW_Is())
        {            
            $this->Htmls_Echo
            (
                array
                (
                    $this->MyApp_Interface_Header(),
                    $this->MyApp_Interface_Body_Start(),
                    $this->MyApp_Interface_Banner(), //top banner
                )
            );

            $this->Htmls_Indent_Inc($this->Body_Increment);
        }
        elseif (empty($_GET[ "NoHTML" ]))
        {
            $style="";
            if (!empty($args[ "Margin" ]))
            {
                $style=
                    " CLASS='SUBSCR'";
            }

            $hash=$this->CGI_URI2Hash();
            $url="?".$this->CGI_Hash2URI($hash);

            unset($hash[ "Dest" ]);
            unset($hash[ "NoHorMenu" ]);
            
            $rurl="?".$this->CGI_Hash2URI($hash);

        

            $html=
                array
                (
                    $this->MyApp_Interface_No_Dest(),
                    "   <DIV".$style.">",
                );

            array_push
            (
                $html,
                $this->MyApp_Interface_Banner()
            );
            
            if
                (
                    !empty($_GET[ "Reload_Parent" ])
                    &&
                    $this->CGI_GETint("Reload_Parent")==1
                )
            {
                array_push
                (
                    $html,
                    $this->Htmls_DIV
                    (
                        array
                        (
                            $this->MyLanguage_GetMessage("Update"),
                            $this->MyMod_ItemsName()
                        ),
                        array
                        (
                            "STYLE" => array
                            (
                                "color" => 'orange',
                                "text-align" => 'center',
                                "font-size" => 'large',
                            ),
                            "ONCLICK" =>
                            array
                            (
                                $this->JS_Click_Parent_Element_By_Class
                                (
                                    $this->CGI_GET("Dest"),
                                    "Reload"
                                ),
                            )
                        )
                    )                    
                );
            }
            else
            {
                array_push
                (
                    $html,
                    $this->Htmls_DIV
                    (
                        array
                        (
                            $this->MyApp_Interface_Reload_Icon(),
                            $this->MyTime_HHMMSS(),
                        ),
                        array
                        (
                            "CLASS" => array
                            (
                                "Reload_DIV",
                                $this->CGI_GET("Dest"),
                            ),
                            "TITLE" =>
                            array
                            (
                                $this->MyLanguage_GetMessage
                                (
                                    "Reload","Title"
                                ).".\n\n",
                                $url,
                                $this->CGI_GET("Dest"),
                            ),
                            "STYLE" => array
                            (
                                'font-size'  => 'smaller',
                                'text-align' => 'left',
                                'color'      => 'black',
                                'display' => 'block',
                            ),
                        )
                    )
                );
            }
            
            
            foreach (array("NoHorMenu","Dest") as $data)
            {
                if (!empty($args[ $data ]))
                {
                    unset($args[ $data ]);
                }
            }

            $this->Htmls_Echo($html);
        }
    }

    //*
    //* Create reload Icon
    //*

    function MyApp_Interface_Reload_URL()
    {
        $url=$this->CGI_URI2Hash();

        return $url;
    }
    
    //*
    //* Create reload Icon
    //*

    function MyApp_Interface_Clip_Board_URL()
    {
        $url=$this->CGI_URI2Hash();

        foreach (array("Dest","RAW","NoHorMenu") as $key)
        {
            if (isset($url[ $key ]))
            {
                unset($url[ $key ]);
            }
        }
        
        $url=$this->CGI_Hash2URI($url);
        
        return
            $this->CGI_Script_Full_Path().
            "?".
            $url;
    }
    
    //*
    //* Create reload Icon
    //*

    function MyApp_Interface_Reload_Destination()
    {
        $url=$this->CGI_URI2Hash();
        $dest="ModuleCell";
        if (!empty($url[ "Dest" ]))
        {
            $dest=$url[ "Dest" ];
        }

        return $dest;
    }
    
    //*
    //* Create reload Icon
    //*

    function MyApp_Interface_Reload_Icon()
    {
        $url=$this->CGI_URI2Hash();

        $dest="ModuleCell";
        if (!empty($url[ "Dest" ]))
        {
            $dest=$url[ "Dest" ];
        }
        
        return
            $this->Htmls_SPAN
            (
                $this->MyMod_Interface_Icon("fas fa-sync"),
                array
                (
                    "CLASS" => "Reload",
                    
                    "ONCLICK" =>
                    array
                    (
                        $this->JS_Reload_URL_2_Element
                        (
                            $this->MyApp_Interface_Reload_URL(),
                            $this->MyApp_Interface_Reload_Destination(),
                            ""
                        ),
                        $this->JS_Clip_Board_Copy_URL
                        (
                            $this->MyApp_Interface_Clip_Board_URL()
                        ),
                    )
                    
                )
            );
    }
    
    //*
    //* 
    //*

    function MyApp_Interface_No_Dest()
    {
        $head=array();
        if (empty($_GET[ "Dest" ]))
        {
            $head=$this->MyApp_Interface_Header();
        }
        
        return $head;
    }
    
    //*
    //* Detects whether we are RAW.
    //*

    function MyApp_Interface_RAW_Is()
    {
        $res=False;
        if (isset($_GET[ "RAW" ]))
        {
            if (!empty($_GET[ "RAW" ])) { $res=True; }
        }
        
        return $res;
    }
    
    //*
    //* sub MyApp_Interface_HEAD_Tag, Parameter list:
    //*
    //* HEAD tag with contents.
    //*
    //*

    function MyApp_Interface_HEAD_Tag()
    {
        return
            array_merge
            (
                $this->Htmls_Comment_Section
                (
                    "HTML HEAD section",
                    $this->Htmls_Tag
                    (
                        "HEAD",
                        array
                        (
                            $this->MyApp_Interface_METAs(),
                            $this->MyApp_Interface_Title(),
                            $this->MyApp_Interface_LINKs(),
                            $this->MyApp_Interface_STYLEs(),
                            $this->MyApp_Interface_SCRIPTs()
                        )
                    )
                )
            );
    }

    
    //*
    //* sub MyApp_Interface_HTML_Tag, Parameter list:
    //*
    //* HTML tag with contents.
    //*
    //*

    function MyApp_Interface_HTML_Tag()
    {
        return
            $this->Htmls_Tag_Start
            (
                "HTML",
                array
                (
                    $this->MyApp_Interface_HEAD_Tag(),
                )
            );
     }
    
    //*
    //* sub MyApp_Interface_Header, Parameter list:
    //*
    //* Sends the HTML header part.
    //*
    //*

    function MyApp_Interface_Header()
    {
        //Printed promptly!
        $this->MyApp_Interface_Headers_Send();

        return
            array_merge
            (
                $this->MyApp_Interface_DocType(),
                $this->MyApp_Interface_HTML_Tag()
            );
    }
    
    
    //*
    //* sub MyApp_Interface_DocType, Parameter list:
    //*
    //* Sends 'before HTML tag' doc type.
    //*
    //*

    function MyApp_Interface_DocType()
    {
        return
            array
            (
                $this->MyApp_Interface_Head_DocType
            );
    }
    
    
    //*
    //* sub MyApp_Interface_, Parameter list:
    //*
    //* Returns interface header <TITLE>...</TITLE> section.
    //*
    //*

    function MyApp_Interface_Title()
    {
        return
            array
            (
                $this->HtmlTags("TITLE",$this->MyApp_Interface_HEAD_TITLE())
            );
    }
    
   

    //*
    //* sub MyApp_Interface_HEAD_Title, Parameter list:
    //*
    //* Returns title to include as HTML TITLE.
    //*
    //*

    function MyApp_Interface_HEAD_Title()
    {
        $id=$this->GetGET("ID");

        $vals=array($this->CGI_GET("Action"));
        if ($this->Module)
        {
            if ($id!="" && $id>0)
            {
                array_push($vals,$this->Module->ItemName);
            }
            else
            {
                array_push($vals,$this->Module->ItemsName);
            }
        }

        foreach ($this->ExtraPathVars as $id => $var)
        {
            if ($this->$var!="")
            {
                array_push($vals,$this->$var);
            }
        }

        $title=$this->MyApp_Title()."::";
        
        $action=$this->MyActions_Detect();
        if ($this->Module)
        {
            if (!empty($action) && isset($this->Module->Actions[ $action ]))
            {
                $action=$this->GetRealNameKey($this->Module->Actions[ $action ],"Name");

                $action=preg_replace('/#ItemsName/',$this->Module->ItemsName,$action);
                $action=preg_replace('/#ItemName/',$this->Module->ItemsName,$action);
                $id=$this->GetGET("ID");
                if ($id!="" && $id>0)
                {
                    $name=$this->Module->MyMod_Item_Name_Get($this->Module->ItemHash);
                    array_push($vals,$name);
                }
            }
        }
        else
        {
            array_push($vals,$action);
        }

        return 
            $title.
            join("::",$vals).
            "";
    }
}

?>