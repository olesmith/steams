<?php

class ItemsGroupTable extends ItemsRead
{

    //*
    //* function ItemGroupHtmlTable, Parameter list: $title,$where,$sort="Name"
    //*
    //* Generates html table for $where conforming items.
    //*

    function ItemGroupHtmlTable_20160908($title,$where,$sort="Name")
    {
        $items=$this->SelectHashesFromTable
        (
           "",
           $where,
           array(),
           FALSE,
           $sort
        );

        $html="";
        if (!empty($title)) { $html.=$this->H(1,$title); }

        if (count($items)>0)
        {
            $html.=
                $this->H(2,$this->ItemsName).
                $this->Html_Table
                (
                   "",
                   $this->MyMod_Data_Group_Table
                   (
                      "",
                      0,
                      "",
                      $items,
                      array()
                   ),
                   array("BORDER" => 1,"ALIGN" => 'center')
                ).
                "";
        }
        else
        {
            $html.=$this->H(2,"Nenhum(a) ".$this->ItemName);
        }

        return $html;
    }
}
?>