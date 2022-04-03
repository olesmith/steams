<?php


trait MyMod_Search_Options_Paging_Row
{
    //*
    //* function MyMod_Search_Options_Paging_Row, Parameter list: $omitvars
    //*

    function MyMod_Search_Options_Paging_Row_1($omitvars)
    {
        return
           array_merge
           (
               $this->MyMod_Search_Options_Paging_Cells_Items_PerPage(),
               $this->MyMod_Search_Options_Paging_Cells_NoPaging()
           );
    }
    
    //*
    //* function MyMod_Search_Options_Paging_Row, Parameter list: $omitvars
    //*

    function MyMod_Search_Options_Paging_Row_2($omitvars)
    {
        return 
           array_merge
           (
               $this->MyMod_Search_Options_Paging_Cells_Items_NoOf(),
               $this->MyMod_Search_Options_Paging_Cells_Items_PageNo()
           );
    }
}

?>