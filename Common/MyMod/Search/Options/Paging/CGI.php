<?php


trait MyMod_Search_Options_Paging_CGI
{
    //*
    //* Calculate number of pages.MyMod_Search_CGI_Pages_Number_Of
    //*

    function MyMod_Search_Options_Paging_CGI_NoOf($nitems=NULL,$nitemspp=NULL)
    {
        if ($nitems==NULL)   { $nitems=$this->NumberOfItems; }
        if ($nitemspp==NULL)
        {
            $nitemspp=$this->MyMod_Search_CGI_Paging_NItems_PP_Value();
        }

        $npages=$nitems;
        if ($nitemspp>0) { $npages=intval($nitems/$nitemspp); }
        
        if ($nitems-$nitemspp*$npages>0)
        {
            $npages++;
        }

        return $npages;
    }
}

?>