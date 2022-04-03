<?php


trait MyApp_Interface_Body_Bottom
{
    //*
    //* sub MyApp_Interface_Body_Bottom_Row, Parameter list:
    //*
    //* Generates Bottom section row.
    //*

    function MyApp_Interface_Body_Bottom_Row()
    {
        if ($this->MyApp_Interface_Mobile_Is()) { return array(); }
        if ($this->NoTail>0) { return array(); }

        $html=array();
        if (!$this->MyApp_Interface_Mobile_Is())
        {
            $html=
                $this->Htmls_Comment_Section
                (
                    "BODY bottom row",
                    $this->Htmls_Tag
                    (
                        "TR",
                        array
                        (
                            $this->MyApp_Interface_Body_Bottom_Left(),
                            $this->MyApp_Interface_Body_Bottom_Center(),
                            $this->MyApp_Interface_Body_Bottom_Right(),
                        ),
                        array
                        (
                            "CLASS" => "website-footer-row"
                        )
                    )
                );
        }
        
        return
            array
            (
                array
                (
                    $this->MyApp_Interface_Post_Row(),
                    $html,
                    $this->Htmls_Tag_Close("TABLE"),
                ),
            );
    }
    
    //*
    //* sub MyApp_Interface_Body_Bottom_Left, Parameter list:
    //*
    //* Generates Bottom section left cell-.
    //*

    function MyApp_Interface_Body_Bottom_Left()
    {
        $html=array();
        if (!$this->MyApp_Interface_Mobile_Is())
        {
            $html=
                array
                (
                    $this->Img
                    (
                        $this->HtmlSetupHash[ "TailIcon_Left" ],
                        "Owl",
                        "100"
                    )
                );
        }
        
        return
            $this->Htmls_Tag
            (
                "TD",
                $html,
                array
                (
                    #"WIDTH" => '20%',
                    "CLASS" => 'applicationbottom applicationleft',
                )
            );
    }
    
    //*
    //* sub MyApp_Interface_Body_Bottom_Right, Parameter list:
    //*
    //* Generates Bottom section left cell-.
    //*

    function MyApp_Interface_Body_Bottom_Right()
    {
        $html=array();
        if (!$this->MyApp_Interface_Mobile_Is())
        {
            $html=
                array
                (
                    $this->Img
                    (
                        $this->HtmlSetupHash[ "TailIcon_Right" ],
                        "Owl",
                        "100"
                    )
                );
        }
        
        return
            $this->Htmls_Tag
            (
                "TD",
                $html,
                array
                (
                    #"WIDTH" => '20%',
                    "CLASS" => 'applicationbottom applicationright',
                )
            );
    }

    
    //*
    //* sub MyApp_Interface_Body_Bottom_Center, Parameter list:
    //*
    //* Generates Bottom section center cell-.
    //*

    function MyApp_Interface_Body_Bottom_Center()
    {
        $html=array();
        if (!$this->MyApp_Interface_Mobile_Is())
        {
            $html=
                array
                (
                    $this->Htmls_Tag
                    (
                        "FOOTER",
                        array
                        (
                            array_merge
                            (
                                $this->Htmls_HR('100%'),
                                $this->MyApp_Interface_Cookies_Message(),
                                $this->Htmls_HR('100%'),
                                $this->MyApp_Interface_Support(),
                                //$this->Htmls_HR('75%'),
                                $this->MyApp_Interface_Thanks(),
                                $this->Htmls_HR('100%'),
                                $this->MyApp_Interface_Phrase(),
                                $this->Htmls_HR('100%'),
                                $this->MyApp_Interface_Body_Middle_Row_Cookies_Show(),
                                $this->Htmls_HR('100%'),
                                $this->DB_Queries_Show()
                            )
                        )
                    ),
                );
        }
        return
            $this->Htmls_Tag
            (
                "TD",
                $html,
                array
                (
                    "CLASS" => 'applicationbottom applicationcenter',
                )
            );
    }

    
}

?>