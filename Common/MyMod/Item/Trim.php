<?php


trait MyMod_Item_Trim
{
    //*
    //* Trims item if id $id $datas.
    //*

    function MyMod_Item_Trim($datas,$id)
    {
        foreach ($datas as $data)
        {
            $this->MyMod_Item_Trim_Data($datas,$id,$data);
        }
    }
    
    //*
    //* Trims item if id $id $data.
    //*

    function MyMod_Item_Trim_Data($datas,$id,$data)
    {
        if (!empty($this->ItemHashes[$id][ $data ]))
        {
            $this->ItemHashes[$id][ $data ]=
                preg_replace('/^\s+/',"",$this->ItemHashes[$id][ $data ]);
            $this->ItemHashes[$id][ $data ]=
                preg_replace('/\s+$/',"",$this->ItemHashes[$id][ $data ]);
                
            if (!empty($this->ItemData[ $data ][ "TrimCase" ]))
            {
                $this->ItemHashes[$id][ $data ]=
                    $this->TrimCase($this->ItemHashes[$id][ $data ]);
            }
        }
    }
    //*
    //* function TrimDateData, Parameter list: $item,$data,$newvalue
    //*
    //* Trims date/mon/year strings. TriggerFunction style, that is may be used as a TriggerFunction.
    //*

    function MyMod_Item_Trim_Date($item,$data,$newvalue)
    {
        if (empty($newvalue) && !empty($item[ $data ]))
        {
            $newvalue=$item[ $data ];
        }

        if (preg_match('/\d\d?/',$newvalue))
        {
            $newvalue=$this->MyTime_Date_Trim($newvalue);
        }

        $item[ $data ]=$newvalue;

        return $item;
    }

}

?>