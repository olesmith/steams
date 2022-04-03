<?php


trait MyMod_Search_Options_Paging_Cells_NoOf
{
    //*
    //*
    //*

    function MyMod_Search_Options_Paging_Cells_Items_NoOf()
    {
        $np=$this->MyMod_Search_CGI_Page_Value();
        $npages=$this-> MyMod_Search_Options_Paging_CGI_NoOf();
        
        
        return 
           array
           (
              $this->Htmls_DIV
              (
                  $this->MyMod_ItemsName().":",
                  array("CLASS" => 'searchtitle')
              ),
              
              $this->MyMod_Search_Options_Format_N_Of_M
              (
                      $this->MyMod_Search_Options_Paging_Format
                      (
                          $this->NumberOfItems
                      ),
                      $this->MyMod_Search_CGI_Pages_Last
                      (
                          $np,
                          $this->MyMod_Search_CGI_Paging_NItems_PP_Value(),
                          $this->NumberOfItems,
                          "%d"
                      )-
                      $this->MyMod_Search_CGI_Pages_First
                      (
                          $np,
                          $this->MyMod_Search_CGI_Paging_NItems_PP_Value(),
                          $this->NumberOfItems,
                          "%d"
                      )+1,
                      $this->MyMod_Search_Options_Paging_NItems_Field($npages)
              ),
           );
    }
}

?>