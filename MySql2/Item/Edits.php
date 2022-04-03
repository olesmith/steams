<?php

class ItemEdits extends ItemForms
{
    var $AddDefaults=array();
    var $AddFixedValues=array();

    //*
    //* Adds item to DB.
    //*

    function Add(&$msg,&$item=array())
    {
        return $this->MyMod_Handle_Add_Do($msg,$item);
    }
    
    //*
    //* Creates row for defining new item.
    //*

    function AddRow($prekey,$item=array(),$datas=array(),$takepost,$nempties=0)
    {
        $row=array();
        $empty=array();
        for ($n=1;$n<=$nempties;$n++) { array_push($empty,""); }

        foreach ($datas as $data)
        {
            if (!empty($this->ItemData[ $data ]))
            {
                $value="";
                if (!empty($item[ $data ]))
                {
                    $value=$item[ $data ];
                }

                if (empty($item[ $data ]) && $takepost)
                {
                    $value=$this->GetPOST($prekey.$data);
                }

                if (empty($item[ $data ]) && $this->ItemData[ $data ][ "Default" ])
                {
                    $value=$this->ItemData[ $data ][ "Default" ];
                }

                $item[ $data ]=$value;

                array_push
                (
                   $row,
                   $this->MyMod_Data_Fields(1,$item,$data,TRUE)
                );
            }
            else
            {
                array_push($empty,"&nbsp;");
            }
        }

        array_unshift
        (
           $row,
           $this->MultiCell
           (
              $this->B("Adicionar:").
              $this->MakeHidden("AddRow",1),
              count($empty)-1
           )
        );


        return $row;
    }

    //*
    //* Creates row for defining new item.
    //*

    function UpdateAddRow($prekey,$item=array(),$datas=array())
    {
        if ($this->GetPOST("AddRow")==1)
        {
            $add=TRUE;

            foreach ($datas as $data)
            {
                if (!empty($this->ItemData[ $data ]))
                {
                    $value="";
                    if (!empty($item[ $data ]))
                    {
                        $value=$item[ $data ];
                    }

                    if (empty($value))
                    {
                        $value=$this->GetPOST($prekey.$data);
                    }

                    if (!empty($value))
                    {
                        $item[ $data ]=$value;
                    }
                    elseif (!$this->ItemData[ $data ][ "Compulsory" ])
                    {
                        $item[ $data ]="";
                    }
                    else
                    {
                        $add=FALSE;
                    }
                }
            }

            if (method_exists($this,"MayAdd"))
            {
                $add=$this->MayAdd($item);
            }

            if ($add)
            {
                $msg="";

                $res=$this->Add($msg,$item);
                print $this->H(4,$this->ItemName." adicionado com exito");

                return $item;
            }
            else
            {
                print $this->H(4,$this->ItemName." invalido(a)");
            }
        }

        return FALSE;
    }
}

?>