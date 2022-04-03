<?php

trait Htmls_Menues_Dynamic_Scripts
{   
    //*
    //* Generates Menu scripts section: Scripts and Loads. Together.
    //* Won't work in seperate sections. Why???
    //*

    function Htmls_Menues_Dynamic_Scripts($debug=True)
    {
        return
            $this->Htmls_SCRIPT
            (
                array
                (
                    $this->Htmls_Menues_Dynamic_Scripts_Entries(),
                    $this->Htmls_Menues_Dynamic_Loads(),
                ),
                $this->Htmls_Menues_Dynamic_Scipts_Options($debug)
            );
    }

    //*
    //* Generates Menu script section.
    //*

    function Htmls_Menues_Dynamic_Scripts_Entries()
    {
        //Disabled!
        return array();
        /* $js=array(); */
        /* foreach ($this->Htmls_Menues_Dynamic_Entry_Keys() as $key) */
        /* { */
        /*     if (!is_array($this->_Entries_[ $key ])) */
        /*     { */
        /*         var_dump("Not array, $key"); */
        /*         continue; */
        /*     } */

        /*     $js= */
        /*         array_merge */
        /*         ( */
        /*             $js, */
        /*             $this->Htmls_Menues_Dynamic_Scipts_Entry($key) */
        /*         ); */
        /* } */
        
        /* return $js; */
    }
    
    //*
    //* 
    //*

    function Htmls_Menues_Dynamic_Scipts_Entry($key)
    {
        $js=
            array
            (
                "function ".
                $this->Htmls_Menues_Dynamic_Entry_ID($key,"Show").
                "()",
                "{",
                $this->Htmls_Menues_Dynamic_Entry_JS_Show($key),
                "}",
                
                "",
                
                "function ".
                $this->Htmls_Menues_Dynamic_Entry_ID($key,"Hide").
                "()",
                "{",
                $this->Htmls_Menues_Dynamic_Entry_JS_Hide($key),
                "}",

                
                "console.log('Loading functions ".
                $this->Htmls_Menues_Dynamic_Entry_ID($key,"Show").
                "  -  ".
                $this->Htmls_Menues_Dynamic_Entry_ID($key,"Hide").
                "');"
            );

        return $js;
    }
    
    //*
    //* 
    //*

    function Htmls_Menues_Dynamic_Scipts_Options($debug)
    {
        $style=array();
        if ($debug)
        {
            $style=
                array
                (
                    "text-align" => 'left',
                    "white-space" => 'pre',
                    "display" => 'inline-block',
                );
        }

        return array("STYLE" => $style);
    }
}
?>