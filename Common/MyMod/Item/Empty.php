<?php


trait MyMod_Item_Empty
{
    function MyMod_Item_Empty($datas=array())
    {
        if (count($datas)==0) { $datas=array_keys($this->ItemData); }

        $item=array();
        foreach ($datas as $id => $data)
        {
            $item[ $data ]="";
            if (isset($this->ItemData[ $data ][ "Default" ]))
            {
                $item[ $data ]=$this->ItemData[ $data ][ "Default" ];
            }
        }

        unset($item[ "ID" ]);
        
        return $item;
    }
}

?>