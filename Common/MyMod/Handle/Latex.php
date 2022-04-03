<?php

trait MyMod_Handle_Latex
{
  //*
  //* Handles $item 'latexing'.
  //*

  function MyMod_Handle_Latex_Item($item=array())
  {
      if (count($item)==0) { $item=$this->ItemHash; }
      $item=$this->MyMod_Item_Latex_Trim($item);
      if (method_exists($this,"InitPrint")) { $item=$this->InitPrint($item); }

      $title=$this->ItemName." ".$item[ "ID" ].": ".$this->MyMod_Item_Name_Get($item);

      $this->MyMod_Item_Latex_Table_Print($title,$item);
  }
 
  //*
  //* Handles items 'latexing', according to $where.
  //*

  function MyMod_Handle_Latex_Items($where="")
  {
      $individual=$this->GetCGIVarValue("Individual");

      if ($individual==1)
      {
          $items=$this->MyMod_Items_Read($where,array_keys($this->ItemData),FALSE,TRUE);
      }
      else
      {
          $items=$this->MyMod_Items_Read($where);
      }

      $this->MyMod_Handle_Latex_Items_Trim();

      $items=$this->MyMod_Sort_Items();
      for ($n=0;$n<count($items);$n++)
      {
          if (method_exists($this,"InitPrint"))
          {
              $items[$n]=$this->InitPrint($items[$n]);
          }
      }

      if ($individual==1)
      {
          $this->MyMod_Items_Latex_Table_Print($items);
      }
      else
      {
          $this->MyMod_Items_Latex_Table
          (
              False,
              $items,
              $datas=array(),
              array("\\Large{Relatório de ".$this->ItemsName."}\n\n")
          );
      }
  }

    //*
    //* Trims items, preparing to output latex.
    //*

    function MyMod_Handle_Latex_Items_Trim()
    {
        foreach ($this->ItemHashes as $id => $item)
        {
            //$this->ItemHashes[ $id ]=$this->MyMod_Handle_Latex_Item_Trim($item);
        }
    }

}

?>