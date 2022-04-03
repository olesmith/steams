<?php


trait MyMod_Search_Options_Paging_Cells_PerPage
{
    //*
    //*
    //*

    function MyMod_Search_Options_Paging_Cells_Items_PerPage()
    {
        return 
           array
           (
              $this->Htmls_DIV
              (
                  $this->MyMod_ItemsName()." ".
                  $this->MyLanguage_GetMessage("PerPage").":",
                  array("CLASS" => 'searchtitle')
              ),
              $this->MyMod_Search_Options_Paging_Items_PP_Field(),
           );
    }
    
}

?>