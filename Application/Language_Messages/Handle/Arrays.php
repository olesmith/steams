<?php

include_once("Arrays/SGroup.php");
include_once("Arrays/Read.php");
include_once("Arrays/Cells.php");
include_once("Arrays/Datas.php");
include_once("Arrays/Rows.php");
include_once("Arrays/Titles.php");
include_once("Arrays/Languages.php");
include_once("Arrays/Table.php");
include_once("Arrays/Hide.php");
include_once("Arrays/Html.php");
include_once("Arrays/Update.php");
include_once("Arrays/Form.php");

class Language_Messages_Handle_Arrays extends Language_Messages_Handle_Arrays_Form
{
     //*
    //* Will create a composed screen editing common data,
    //* and a table of individual array datas.
    //*

    function Language_Messages_Handle_Array($edit,$item=array())
    {
        if (empty($item)) { $item=$this->ItemHash; }
        
        if ($item[ "Message_Type" ]!=$this->Language_Array_Type) { return; }

        echo
            $this->Htmls_Text
            (
                array
                (
                    $this->Language_Messages_Handle_Array_Form($edit,$item),
                )
            );
    }
        
    
    
    
    
}
?>