<?php


trait MyMod_Items_JSON
{
    //*
    //* Exports and writes items in JSON.
    //*

    function MyMod_Items_JSON_Table($datas=array(),$items=array())
    {
        if (empty($datas)) { $datas=array_keys($this->ItemData); }
        
        $this->ApplicationObj()->SetLatexMode();

        $text=
            $this->MyMod_Items_JSON($datas,$items);

        $this->JSON_Content_Type_Send();
        
        echo $text;        
        exit();
        return $text;
    }
    
    //*
    //* Exports items to JSON.
    //*

    function MyMod_Items_JSON($datas,$items=array())
    {
        if (empty($items)) { $items=$this->ItemHashes; }

        $this->MyMod_Data_Fields_Sql_SubItems_Read($items,$datas);

        $texts=array();
        foreach ($items as $item)
        {
            array_push
            (
                $texts,
                $this->MyMod_Item_JSON($datas,$item)
            );
        }

        return
            "{\"".$this->ModuleName."\":\n".
            "   [\n".
            join(",\n",$texts)."\n".
            "   ]\n".
            "}\n".
            "";
    }
    
    //*
    //* Exports one $item to JSON.
    //*

    function MyMod_Item_JSON($datas,$item)
    {
        $item=
            $this->MyMod_Item_Latex_Trim
            (
                $this->MyMod_Data_Fields_Enums_ApplyAll
                (
                    $item,
                    TRUE,array(),
                    False //do not read sql subitems
                )
            );
                
        $empty="   ";
        $text=$empty.$empty."{\n";
        foreach (array_keys($item) as $data)
        {
            //if (empty($item[ $data ])) { continue; }
            
            $value=$item[ $data ];

            $value=$this->Html2Text($value);
            $value=preg_replace('/^\s+/',"",$value);
            $value=preg_replace('/\s+$/',"",$value);
            $value=preg_replace('/\s+/'," ",$value);
            $value=preg_replace('/\\\\_/',"_",$value);
            $text.=
                $empty.$empty.$empty.
                '"'.$data.'"'.
                ": ".
                '"'.$value.'",'.
                "\n";
        }
        
        /*     $rdata=$data."_ID"; */
        /*     if (!empty($item[ $rdata ])) */
        /*     { */
        /*         $text.= */
        /*             $empty.$empty.$empty. */
        /*             '"'.$rdata.'"'. */
        /*             ": ". */
        /*             '"'.$item[ $rdata ].'",'. */
        /*             "\n"; */
        /*     } */
            
        /*     $rrdata=$data."_Orig"; */
        /*     if (!empty($item[ $rrdata ])) */
        /*     { */
        /*         $text.= */
        /*             $empty.$empty.$empty. */
        /*             '"'.$rdata.'"'. */
        /*             ": ". */
        /*             '"'.$item[ $rrdata ].'",'. */
        /*             "\n"; */
        /*     } */
        /* } */

        //JSON disallows trailing comma
        $text=preg_replace('/,\n$/',"\n",$text);
        
        $text.=$empty.$empty."}";

        return $text;
    }
}

?>