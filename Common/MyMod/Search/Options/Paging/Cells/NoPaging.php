<?php


trait MyMod_Search_Options_Paging_Cells_NoPaging
{
    //*
    //*
    //*

    function MyMod_Search_Options_Paging_Cells_NoPaging()
    {
        return 
           array
           (
              $this->Htmls_DIV
              (
                  $this->MyLanguage_GetMessage("NoPaging").": ",
                  array("CLASS" => 'searchtitle')
              ),
              $this->MakeCheckBox
              (
                  $this->MyMod_Search_CGI_Paging_No_Paging_Key(),
                  1,
                  $this->MyMod_Search_CGI_Paging_No_Paging_Value()
              ),
           );
    }
}

?>