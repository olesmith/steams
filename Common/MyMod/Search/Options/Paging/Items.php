<?php


trait MyMod_Search_Options_Paging_Items
{
    //*
    //* 
    //*

    function MyMod_Search_Options_Paging_NItems_Field($npages)
    {
        $nitems=$this->MyMod_Search_Options_Paging_Value_Names($npages);
        $nitems=array_pop($nitems);
        $nitems=preg_split('/[^\d]+/',$nitems);

        $nitems=array_pop($nitems);

        return $nitems;
    }
    
    //*
    //* 
    //*

    function MyMod_Search_Options_Paging_Items_PP_Field()
    {
        $options=array();
        $disabled=$this->MyMod_Search_CGI_Paging_No_Paging_Value();
        if ($disabled>0)
        {
            $options[ "DISABLED" ]="";
        }
        
        return
            $this->MakeInput
            (
                $this->MyMod_Search_CGI_Paging_NItems_PP_Key(),
                $this->MyMod_Search_CGI_Paging_NItems_PP_Value(),
                2,
                $options
            );
    }
    
}

?>