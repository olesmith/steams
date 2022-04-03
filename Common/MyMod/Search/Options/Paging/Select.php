<?php


trait MyMod_Search_Options_Paging_Select
{
    //*
    //* function MyMod_Search_Options_Paging_Row, Parameter list: $omitvars
    //*
    //* 
    //*

    function MyMod_Search_Options_Paging_Select()
    {
        $options=array();
        $disabled=$this->MyMod_Search_CGI_Paging_No_Paging_Value();
        if ($disabled>0)
        {
            $options[ "DISABLED" ]="";
        }
        
        $npages=$this-> MyMod_Search_Options_Paging_CGI_NoOf();
        return
            array
            (
             
                $this->Htmls_Select
                (
                    $this->MyMod_Search_CGI_Page_Key(),
                    $this->MyMod_Search_Options_Paging_Values($npages),
                    $this->MyMod_Search_Options_Paging_Value_Names($npages),
                    $this->MyMod_Paging_Page_No_Get(),
                    $args=array(),
                    $options
                ),
            );
    }
}

?>