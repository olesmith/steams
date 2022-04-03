<?php


trait Htmls_Menues_Dynamic_JS
{
    
    //*
    //* 
    //*

    function Htmls_Menues_Dynamic_JS($key,$is_hide_cell)
    {        
        $function=$this->Htmls_Menues_Dynamic_Entry_Value($key,"JS_Function");
        if (empty($function)) { return ""; }
        
        return
            $this->Htmls_Menues_Dynamic_JS_Function($key).
            "(\n".            
            join
            (
                ",\n",
                $this->Htmls_Menues_Dynamic_JS_Args
                (
                    $key,$is_hide_cell
                )
            ).
            ")";
    }
    
    //*
    //* 
    //*

    function Htmls_Menues_Dynamic_JS_Function($key)
    {
        $function='Load_URL_Once';
        $function='';

        if
            (
                !empty(
                    $rfunction=
                    $this->Htmls_Menues_Dynamic_Entry_Value
                    (
                        $key,
                        "JS_Function"
                    )
                )
            )
        {
            $function=$rfunction;
        }

        return $function;
    }
    
    //*
    //* 
    //*

    function Htmls_Menues_Dynamic_JS_Args($key,$is_hide_cell)
    {
       return
            array_merge
            (
                $this->Htmls_Menues_Dynamic_Load($key),
                array
                (
                    $this->Htmls_Menues_Dynamic_JS_ShowHide
                    (
                        $key,$is_hide_cell
                    )
                )
            );
    }
    
    //*
    //* 
    //*

    function Htmls_Menues_Dynamic_JS_ShowHide($key,$is_hide_cell)
    {
        return
            array
            (
                //Element ids to hide
                $this->Htmls_Menues_Dynamic_Hidden_JS
                (
                    $key,$is_hide_cell//,
                    //"initial"
                ),
                
                //Element ids to show
                $this->Htmls_Menues_Dynamic_Show_JS
                (
                    $key,$is_hide_cell,
                    $this->Htmls_Menues_Dynamic_Entry_Value
                    (
                        $key,
                        "Display_Show"
                    ),
                    $this->Htmls_Menues_Dynamic_Entry_Value
                    (
                        $key,
                        "Display_Dest"
                    )
                )
            );
    }
}
?>