<?php

trait MyMod_Handle_Edit_Info
{
    //*
    //* Cretaes table of sgroups info table.
    //*

    function MyMod_Handle_Edit_Info_Matrix($item)
    {
        $infotable=array();
        if ($this->ShowTimes && isset($item[ "CTime" ]))
        {
            array_push
            (
               $infotable,
               array
               (
                  $this->SPAN
                  (
                     $this->GetMessage($this->ItemDataMessages,"Created").":",
                     array("CLASS" => 'searchtitle')
                  ),
                  $this->TimeStamp2Text($item[ "CTime" ])
               ),
               array
               (
                  $this->SPAN
                  (
                     $this->GetMessage($this->ItemDataMessages,"LastChange").":",
                     array("CLASS" => 'searchtitle')
                  ),
                  $this->TimeStamp2Text($item[ "MTime" ])
               )
            );
        }

        return $infotable;
    }
    
    //*
    //* Cretaes table of sgroups info table as html.
    //*

    function MyMod_Handle_Edit_Info_Table($item)
    {
        return
            array
            (
                $this->Htmls_Table
                (
                    "",
                    $this->MyMod_Handle_Edit_Info_Matrix($item),
                    array
                    (
                        "ALIGN" => 'center',
                        "FRAME" => 'box',
                    )
                ),
                $this->BR()
            );
    }    
}

?>