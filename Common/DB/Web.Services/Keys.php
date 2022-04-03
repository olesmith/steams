<?php


trait DB_Web_Services_Keys
{
    
    //*
    //* Name of json/uri field containg number of items.
    //* 

    function DB_Web_Services_Key_Total()
    {
        if (isset($this->SigaZ()->SigaA_Args[ "Siga_Totals_Key" ]))
        {
            return $this->SigaZ()->SigaA_Args[ "Siga_Totals_Key" ];
        }
        
        return "total_itens";
    }
    
    //*
    //* Name of json/uri field containg item per page.
    //* 

    function DB_Web_Services_Key_Items_PP()
    {
        if (isset($this->SigaZ()->SigaA_Args[ "Siga_Items_PP_Key" ]))
        {
            return $this->SigaZ()->SigaA_Args[ "Siga_Items_PP_Key" ];
        }
        
        return "itens_por_pagina";
    }
    
    //*
    //* Name of json/uri field containg item per page.
    //* 

    function DB_Web_Services_Key_Page()
    {
        if (isset($this->SigaZ()->SigaA_Args[ "Siga_Page_Key" ]))
        {
            return $this->SigaZ()->SigaA_Args[ "Siga_Page_Key" ];
        }
        
        return "pagina";
    }
    
    //*
    //* Name of json/uri field containg the rows.
    //* 

    function DB_Web_Services_Key_Rows()
    {
        if (isset($this->SigaZ()->SigaA_Args[ "Siga_List_Key" ]))
        {
            return $this->SigaZ()->SigaA_Args[ "Siga_List_Key" ];
        }
        
        return "rows"; //"list";
    }
}

?>