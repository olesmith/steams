<?php

include_once("Cells/PerPage.php");
include_once("Cells/NoPaging.php");
        
include_once("Cells/NoOf.php");
include_once("Cells/PageNo.php");

trait MyMod_Search_Options_Paging_Cells
{
    use
        MyMod_Search_Options_Paging_Cells_PerPage,
        MyMod_Search_Options_Paging_Cells_NoPaging,
        MyMod_Search_Options_Paging_Cells_NoOf,
        MyMod_Search_Options_Paging_Cells_PageNo;
    
}

?>