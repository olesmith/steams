<?php


trait MyMod_Items_SQL
{
    //*
    //* Exports and writes items in SQL.
    //*

    function MyMod_Items_SQL_Table($items=array(),$datas=array())
    {
        $this->ApplicationObj()->SetLatexMode();

        $text=
            $this->MyMod_Items_SQL($items,$datas);

        $this->MyMod_Doc_Header_Send
        (
            "php",
            $this->ModuleName.".".$this->MTime2FName().".sql",
            "utf-8"
        );
        
        echo $text;        
        exit();
        return $text;
    }
    //*
    //* Exports items to SQL.
    //*

    function MyMod_Items_SQL($items=array(),$datas=array())
    {
        if (empty($items)) { $items=$this->ItemHashes; }
        
        $texts=array();
        foreach ($items as $item)
        {
            array_push
            (
                $texts,
                $this->MyMod_Item_SQL($item,$datas)
            );
        }

        return
            join("\n",$texts).
            "\n";
    }
    
    //*
    //* Exports item to .
    //*

    function MyMod_Item_SQL($item,$datas=array())
    {
        if (empty($datas)) { $datas=array_keys($item); }

        // Makes no sense to apply enums,
        // as it destroys relational and enum field values.
        /* $item=$this->MyMod_Data_Fields_Enums_ApplyAll($item,TRUE); */
        
        $item=$this->MyMod_Item_Latex_Trim($item);
        foreach ($datas as $data)
        {
            $value=$item[ $data ];

            $value=$this->Html2Text($value);
            $value=preg_replace('/^\s+/',"",$value);
            $value=preg_replace('/\s+$/',"",$value);
            $value=preg_replace('/\s+/'," ",$value);
            $value=preg_replace('/\\\\_/',"_",$value);
            $item[ $data ]=$value;
        }
        

        return
            $this->Sql_Insert_Item_Query($item).
            ";";
    }
}

?>