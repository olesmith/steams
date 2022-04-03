<?php

include_once("Items/Latex.php");
include_once("Items/Read.php");
include_once("Items/GroupTable.php");
include_once("Items/Post.php");
include_once("Items/Update.php");
#include_once("Items/Emails.php");

class Items extends ItemsUpdate
{

    //*
    //* Variables of Items class:

    //*
    //* function InitItems, Parameter list: $hash=array()
    //*
    //* Items initializer. Currently does nothing.
    //*

    function InitItems($hash=array())
    {
    }




    //*
    //* function FilterItems, Parameter list: $text,$items=array()
    //*
    //* Filters text over all items in $items. If $items is empty (default), 
    //* uses $this->ItemHashes. Calls $this->Filter and $this->FilterHash on each item.
    //* Returns list of filteres texts, one for each item.
    //*


    function FilterItems($text,$items=array())
    {
        if (count($items)>0) {} else { $items=$this->ItemHashes; }

        $texts=array();
        $nn=1;
        foreach ($items as $hash)
        {
            $hash=$this->ApplyEnums($hash);
            $vars[ "N" ]=sprintf("%02d",$nn);
            $rtext=$this->Filter($text,$hash);
            $rtext=$this->FilterHash($rtext,$vars);
            array_push($texts,$rtext);

            $nn++;
        }

        return $texts;
    }



 

    //*
    //* function ItemsDataValues, Parameter list: $data,$items=array()
    //*
    //* Returns the (different) values of key $data in $items.
    //*

    function ItemsDataValues($data,$items=array())
    {
        $values=array();
        foreach ($items as $id => $item)
        {
            $value=$item[ $data ];
            if (!preg_grep('/^$value$/',$values))
            {
                array_push($values,$value);
            }
        }

        return $values;
    }

    //*
    //* function ItemsWithDataValue, Parameter list: $data,$value,$items=array()
    //*
    //* Returns the list of items in $items, whos key $data has value $value.
    //*

    function ItemsWithDataValue($data,$value,$items=array())
    {
        if (count($items)==0) { $items=$this->ItemHashes; }

        $ritems=array();
        foreach ($items as $id => $item)
        {
            if ($value==$item[ $data ])
            {
                array_push($ritems,$item);
            }
        }

        return $ritems;
    }

    //*
    //* function SplitItemsOnData, Parameter list: $data,$items=array()
    //*
    //* Splits items, based on data $data, that is an ass. array,
    //* with $data actual values as keys, and list of
    //* items with the key value as value.
    //*

    function SplitItemsOnData($data,$items=array())
    {
        if (count($items)==0) { $items=$this->ItemHashes; }

        $ritems=array();
        foreach ($this->ItemsDataValues($data,$items) as $id => $value)
        {
            $ritems[ $value ]=$this->ItemsWithDataValue($data,$value,$items);
        }

        return $ritems;
    }

    function MakeCheckAllLinks()
    {
        $href=$this->ThisCGI_Script_Exec();
        $href=preg_replace('/&CheckAll=-?[01]/',"",$href);

        return
            $this->A($href."&CheckAll=1","+").
            "/".
            $this->A($href."&CheckAll=-1","-");
    }



    //*
    //* function MakeItemsSelect, Parameter list: $name,$items=array(),$selectedid=""
    //*
    //* Creates a select correszponding to the items in $items (or if
    //* empty in $this->ItemHashes).
    //* Includes options with IDs as $item[ "ID" ], sorted according to
    //* $this->Sort() - and named as returned by $this->ItemName();
    //*

    function MakeItemsSelect($name,$items=array(),$selectedid="")
    {
        if (count($items)==0) { $items=$this->ItemHashes; }

        $this->MyMod_Sort_Items();

        $ids=array(0);
        $names=array("");
        foreach ($items as $id => $item)
        {
            $item=$this->MyMod_Data_Fields_Enums_ApplyAll($item);

            array_push($ids,$item[ "ID" ]);
            array_push
            (
               $names,
               $this->MyMod_Item_Name_Get($item)
            );
        }

        
        return $this->MakeSelectField($name,$ids,$names,$selectedid);
   }

    //*
    //* function GetItemsValues, Parameter list: $datas
    //*
    //* Returns values of datas in $datas, foreach item in ItemHashes.
    //* Manintains unicity, using associated list: $key => $key.
    //*

    function GetItemsValues($datas)
    {
        $vals=array();
        foreach ($datas as $data)
        {
            $vals[ $data ]=array();
        }

        foreach ($this->ItemHashes as $item)
        {
            foreach ($datas as $data)
            {
                $vals[ $data ][ $item[ $data ] ]=$item[ $data ];
            }
        }

        return $vals;
    }

    //*
    //* function Items2ListByKey, Parameter list: $key
    //*
    //* Takes ItemHashes and orders it by $key sublists.
    //*
    //* array(
    //*    key1 =>  array(item12,item12,...),
    //*    key2 =>  array(item21,item22,...),
    //* );
    //*

    function Items2ListByKey($key,$subkey=NULL)
    {
        $sublists=array();
        foreach ($this->ItemHashes as $item)
        {
            if (!isset($sublists[ $item[ $key ] ]))
            {
                $sublists[ $item[ $key ] ]=array();
            }

            if ($subkey)
            {
                $sublists[ $item[ $key ] ][ $item[ $subkey ] ]=$item;
            }
            else
            {
                array_push($sublists[ $item[ $key ] ],$item);
            }
        }

        return $sublists;
    }




}
?>