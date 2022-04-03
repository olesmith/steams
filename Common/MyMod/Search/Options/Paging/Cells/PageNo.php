<?php


trait MyMod_Search_Options_Paging_Cells_PageNo
{
    //*
    //*
    //*

    function MyMod_Search_Options_Paging_Cells_Items_PageNo()
    {
        $npages=$this->MyMod_Search_Options_Paging_CGI_NoOf();

        return 
           array
           (
              $this->Htmls_DIV
              (
                  $this->MyLanguage_GetMessage("Page").": ".

                  $this->MyMod_Search_Options_Format_N_Of_M
                  (
                      $this->MyMod_Search_Options_Paging_Format($npages),
                      $this->MyMod_Search_CGI_Page_Value(),
                      $npages
                  ),
                  array("CLASS" => 'searchtitle')
              ),
              $this->MyMod_Search_Options_Paging_Select(),
           );
    }
}

?>