<?php


trait MyApp_Interface_Body_Middle
{
    //*
    //* sub MyApp_Interface_Body_Middle_Row_First, Parameter list:
    //*
    //* Generates Middle section leading part:
    //*
    //* Left menu cell, until central module cell TD.
    //*

    function MyApp_Interface_Body_Middle_Row_First()
    {
        $this->MyApp_Middle_MTime=time();
        return
            $this->Htmls_Comment_Section
            (
                "BODY middle row, first part",
                $this->Htmls_Tag_Start
                (
                    "TR",
                    array
                    (
                        $this->Htmls_Tag
                        (
                            "TD",
                            $this->MyApp_Interface_LeftMenu(),
                            array
                            (
                                "CLASS" => 'applicationmiddle applicationleft leftmenu',
                            )
                        ),
                        
                        $this->Htmls_Tag_Start
                        (
                            "TD",
                            $this->Htmls_Tag_Start
                            (
                                "DIV",
                                array
                                (
                                    $this->MyApp_Interface_Body_PreText(),
                                ),
                                array
                                (
                                    "ID" => 'ModuleCell',
                                )
                            ),
                            array
                            (
                                "VALIGN" => 'top',
                                //"ID" => 'ModuleCell',
                                "CLASS" => 'applicationmiddle applicationcenter section ModuleCell',
                            )
                        ),
                    )
                )
            );
    }

    //*

    function MyApp_Interface_Body_Middle_Row_Cookies_Show()
    {
        if (!$this->MakeCGI_Cookie_Debug)
        {
            return array();
        }
        
        $html=array();
        foreach ($_COOKIE as $key => $value)
        {
            array_push($html,$key." => ".$value.$this->BR());
        }

        return $this->Htmls_Div($html,array("ALIGN" => 'left'));
    }
    
    //*
    //* sub MyApp_Interface_Body_Middle_Row_Last, Parameter list:
    //*
    //* Generates Middle section leading part:
    //*
    //* Left menu cell, until central module cell TD.
    //*

    function MyApp_Interface_Body_Middle_Row_Last()
    {
        if ($this->MyApp_Interface_Mobile_Is())
        {
            return array();
        }
        
        $html=array();
        if (!$this->MyApp_Interface_Mobile_Is())
        {
            $html=
                array
                (
                    "Exec Time: ".
                    (time()-$this->MyApp_Middle_MTime),

                    $this->Htmls_Tag
                    (
                        "ASIDE",
                        array
                        (
                            $this->MyApp_Interface_Sponsors("Sponsors_ML","Logo",5),
                            $this->Htmls_HR('75%'),
                            //$this->MyApp_Messages_Stats(),
                            $this->MyApp_Interface_Messages_System(),
                            $this->MyApp_Interface_Body_Middle_Row_Cookies_Show()
                        )
                    ),
                );
        }
        
        return
            array
            (
                $this->Htmls_Comment_Section
                (
                    "BODY middle row, right part: Start",
                    array
                    (
                        $this->Htmls_Tag_Close("DIV"),
                    $this->MyApp_Interface_Sponsors("Sponsors_MC","Banner",1),

                        
                        $this->Htmls_Tag_Close("TD"),

                        
                        $this->Htmls_Tag
                        (
                            "TD",
                            $html,
                            array
                            (
                                "CLASS" => 'applicationmiddle applicationright',
                            )
                        ),
                        $this->Html_Tag_Close("TR"),
                    ),
                    True//test
                )
            );
    }
}

?>