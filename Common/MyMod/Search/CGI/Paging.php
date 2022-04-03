<?php


trait MyMod_Search_CGI_Paging
{
    //*
    //* Calculate number of First item.
    //*

    function MyMod_Search_CGI_Page_Info_List($np,$nitemspp=NULL,$nitems=NULL,$format=NULL)
    {
        if ($nitems==NULL)   { $nitems=$this->NumberOfItems; }
        if ($nitemspp==NULL) { $nitemspp=$this->MyMod_Search_CGI_Paging_NItems_PP_Value(); }
        if ($format==NULL) { $format=$this->MyMod_Search_Options_Paging_Format($nitems); }

        return
            array
            (
                $this->MyMod_Search_CGI_Pages_First($np,$nitemspp,$nitems,$format),
                $this->MyMod_Search_CGI_Pages_Last($np,$nitemspp,$nitems,$format),
            );
    }
    //*
    //* Calculate number of First item.
    //*

    function MyMod_Search_CGI_Pages_First($np,$nitemspp,$nitems,$format)
    {
        return 
            sprintf
            (
                $format,
                $this->Min(($np-1)*$nitemspp+1,$nitems)
            );
    }
    
    //*
    //* Calculate number of Last item.
    //*

    function MyMod_Search_CGI_Pages_Last($np,$nitemspp,$nitems,$format)
    {
        return
            sprintf
            (
                $format,
                $this->Min($np*$nitemspp,$nitems)
            );
    }
    
    
    //*
    //* Name of page number cgi field.
    //*

    function MyMod_Search_CGI_Page_Key()
    {
        return $this->ModuleName."_".$this->MyMod_Search_Options_Page_Key;
        
    }
    
    //*
    //* Value of go edit items cgi field.
    //*

    function MyMod_Search_CGI_Page_Value()
    {
        $this->MyMod_Paging_No=
            $this->CGI_POSTint
            (
                $this->MyMod_Search_CGI_Page_Key()
            );
        
        if (empty($this->MyMod_Paging_No))
        {
            $this->MyMod_Paging_No=
                $this->CGI_GETOrPOSTint
                (
                    $this->MyMod_Search_Options_Page_Key
                );
        }

        if (empty($this->MyMod_Paging_No)) { $this->MyMod_Paging_No=1; }

        return $this->MyMod_Paging_No;        
    }
    
    //*
    //* 
    //*

    function MyMod_Search_CGI_Paging_No_Paging_Key()
    {
        return $this->ModuleName."_".$this->MyMod_Search_Options_No_Paging_Key;
    }

    //*
    //* 
    //*

    function MyMod_Search_CGI_Paging_No_Paging_Value()
    {
        $val=
            $this->CGI_GETOrPOSTint
            (
                $this->MyMod_Search_CGI_Paging_No_Paging_Key()
            );

        return $val;        
    }

    
    //*
    //* Name of go edit items cgi field.
    //*

    function MyMod_Search_CGI_Paging_NItems_PP_Key()
    {
        return $this->ModuleName."_".$this->MyMod_Search_Options_NItems_PP_Key;
        
    }
    
    //*
    //* Name of go edit items cgi field.
    //*

    function MyMod_Search_CGI_Paging_NItems_PP_Value()
    {
        $disabled=$this->MyMod_Search_CGI_Paging_No_Paging_Value();
        if ($disabled>0)
        {
            return $this->NumberOfItems;
        }
        
        $val=
            $this->CGI_GETOrPOSTint
            (
                $this->MyMod_Search_CGI_Paging_NItems_PP_Key()
            );

        if (empty($val)) { $val=$this->NItemsPerPage; }
        
        return $val;        
    }
}

?>