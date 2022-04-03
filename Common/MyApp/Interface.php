<?php


include_once("Interface/Headers.php");
include_once("Interface/Head.php");
include_once("Interface/Body.php");
include_once("Interface/Tail.php");
include_once("Interface/Doc.php");
include_once("Interface/Messages.php");
include_once("Interface/Titles.php");
include_once("Interface/Icons.php");
include_once("Interface/Logos.php");
include_once("Interface/LeftMenu.php");
include_once("Interface/CSS.php");


trait MyApp_Interface
{
    use
        MyApp_Interface_Headers,
        MyApp_Interface_Head,
        MyApp_Interface_Body,
        MyApp_Interface_Tail,
        MyApp_Interface_Doc,
        MyApp_Interface_Messages,
        MyApp_Interface_Titles,
        MyApp_Interface_Icons,
        MyApp_Interface_Logos,
        MyApp_Interface_LeftMenu,
        MyApp_Interface_CSS;

    var $MyApp_Interface_Left_Menu_Post_Html=array();

    //*
    //* function AllowedProfiles, Parameter list: 
    //*
    //* .
    //*

    function AllowedProfiles()
    {
        return $this->AllowedProfiles;
    }

    
    //*
    //* function MyApp_Interface_Init, Parameter list: 
    //*
    //* Initializes applicatiion interface.
    //*

    function MyApp_Interface_Init()
    {
        if (empty($this->HtmlSetupHash[ "CharSet" ]))
        {
            $this->HtmlSetupHash[ "CharSet"  ]="utf-8";
        }
        
        
        if (empty($this->HtmlSetupHash[ "DocTitle" ]))
        {
            $this->HtmlSetupHash[ "DocTitle"  ]=
                "Please give me a title (HtmlSetupHash->DocTitle)";
        }
        
        if (empty($this->HtmlSetupHash[ "Author" ]))
        {
            $this->HtmlSetupHash[ "Author"  ]=
                "Prof. Dr. Ole Peter Smith, IME, UFG, ole'at'mat'dot'ufg'dot'br";
        }
    }
    
    //*
    //* sub MyApp_Interface_Cookies_Message, Parameter list:
    //*
    //* Generates cookies info message.
    //*
    //*

    function MyApp_Interface_Cookies_Message()
    {
        return
            array
            (
                "This system uses",
                $this->A('http://www.google.com/search?q=cookies',"Cookies,"),
                "please enable them in you browser!",
            );
    }
    //*
    //* sub MyApp_Interface_Support, Parameter list:
    //*
    //* Generates support info.
    //*
    //*

    function MyApp_Interface_Support()
    {
        $authorlinks=$this->HtmlSetupHash[ "AuthorLinks"  ];
        $authorlinknames=$this->HtmlSetupHash[ "AuthorLinkNames"  ];

        $links=array();
        for ($n=0;$n<count($authorlinks);$n++)
        {
            $name=$authorlinks[$n];
            if (!empty($authorlinknames[$n])) { $name=$authorlinknames[$n]; }
            
            array_push
            (
               $links,$this->A
               (
                  $authorlinks[$n],
                  $name,
                  array
                  (
                     "Target" => "_ext",
                  )
                  
               )
            );
        }

        return
            $this->Htmls_Tag
            (
                "CENTER",
                array
                (
                    $this->Htmls_Table
                    (
                        "",
                        array
                        (
                            array
                            (
                                $this->B("Author:"),
                                $this->HtmlSetupHash[ "Author"  ],
                                join(" - ",$links)
                            ),
                            array
                            (
                                $this->B("Support:"),
                                $this->Htmls_Image_Text
                                (
                                    "support.png",
                                    $this->HtmlSetupHash[ "SupportEmail" ],
                                    $this->ColorCode2Color
                                    (
                                        $this->Layout[ "DarkGrey" ]
                                    ),
                                    $this->ColorCode2Color
                                    (
                                        $this->Layout[ "LightBlue" ]
                                    )
                                ),
                                ""
                            ),
                        ),
                        array("CLASS" => 'supporttable')
                    ),
                )
            );
    }
    
    //*
    //* function MyApp_Interface_ThanksTable, Parameter list: 
    //*
    //* Initializes loggin, if no.
    //*

    function MyApp_Interface_Thanks()
    {
        $table=
            $this->MyApp_Setup_Files2Hash
            (
                array
                (
                    $this->MyApp_Setup_Root().
                    "/Application/System/",
               
                    $this->MyApp_Setup_Path()
                ),
                array("Thanks.php")
            );

        foreach (array_keys($table) as $tid)
        {
            if
                (
                    !empty($table[ $tid ][2])
                    &&
                    !preg_match('/<A/',$table[ $tid ][2])
                )
            {
                $table[ $tid ][2]=
                    $this->A
                    (
                        $table[ $tid ][2],
                        $table[ $tid ][2],
                        array("TARGET" => '_blank')
                    );
            }
        }

        return
            array
            (
                $this->Htmls_DIV
                (
                    "Collaborators (alfabetical order):",
                    array("CLASS" => 'collaboratorstitle')
                ),
                $this->BR(),
                $this->Htmls_Tag
                (
                    "CENTER",
                    array
                    (
                        $this->Htmls_Table
                        (
                            "",
                            $table,
                            array("CLASS" => 'collaboratorstable'),
                            array(),array(),
                            True,True
                        )
                    )
                )
            );
     }

    
    //*
    //* function MyApp_Interface_Phrase, Parameter list: 
    //*
    //* Initializes loggin, if no.
    //*

    function MyApp_Interface_Phrase()
    {
        return
            $this->Htmls_DIV
            (
                $this->IMG
                (
                    "icons/kierkegaard.png",
                    "Life sure is a Mystery to be Lived, ".
                    "Not a Problem to be Solved",
                    100,400
                ),
                array("ALIGN" => 'center')
            );
    }

    //*
    //* 
    //*

    function MyApp_Interface_Sponsors($element_id,$type,$n_max)
    {
        if (!method_exists($this,"SponsorsObj")) { return array(); }
        return
            array
            (
                $this->Htmls_DIV
                (
                    array
                    (
                        $this->SponsorsObj()->MyMod_ItemsName(),
                        $this->Htmls_SCRIPT
                        (
                            "Show_Sponsors".
                            "(".
                            $this->JS_Quote($element_id).
                            ",".
                            $this->JS_Quote($type).
                            ",".
                            $this->JS_Quote($n_max).
                            ",".
                            $this->JS_Quote($this->Unit("ID")).
                            ");"
                        )
                    ),
                    array
                    (
                        "ID" => $element_id,
                        //"CLASS" => 'Sponsors',
                    ),
                    array()
                )
            );
    }
}

?>