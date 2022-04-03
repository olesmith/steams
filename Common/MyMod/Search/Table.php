<?php

include_once("Table/Extras.php");
include_once("Table/Buttons.php");
include_once("Table/Fields.php");
include_once("Table/Titles.php");


trait MyMod_Search_Table
{
    use
        MyMod_Search_Table_Extras,
        MyMod_Search_Table_Buttons,
        MyMod_Search_Table_Fields,
        MyMod_Search_Table_Titles;
    //*
    //* Creates form search vars table. Returns table as matrix.
    //*

    function MyMod_Search_Table_Matrix($omitvars=array(),$title="",$action="",$addvars=array(),$fixedvalues=array(),$tabmovesdown="",$buttons=array())
    {
        return
            array_merge
            (
                $this->MyMod_Search_Table_Title_Row($title),
                
                //Without details
                $this->MyMod_Search_Table_Fields_Table($fixedvalues,$omitvars),
                
                $this->MyMod_Search_Table_Details
                (
                    $omitvars,
                    $title,
                    $action,
                    $addvars,
                    $fixedvalues,
                    $tabmovesdown,
                    $buttons
                ),
                array($this->MyMod_Search_Table_Buttons_Row($buttons))
            );
    }
    
    //*
    //* 
    //*

    function MyMod_Search_Table_Details($omitvars=array(),$title="",$action="",$addvars=array(),$fixedvalues=array(),$tabmovesdown="",$buttons=array())
    {
        return
            array_merge
            (
                array
                (
                    array
                    (
                        "",
                        $this->MyMod_Search_Options_Options_Cell(),
                        $this->MyMod_Search_Options_Details_Buttons_Cell($omitvars),
                    ),
                ),

                
                //With details
                $this->MyMod_Search_Table_Fields_Table($fixedvalues,$omitvars,True),
                $this->MyMod_Search_Table_Extra_Vars_Rows($addvars),

                $this->MyMod_Search_Table_Options_Rows($omitvars)
            );
    }
    
    //*
    //* 
    //*

    function MyMod_Search_Table_Options_Rows($omitvars)
    {
        return
            array
            (
                array
                (
                    $this->MyMod_Search_Table_Options_Html($omitvars),
                )
            );
    }
    
    //*
    //* 
    //*

    function MyMod_Search_Table_Options_Html($omitvars)
    {
        return
            $this->Htmls_Table
            (
                "",
                $this->MyMod_Search_Options_Rows($omitvars),
                array
                (
                    "CLASS" => $this->MyMod_Search_Table_Options_Class(),
                    "STYLE" => array
                    (
                        'display' => 'none',
                    ),
                )
            );
    }
    //*
    //* 
    //*

    function MyMod_Search_Table_Options_Class()
    {
        return "Search_Options_".$this->ModuleName;
    }
}

?>