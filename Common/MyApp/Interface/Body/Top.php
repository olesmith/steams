<?php


trait MyApp_Interface_Body_Top
{
    //*
    //* Handler for generating and echoing interface top row, only the TDs.
    //*

    function MyApp_Interface_Body_Top_Handle()
    {
        $this->Htmls_Echo
        (
            $this->MyApp_Interface_Body_Top_TDs()
        );
    }
    
    //*
    //* Print Document Header row: Left, center and right cells.
    //*

    function MyApp_Interface_Body_Top_Row()
    {
        $noheads=$this->CGI_COOKIEOrGET("NoHeads");
        if ($noheads!=1)
        {
            return
                $this->Htmls_Comment_Section
                (
                    "BODY top row: Start",
                    $this->Htmls_Tag
                    (
                        "TR",
                        $this->MyApp_Interface_Body_Top_TDs(),
                        array
                        (
                            "ID" => "TOP",
                            "CLASS" => "website-header-row"
                        )
                    )
                );
        }
        else
        {
            return array();
        }
    }
    
    //*
    //* 
    //*

    function MyApp_Interface_Body_Top_TDs()
    {
        return
            array
            (
                $this->MyApp_Interface_Body_Top_Left(),
                $this->MyApp_Interface_Body_Top_Center(),
                $this->MyApp_Interface_Body_Top_Right()
            );
    }

    //*
    //* return interface head left cell.
    //*

    function MyApp_Interface_Body_Top_Left()
    {
        $html=array();
        if (!$this->MyApp_Interface_Mobile_Is())
        {
            $html=array($this->MyApp_Interface_Logo(1));
        }
        
        return
            $this->Htmls_Tag
            (
                "TD",
                array
                (
                    $html
                ),
                array
                (
                    "ID" => "TL",
                    "CLASS" => 'applicationtop applicationleft',
                )
            );
    }


    //*
    //* return inteerface head right cell.
    //*

    function MyApp_Interface_Body_Top_Right()
    {
        $html=array();
        if (!$this->MyApp_Interface_Mobile_Is())
        {
            $html=array($this->MyApp_Interface_Logo(2));
        }
        
        return
            $this->Htmls_Tag
            (
                "TD",
                $html,
                array
                (
                    "ID" => "TR",
                    "CLASS" => 'applicationtop applicationright',
                )
            );
    }

    //*
    //* return inteerface head center cell.
    //*

    function MyApp_Interface_Body_Top_Center()
    {
        $class='applicationtop applicationcenter headtable';
        $html=array();
        if (!$this->MyApp_Interface_Mobile_Is())
        {
            $html=
                $this->Htmls_Tag
                (
                    "HEADER",
                    array(array(
                        $this->MyApp_Interface_Body_Top_Center_Titles($class)
                    ))
                );
        }

        return
            $this->Htmls_Tag
            (
                "TD",
                $html,
                array
                (
                    "ID" => "TC",
                    "CLASS" => $class,
                )
            );
    }

    
    //*
    //* Return interface head center cell.
    //*

    function MyApp_Interface_Body_Top_Center_Titles($class)
    {
        $classes=$this->MyApp_Interface_Title_Classes();
        
        $classno=0;
        
        $titles=array();
        foreach ($this->MyApp_Interface_Titles() as $title)
        {
            if (!empty($title))
            {
                if (!empty($classes[ $classno ]))
                {
                    $class=$classes[ $classno ];
                }
                
                array_push
                (
                    $titles,
                    $this->DIV
                    (
                        $title,
                        array
                        (
                            "ALIGN" => 'center',
                            "CLASS" => $class,
                        )
                    )
                );

                $classno++;
            }
        }

        return $titles;
    }
}

?>