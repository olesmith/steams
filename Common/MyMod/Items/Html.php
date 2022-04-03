<?php


trait MyMod_Items_Html
{
    //* Creates table with $items
    //*

    function MyMod_Items_Html($edit,$title,$emptytitle,$items,$datas,$options=array())
    {
        if (empty($items))
        {
            return
                $this->Div($emptytitle,array("CLASS" => 'errors'));
        }

        return
            array
            (
                $this->H(3,$title),
                $this->MyMod_Items_Table
                (
                    $edit,$items,$datas,
                    $options
                )
            );
    }
    
    //*
    //* Creates table with $items. No leading title.
    //*

    function MyMod_Items_Table_Html($edit,$items,$datas,$options=array(),$troptions=array(),$tdoptions=array())
    {
        if (!is_array($datas))
        {
            $datas=$this->ItemDataGroups($datas,"Data");
        }
        
        $plural=FALSE;
        if (!empty($options[ "Plural" ]))
        {
            $plural=TRUE; unset($options[ "Plural" ]);
        }

        return
            $this->Htmls_Table
            (
                array
                (
                    $this->MyMod_Item_Titles($datas)
                ),
                $this->MyMod_Items_Table
                (
                    $edit,$items,$datas,
                    array("Plural" => $plural)
                ),
                $options,$troptions,$tdoptions
            );
    }    
}

?>