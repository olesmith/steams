<?php


class ItemPrints extends ItemEdits
{

    /* function PrintItem($item=array(),$printpdf=TRUE) */
    /* { */
    /*     if  (count($item)==0) { $item=$this->ItemHash; } */
        
    /*     $latexdocno=$this->CGI2LatexDocNo(); */
        
    /*     $this->ApplicationObj->LogMessage */
    /*     ( */
    /*         "PrintItem, ".$latexdocno, */
    /*         $item[ "ID" ].": ".$this->MyMod_Item_Name_Get($item) */
    /*     ); */

    /*     $latex= */
    /*         $this->MyMod_Latex_Head("Singular",$latexdocno). */
    /*         $this->Item_Latex($item). */
    /*         $this->MyMod_Latex_Tail("Singular",$latexdocno); */

    /*     $latex=$this->Latex_Trim($latex); */
    /*     $latex=$this->Filter($latex,$item); */
    /*     $latex=$this->FilterObject($latex); */

    /*     $texfilename="Item"; */
    /*     if ($this->ItemName) { $texfilename=$this->ItemName; } */
    /*     $texfilename.=".".time().".tex"; */

    /*     return $this->Latex_PDF($texfilename,$latex,$printpdf); */
    /* } */



}
?>