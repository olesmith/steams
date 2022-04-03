<?php


trait MyMod_Search_Options_Details
{
    var $MyMod_Search_Options_Details_Key="Search_Details";
    
    //*
    //* Creates row with Show/Hide details button
    //*

    function MyMod_Search_Options_Details_Buttons_Cell($omitvars)
    {        
        if (!$this->MyMod_Search_Options_Details_Should($omitvars))
        {
            return array();
        }

        return 
           array
           (
              $this->Htmls_Hide_Button_ByClass
              (
                  $this->MyMod_Search_Options_Details_CSS_Class(),
                  $this->MyMod_Search_Options_Details_Key,
                  $this->MyMod_Search_Options_Details_Hide_Should($omitvars)
              ),
              $this->Htmls_Hidden
              (
                  $this->MyMod_Search_Options_Details_Hide_Field(),
                  $this->MyMod_Search_Options_Details_Hide_Value()
              ),
           );
     }
    
    //*
    //* Should we hide details? Default is True.
    //*

    function MyMod_Search_Options_Details_Hide_Should($omitvars=array())
    {
        if (preg_grep('/^Details/',$omitvars)) { return False; }
        
        $cgikey=$this->MyMod_Search_Options_Details_Hide_Field();       
        if (isset($_POST[ $cgikey ]))
        {
            if ($this->CGI_POSTint($cgikey)==1) { return True; }
            else                                { return False; }
        }

        return True;
    }

    //*
    //* Hide field CSS class.
    //*

    function MyMod_Search_Options_Details_CSS_Class()
    {
        return $this->MyMod_Search_Options_Details_Key."_Show";
    }
    
    //*
    //* Key of Hide cgi field.
    //*

    function MyMod_Search_Options_Details_Hide_Field()
    {
        return "Hide_".$this->MyMod_Search_Options_Details_Key;
    }
    
    //*
    //* Value to set for Details hide field.
    //*

    function MyMod_Search_Options_Details_Hide_Value()
    {
        $value=$this->MyMod_Search_Options_Details_Hide_Should();

        if ($value) { $value=1; }
        else        { $value=0; } 

        return $value;
    }


    //*
    //* Should we show Details options?
    //* True if there are any ItemData with Search_Details on.
    //*

    function MyMod_Search_Options_Details_Should($omitvars)
    {
        if (!$this->MyMod_Search_Option_Should("Details",$omitvars))
        {
            return False;
        }
        
         return (count( $this->MyMod_Search_Datas_Get($details=True) )>0);
    }

    //*
    //* Creates row with Show/Hide details button
    //*

    function MyMod_Search_Options_Options_Cell()
    {
        $class="buttons";
        $hide=$class."_Hide";
        $show=$class."_Show";

        $display="table";
        return
            array
            (
                $this->Htmls_Tag
                (
                    "BUTTON",
                    
                    $this->MyLanguage_GetMessage
                    (
                        array("Show","Options")
                    ),
                    array
                    (
                        "CLASS" => $show,
                        //"STYLE" => array("display" => 'none'),
                        "ONCLICK" => array
                        (
                            $this->JS_Show_Elements_By_Class
                            (
                                $this->MyMod_Search_Table_Options_Class(),
                                $display
                            ),
                            
                            $this->JS_Show_Elements_By_Class
                            (
                                $hide,
                                $display
                            ),
                            $this->JS_Hide_Elements_By_Class
                            (
                                $show
                            ),
                        )
                    )
                ),
                $this->Htmls_Tag
                (
                    "BUTTON",
                    $this->MyLanguage_GetMessage
                    (
                        array("Hide","Options")
                    ),
                    array
                    (
                        "STYLE" => array("display" => 'none'),
                        "CLASS" => $hide,
                        "ONCLICK" => array
                        (
                            $this->JS_Hide_Elements_By_Class
                            (
                                $this->MyMod_Search_Table_Options_Class()
                            ),
                            
                            $this->JS_Show_Elements_By_Class
                            (
                                $show,
                                $display
                            ),
                            $this->JS_Hide_Elements_By_Class
                            (
                                $hide
                            ),
                        )
                    )
                ),
            );
    }
}

?>